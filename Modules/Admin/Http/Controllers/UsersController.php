<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use Illuminate\Routing\Controller;
use Illuminate\Mail\Message;
use Illuminate\Http\Request;
use App\Mail\RegisterInvitation;
use Yajra\Datatables\Datatables;
use App\Authorizable;
use Session;
Use Auth;
use Mail;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;
use App\Timezone;
use App\Dataset;
/**
 * UsersController
 */
class UsersController extends Controller
{
    /**
     * Display a listing of the users.
     * @return Renderable
     */
    use Authorizable;
    public $datasets;

    public function __construct(){
        $this->datasets = Dataset::latest()->get();
    }
    
    public function index()
    {
        $datasets = $this->datasets;
        $users = User::latest()->get();
        return view('admin::user.view', compact('users', 'datasets'));
    }

    /**
     * Return datatable format json for user listing
     * @return json
     */
    public function datatable()
    {
        if(Auth::user()->hasRole('Manager')){
            $users = User::with('roles')->role(['Analyst', 'Supervisor'])->get()->except(Auth::id());
        }else{
            $users = User::with('roles')->role(['Manager', 'Analyst', 'Supervisor'])->get()->except(Auth::id());
        }
        
        
        return Datatables::of($users)
            ->editColumn('created_at', function ($user) {
                return [
                    'display' => e($user->created_at->format('d M Y')),
                    'timestamp' => $user->created_at->timestamp
                ];
            })->addColumn('roles', function ($user) {
                if($user->roles->first()->name == 'Admin'){
                    return '<span class="badge badge-success m-2">'.$user->roles->first()->name.'</span>';
                }elseif($user->roles->first()->name == 'Manager'){
                    return '<span class="badge badge-info m-2">'.$user->roles->first()->name.'</span>';
                }elseif($user->roles->first()->name == 'Analyst'){
                    return '<span class="badge badge-warning m-2">'.$user->roles->first()->name.'</span>';
                }else{
                    return '<span class="badge badge-danger m-2">'.$user->roles->first()->name.'</span>';
                }
            })->rawColumns(['roles'])->make(true);
    }

    /**
     * Show the form for creating a new user.
     * @return Renderable
     */
    public function create()
    {  
        $dataset = $this->dataset;
        //Getting Current Login User
        $currentUser = Auth::user();

        //Using the user we are getting it's role id
        $current_role_id = $currentUser->roles->pluck('id')->toArray();
        $timezones = Timezone::Orderby('offset')->pluck('name', 'name');
        // If manager then only send analyst id 
        // IF not manager (then admin) we are sending both manager and analyst binding into an array
        if($currentUser->hasRole('Manager')){
            $roles = Role::all()->except([1, 2])->pluck('name', 'id');
        }else{
            $roles = Role::all()->except($current_role_id[0])->pluck('name', 'id');
        }
        return view('admin::user.add', compact('roles', 'timezones', 'dataset'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //Validation Checks for the form fields
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:120',
            'email' => 'required|unique:users|email',
            'phone_no' => 'required|numeric',
            'roles' => 'required|min:1'
        ]);

        //If validation fails then redirect back to the same page
        if (!$validator->fails()) {
            // Create the user
            
            if($request->isSuperAdmin == true){
                $request->roles = 4;
            }

            if ( $user = User::create($request->except('roles', 'permissions')) )
            {
                //Syncing Permissions of the user created
                $this->syncPermissions($request, $user);

                //Generating token for reset password
                $token = Password::getRepository()->create($user);

                //Sending an email to reset password on registered user email
                Mail::to($user->email)->send(new RegisterInvitation($user, $token));

                //Send back to the view page with a message 
                flash('User has been invited to join.')->success();
            }
            else{
                flash('Failed to create user.')->error();
            }
        } else {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        return redirect()->route('users.index');       
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $datasets = $this->datasets;
        $user = User::find($id);
        $currentUserRole = $user->roles->pluck('id');
    
        //Using the user we are getting it's role id
        $role_id = Auth::user()->roles->pluck('id')->toArray();
        $timezones = Timezone::Orderby('offset')->pluck('name', 'name');
        // If manager then only send analyst id 
        // else not manager (then admin) we are sending both manager and analyst binding into an array
        if(Auth::user()->hasRole('Manager')){
            $roles = Role::all()->except([1, 2])->pluck('name', 'id');
        }else{ 
            $roles = Role::all()->except($role_id[0])->pluck('name', 'id');
        }
        return view('admin::user.edit', compact('user', 'roles', 'timezones', 'currentUserRole', 'datasets'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:120',
            'phone_no' => 'required|numeric',
            'roles' => 'required|min:1',
        ]);

        if (!$validator->fails()) {
            $user = User::findOrFail($id);
            
            // Update user
            $user->fill($request->except('roles', 'permissions'));
            // Handle the user roles


            $this->syncPermissions($request, $user);

            if($user->save())
            {
                flash('User has been updated.')->success();
            }
            else{
                flash('User failed to update.')->error();
            }
        } 
        else {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        if ( Auth::user()->id == $id ) {
            flash()->warning('Deletion of currently logged in user is not allowed :(')->important();
            return redirect()->back();
        }
        $user = User::hasSomePendingTask($id)->get();
        //$user->isEmpty() defines that the user doesn't some any pending task or all the task assgined to him are completed  

        if($user->isEmpty()){

            if( User::findOrFail($id)->delete() ) {
                return response()->json(['success' => true ,'message' => 'Deactive successfully']);
               
            } else {
                return response()->json(['error' => true ,'message' => 'Failed to deactivate']);
            }
        }
        else 
        return response()->json(['error' => true ,'message' => 'Unable to deactivate , this user has some pending tasks']);
    }

    public function deleted_users(){
        $datasets = $this->datasets;
        $users = User::onlyTrashed()->get();
        
        return view('admin::user.deleted_user', compact('users', 'datasets'));
    }
    
    /**
     * deleted_users
     *
     * @return void
     */
    public function deleted_user_datatable(){
        $users = User::with('roles')->role(['Manager', 'Analyst'])->onlyTrashed()->get()->except(Auth::id());
        return Datatables::of($users)
            ->editColumn('created_at', function ($user) {
                return [
                    'display' => e($user->created_at->format('d M Y')),
                    'timestamp' => $user->created_at->timestamp
                ];
            })->editColumn('deleted_at', function ($user) {
                return [
                    'display' => e($user->deleted_at->format('d M Y')),
                    'timestamp' => $user->deleted_at->timestamp
                ];
            })->addColumn('roles', function ($user) {
                if($user->roles->first()->name == 'Admin'){
                    return '<span class="badge badge-success m-2">'.$user->roles->first()->name.'</span>';
                }elseif($user->roles->first()->name == 'Manager'){
                    return '<span class="badge badge-info m-2">'.$user->roles->first()->name.'</span>';
                }else{
                    return '<span class="badge badge-warning m-2">'.$user->roles->first()->name.'</span>';
                }
            })->rawColumns(['roles'])->make(true);
    }
    
    /**
     * restore
     *
     * @param  mixed $id
     * @return void
     */
    public function restore($id)
    {
        if ( Auth::user()->id == $id ) {
            flash()->warning('Restore of currently logged in user is not allowed :(')->important();
            return redirect()->back();
        }

        if( User::onlyTrashed()->where('id', $id)->restore() ) {
            return 'success';
        } else {
            return 'error';
        }
    }
        
    /**
     * syncPermissions
     *
     * @param  mixed $request
     * @param  mixed $user
     * @return user
     */
    private function syncPermissions(Request $request, $user)
    {
        // Get the submitted roles
        $roles = $request->get('roles', []);
        
        $permissions = $request->get('permissions', []);
        
        // Get the roles
        $roles = Role::find($roles);
       

        // check for current role changes
        if( ! $user->hasAllRoles( $roles ) ) {
            // reset all direct permissions for user
            $user->permissions()->sync([]);
        } else {
            // handle permissions
            $user->syncPermissions($permissions);
        }

        $user->syncRoles($roles);
        return $user;
    }
}
