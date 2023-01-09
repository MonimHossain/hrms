<?php

use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // reset the permission table
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('permissions')->truncate();
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        // $permissions = [
        //     'Admin',
        //     'User',
        //     'Team Leader',
        // ];

        // foreach ($permissions as $permission) {
        //     Permission::create(
        //         [
        //             'name' => $permission,
        //         ]
        //     );
        // }

        // foreach(Role::all() as $role){
        //     if($role->name == "Admin"){
        //         $role->givePermissionTo("Admin");
        //     }
        //     if($role->name == "User"){
        //         $role->givePermissionTo("User" );
        //     }
        // }


        // Admin permission list
        $adminEmployeePermissions = [
            [
                'name'         => 'Employee List View',
                'module'       => 'Employee',
                'group'        => 'Admin Employee'
            ],
            [
                'name'         => 'Employee Profile View',
                'module'       => 'Employee',
                'group'        => 'Admin Employee'
            ],
            [
                'name'         => 'Employee Create',
                'module'       => 'Employee',
                'group'        => 'Admin Employee'
            ],
            [
                'name'         => 'Employee Edit',
                'module'       => 'Employee',
                'group'        => 'Admin Employee'
            ],
            [
                'name'         => 'Employee Delete',
                'module'       => 'Employee',
                'group'        => 'Admin Employee'
            ],
        ];

        $adminTeamPermissions = [

            [
                'name'         => 'Admin Team View',
                'module'       => 'Admin Team',
                'group'        => 'Admin Team'
            ],
            [
                'name'         => 'Admin Team Create',
                'module'       => 'Admin Team',
                'group'        => 'Admin Team'
            ],
            [
                'name'         => 'Admin Team Edit',
                'module'       => 'Admin Team',
                'group'        => 'Admin Team'
            ],
            [
                'name'         => 'Admin Team Delete',
                'module'       => 'Admin Team',
                'group'        => 'Admin Team'
            ],
        ];

        $adminLeavePermissions = [

            [
                'name'         => 'Admin Leave View',
                'module'       => 'Admin Leave',
                'group'        => 'Admin Leave'
            ],
            [
                'name'         => 'Admin Leave Create',
                'module'       => 'Admin Leave',
                'group'        => 'Admin Leave'
            ],
            [
                'name'         => 'Admin Leave Edit',
                'module'       => 'Admin Leave',
                'group'        => 'Admin Leave'
            ],
            [
                'name'         => 'Admin Leave Delete',
                'module'       => 'Admin Leave',
                'group'        => 'Admin Leave'
            ],
        ];

        $adminRosterAttendancePermissions = [
            [
                'name'         => 'Admin Roster View',
                'module'       => 'Roster CSV Upload',
                'group'        => 'Admin Roster Attendance'
            ],
            [
                'name'         => 'Admin Roster Create',
                'module'       => 'Roster CSV Upload',
                'group'        => 'Admin Roster Attendance'
            ],
            [
                'name'         => 'Admin Roster Edit',
                'module'       => 'Roster CSV Upload',
                'group'        => 'Admin Roster Attendance'
            ],
            [
                'name'         => 'Admin Roster Delete',
                'module'       => 'Roster CSV Upload',
                'group'        => 'Admin Roster Attendance'
            ],
            [
                'name'         => 'Admin Attendance View',
                'module'       => 'Attendance CSV Upload',
                'group'        => 'Admin Roster Attendance'
            ],
            [
                'name'         => 'Admin Attendance Create',
                'module'       => 'Attendance CSV Upload',
                'group'        => 'Admin Roster Attendance'
            ],
            [
                'name'         => 'Admin Attendance Edit',
                'module'       => 'Attendance CSV Upload',
                'group'        => 'Admin Roster Attendance'
            ],
            [
                'name'         => 'Admin Attendance Delete',
                'module'       => 'Attendance CSV Upload',
                'group'        => 'Admin Roster Attendance'
            ],
        ];

        $adminLetterAndDocumentPermissions = [
            [
                'name'         => 'Admin Letter And Documents View',
                'module'       => 'Admin Letter And Documents',
                'group'        => 'Admin Letter And Documents'
            ],
            [
                'name'         => 'Admin Letter And Documents Create',
                'module'       => 'Admin Letter And Documents',
                'group'        => 'Admin Letter And Documents'
            ],
            [
                'name'         => 'Admin Letter And Documents Edit',
                'module'       => 'Admin Letter And Documents',
                'group'        => 'Admin Letter And Documents'
            ],
            [
                'name'         => 'Admin Letter And Documents Delete',
                'module'       => 'Admin Letter And Documents',
                'group'        => 'Admin Letter And Documents'
            ],
        ];

        $adminNoticePermissions = [
            [
                'name'         => 'Admin Notice And Event View',
                'module'       => 'Admin Notice And Event',
                'group'        => 'Admin Notice And Event'
            ],
            [
                'name'         => 'Admin Notice And Event Create',
                'module'       => 'Admin Notice And Event',
                'group'        => 'Admin Notice And Event'
            ],
            [
                'name'         => 'Admin Notice And Event Edit',
                'module'       => 'Admin Notice And Event',
                'group'        => 'Admin Notice And Event'
            ],
            [
                'name'         => 'Admin Notice And Event Delete',
                'module'       => 'Admin Notice And Event',
                'group'        => 'Admin Notice And Event'
            ],
        ];

        $adminSettingsPermissions = [
            [
                'name'         => 'Role View',
                'module'       => 'Role',
                'group'        => 'Admin App Settings'
            ],
            [
                'name'         => 'Role Create',
                'module'       => 'Role',
                'group'        => 'Admin App Settings'
            ],
            [
                'name'         => 'Role Edit',
                'module'       => 'Role',
                'group'        => 'Admin App Settings'
            ],
            [
                'name'         => 'Role Delete',
                'module'       => 'Role',
                'group'        => 'Admin App Settings'
            ],
            [
                'name'         => 'Permission View',
                'module'       => 'Permission',
                'group'        => 'Admin App Settings'
            ],
            [
                'name'         => 'Permission Create',
                'module'       => 'Permission',
                'group'        => 'Admin App Settings'
            ],
            [
                'name'         => 'Permission Edit',
                'module'       => 'Permission',
                'group'        => 'Admin App Settings'
            ],
            [
                'name'         => 'Permission Delete',
                'module'       => 'Permission',
                'group'        => 'Admin App Settings'
            ],
            [
                'name'         => 'General Settings View',
                'module'       => 'General Settings',
                'group'        => 'Admin App Settings'
            ],
            [
                'name'         => 'General Settings Create',
                'module'       => 'General Settings',
                'group'        => 'Admin App Settings'
            ],
            [
                'name'         => 'General Settings Edit',
                'module'       => 'General Settings',
                'group'        => 'Admin App Settings'
            ],
            [
                'name'         => 'General Settings Delete',
                'module'       => 'General Settings',
                'group'        => 'Admin App Settings'
            ],
            [
                'name'         => 'Workflow Settings View',
                'module'       => 'Workflow Settings',
                'group'        => 'Admin App Settings'
            ],
            [
                'name'         => 'Workflow Settings Create',
                'module'       => 'Workflow Settings',
                'group'        => 'Admin App Settings'
            ],
            [
                'name'         => 'Workflow Settings Edit',
                'module'       => 'Workflow Settings',
                'group'        => 'Admin App Settings'
            ],
            [
                'name'         => 'Workflow Settings Delete',
                'module'       => 'Workflow Settings',
                'group'        => 'Admin App Settings'
            ],
        ];



        // User permissions lists
        $userTeamPermissions = [
            // [
            //     'name'         => 'User',
            //     'module'       => 'User',
            //     'group'        => 'User Permissions'
            // ],
            [
                'name'         => 'Team View',
                'module'       => 'Team',
                'group'        => 'User Permissions'
            ],
            [
                'name'         => 'Team Create',
                'module'       => 'Team',
                'group'        => 'User Permissions'
            ],
            [
                'name'         => 'Team Edit',
                'module'       => 'Team',
                'group'        => 'User Permissions'
            ],
            [
                'name'         => 'Team Delete',
                'module'       => 'Team',
                'group'        => 'User Permissions'
            ],
        ];

        $userSupervisorPermissions = [
            [
                'name'         => 'Supervisor View',
                'module'       => 'Supervisor',
                'group'        => 'User Permissions'
            ],
            [
                'name'         => 'Supervisor Create',
                'module'       => 'Supervisor',
                'group'        => 'User Permissions'
            ],
            [
                'name'         => 'Supervisor Edit',
                'module'       => 'Supervisor',
                'group'        => 'User Permissions'
            ],
            [
                'name'         => 'Supervisor Delete',
                'module'       => 'Supervisor',
                'group'        => 'User Permissions'
            ],
        ];

        $userRosterPermissions = [
            [
                'name'         => 'User Roster View',
                'module'       => 'Roster',
                'group'        => 'User Permissions'
            ],
            [
                'name'         => 'User Roster Create',
                'module'       => 'Roster',
                'group'        => 'User Permissions'
            ],
            [
                'name'         => 'User Roster Edit',
                'module'       => 'Roster',
                'group'        => 'User Permissions'
            ],
            [
                'name'         => 'User Roster Delete',
                'module'       => 'Roster',
                'group'        => 'User Permissions'
            ],
        ];

        $userAttendancePermissions = [
            [
                'name'         => 'User Attendance View',
                'module'       => 'Attendance',
                'group'        => 'User Permissions'
            ],
            [
                'name'         => 'User Attendance Create',
                'module'       => 'Attendance',
                'group'        => 'User Permissions'
            ],
            [
                'name'         => 'User Attendance Edit',
                'module'       => 'Attendance',
                'group'        => 'User Permissions'
            ],
            [
                'name'         => 'User Attendance Delete',
                'module'       => 'Attendance',
                'group'        => 'User Permissions'
            ],
        ];






        // merge all permissions
        $permissions = array_merge(
            //$adminEmployeePermissions,
            //$adminTeamPermissions,
            //$adminLeavePermissions,
            //$adminRosterAttendancePermissions,
            //$adminLetterAndDocumentPermissions,
            //$adminNoticePermissions,
            $adminSettingsPermissions
            //$userTeamPermissions,
            //$userSupervisorPermissions,
            //$userRosterPermissions,
            //$userAttendancePermissions
        );

        // insert permission into db
        Permission::insert($permissions);

        foreach (Role::all() as $role) {
            if ($role->name == "Super Admin") {
                //$role->syncPermissions($permissions);
                foreach ($permissions as $item) {
                    $role->givePermissionTo($item['name']);
                }
            }
        }

        // super admin Role
        $superAdmin = User::find(1);
        $superAdmin->syncRoles('Super Admin');

        //give permission to role
        // $userRole = Role::where('name', 'User')->first();
        // $userRole->givePermissionTo("User" );
    }
}
