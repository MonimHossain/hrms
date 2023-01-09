<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Division;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class ManagePermissionController extends Controller
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
        $active = 'manage-permission';
        $permissions = Permission::all();
        return view('admin.settings.security.manage-permission', compact('active', 'permissions'));
    }

    public function create(Request $request){
        $permission = new Permission();
        $permission->name = $request->name;

        if($permission->save()){
            toastr()->success('New Permission successfully created');
        }

        return redirect()->back();
    }

    public function default(){
        $divisions = Division::all();
        return view('admin.settings.security.defaults', compact('divisions'));
    }
}
