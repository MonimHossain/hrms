<?php

namespace App\Http\Controllers\Admin\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ManageRoleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    // role list view
    public function index(){
        $active = 'manage-role';
        $roles = Role::all();
        $permissions = Permission::all();
        return view('admin.settings.security.manage-role', compact('active', 'roles', 'permissions'));
    }

    public function addNewRoleView(Request $request){

        $active = 'manage-role';
        // $permissions =  Permission::all()->groupBy('module');
        $permissions = Permission::all()->reduce(function($permissions, $permission){
                $namePart = preg_split("/\s+(?=\S*+$)/",$permission->name);
                $verb = $namePart[1] ?? null;
                if($verb){
                    $permissions[$permission->group][$permission->module][$verb]['name'][] = $permission->name;
                }
                return $permissions;
        });
        // return $permissions;
        return view('admin.settings.security.add-new-role', compact('active', 'permissions'));
    }

    public function create(Request $request){

        // dd($request->all());

        $role = new Role();
        $role->name = $request->name;

        if($role->save()){
            toastr()->success('New Role successfully created');
        }

        return redirect()->back();
    }

    public function assignPermission(Request $request){
        $role = Role::findByName($request->input('role'));
        $role->syncPermissions($request->input('permissions'));
        return redirect()->back();
    }
}
