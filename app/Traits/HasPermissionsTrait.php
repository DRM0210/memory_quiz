<?php
namespace App\Traits;
use App\Models\Permission;
use App\Models\Role;

trait HasPermissionsTrait{

    //give permissions
    public function getAllPermissions($permission){
        return Permission::whereIn('slug',$permission)->get();
    }

    //check has permission
    public function hasPermission($permission){
        return (bool) $this->permissions->where('slug',$permission)->count();
    }

    public function permissions(){
        return $this->belongsToMany(Permission::class,'users_permissions');
    }

    public function roles(){ 
        return $this->belongsToMany(Role::class,'users_roles');
    }

    // check has role
    public function hasRoles(...$roles){
        foreach($roles as $role){
            if($this->roles->contains('slug',$role)){
                return true;
            }
            return false;
        }
    }

    public function hasPermissionTO($permission){
        return $this->hasPermissionThroughRole($permission) || $this->hasPermission($permission);
    }

    public function givePermissionTo(...$permissions){
        $permissions = $this->getAllPermissions($permissions);
        if($permissions == null){
            return $this;
        }
        return $this->permissions()->saveMany($permissions);
    }

    public function hasPermissionThroughRole($permission){
        foreach($permission->roles as $role){
            if($this->roles->contains($role)){
                return true;
            }
            return false;
        }
    }

}