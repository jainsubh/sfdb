<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Pluralizer;
use Spatie\Permission\Exceptions\UnauthorizedException;

trait Authorizable
{
    private $permissions = [
        'index'   => 'view',
        'create'   => 'create',
        'store'   => 'create',
        'show'    => 'view',
        'edit'  => 'edit',
        'update'  => 'edit',
        'destroy' => 'delete'
    ];

    private $action;

    public function callAction($method, $parameters){

        $permission = $this->getPermission($method);

        if(($permission && Auth::user()->can($permission)) || !$permission){
            return parent::callAction($method, $parameters);
        }
        if(Request::ajax()) {
            return response()->json([
                'response' => str_slug($permission.'_not_allowed', '_')
            ], 403);
        }

        throw UnauthorizedException::forPermissions([$permission]);
    }

    public function getPermission($method){
        if(!$this->action = \Arr::get($this->getPermissions(), $method)){
             return null;
        }
        
        return  $this->routeName() ?  $this->actionRoute() : $this->action;
    }

    public function registerActionPermission($action, $permission) {
        $this->permissions[$action] = $permission;
    }

    private function actionRoute() {
        return $this->action . '_' . $this->routeName();
    }

    private function routeName() {
        return explode('.', Request::route()->getName())[0];
    }

    private function getPermissions(){
        return $this->permissions;
    }
}