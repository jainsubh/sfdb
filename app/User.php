<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Tasks;
use App\Event;
use App\Tasklog;


class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use SoftDeletes;
    use HasRoles;
    use LogsActivity;

    protected static $logName = 'users_log';
    protected static $ignoreChangedAttributes = ['remember_token','two_factor_code', 'updated_at'];
    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['name', 'email', 'password', 'phone_no', 'timezone'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone_no', 'timezone'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','two_factor_code'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'two_factor_expires_at' => 'datetime'
    ];

    protected static $logFillable = true;
    
    /**
     * generateTwoFactorCode
     * generate random 6 digit number to be send in the email valid only for 10 minutes 
     * @return void
     */
    public function generateTwoFactorCode()
    {
        $this->timestamps = false;
        $this->two_factor_code = rand(100000, 999999);
        $this->two_factor_expires_at = now()->addMinutes(10);
        $this->save();
    }
    
    /**
     * resetTwoFactorCode
     * After verifying twoFactorCode clean the previous send code
     * @return void
     */
    public function resetTwoFactorCode()
    {
        $this->timestamps = false;
        $this->two_factor_code = null;
        $this->two_factor_expires_at = null;
        $this->save();
    }

    public function tasks_log(){
        return $this->hasMany(Tasklog::class, 'assigned_to', 'id')->latest();
    }

    public function events()
    {
        return $this->belongsToMany(Event::class);
    }

    public function scopeHasSomePendingTask($query, $id){
        $query->whereHas('tasks_log', function ($query) use ($id){
            $query->whereHas('tasks', function ($q){
                $q->where('status','!=','complete');
            })->where('assigned_to', $id);
        });
    }

}
