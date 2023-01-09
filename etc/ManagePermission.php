<?php

namespace Etc;

class ManagePermission{

    public $division, $center;

    public function __construct($division, $center)
    {
        $this->division = $division;
        $this->center = $center;
    }

    public function generatePermission()
    {
        // Admin permission list
        $adminEmployeePermissions = [
            [
                'name'         => $this->division.' '.$this->center.' '.'Employee List View',
                'module'       => 'Employee',
                'group'        => $this->division.' '.$this->center.' '.'Admin Employee',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Employee Profile View',
                'module'       => 'Employee',
                'group'        => $this->division.' '.$this->center.' '.'Admin Employee',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Employee Create',
                'module'       => 'Employee',
                'group'        => $this->division.' '.$this->center.' '.'Admin Employee',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Employee Edit',
                'module'       => 'Employee',
                'group'        => $this->division.' '.$this->center.' '.'Admin Employee',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Employee Delete',
                'module'       => 'Employee',
                'group'        => $this->division.' '.$this->center.' '.'Admin Employee',
                'division'     => $this->division,
                'center'       => $this->center
            ],

            //impersonate
            [
                'name'         => $this->division.' '.$this->center.' '.'Employee Impersonate View',
                'module'       => 'Impersonate',
                'group'        => $this->division.' '.$this->center.' '.'Admin Employee',
                'division'     => $this->division,
                'center'       => $this->center
            ],

        ];

        $adminTeamPermissions = [

            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Team View',
                'module'       => 'Admin Team',
                'group'        => $this->division.' '.$this->center.' '.'Admin Team',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Team Create',
                'module'       => 'Admin Team',
                'group'        => $this->division.' '.$this->center.' '.'Admin Team',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Team Edit',
                'module'       => 'Admin Team',
                'group'        => $this->division.' '.$this->center.' '.'Admin Team',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Team Delete',
                'module'       => 'Admin Team',
                'group'        => $this->division.' '.$this->center.' '.'Admin Team',
                'division'     => $this->division,
                'center'       => $this->center
            ],
        ];

        $adminLeavePermissions = [

            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Leave View',
                'module'       => 'Admin Leave',
                'group'        => $this->division.' '.$this->center.' '.'Admin Leave',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Leave Create',
                'module'       => 'Admin Leave',
                'group'        => $this->division.' '.$this->center.' '.'Admin Leave',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Leave Edit',
                'module'       => 'Admin Leave',
                'group'        => $this->division.' '.$this->center.' '.'Admin Leave',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Leave Delete',
                'module'       => 'Admin Leave',
                'group'        => $this->division.' '.$this->center.' '.'Admin Leave',
                'division'     => $this->division,
                'center'       => $this->center
            ],



            [
                'name'         => $this->division . ' ' . $this->center . ' ' . 'Admin Leave Approval View',
                'module'       => 'Admin Leave Approval',
                'group'        => $this->division . ' ' . $this->center . ' ' . 'Admin Leave',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division . ' ' . $this->center . ' ' . 'Admin Leave Approval Create',
                'module'       => 'Admin Leave Approval',
                'group'        => $this->division . ' ' . $this->center . ' ' . 'Admin Leave',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division . ' ' . $this->center . ' ' . 'Admin Leave Approval Edit',
                'module'       => 'Admin Leave Approval',
                'group'        => $this->division . ' ' . $this->center . ' ' . 'Admin Leave',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division . ' ' . $this->center . ' ' . 'Admin Leave Approval Delete',
                'module'       => 'Admin Leave Approval',
                'group'        => $this->division . ' ' . $this->center . ' ' . 'Admin Leave',
                'division'     => $this->division,
                'center'       => $this->center
            ],
        ];

        $adminRosterAttendancePermissions = [
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Roster View',
                'module'       => 'Roster CSV Upload',
                'group'        => $this->division.' '.$this->center.' '.'Admin Roster Attendance',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Roster Create',
                'module'       => 'Roster CSV Upload',
                'group'        => $this->division.' '.$this->center.' '.'Admin Roster Attendance',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Roster Edit',
                'module'       => 'Roster CSV Upload',
                'group'        => $this->division.' '.$this->center.' '.'Admin Roster Attendance',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Roster Delete',
                'module'       => 'Roster CSV Upload',
                'group'        => $this->division.' '.$this->center.' '.'Admin Roster Attendance',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Attendance View',
                'module'       => 'Attendance CSV Upload',
                'group'        => $this->division.' '.$this->center.' '.'Admin Roster Attendance',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Attendance Create',
                'module'       => 'Attendance CSV Upload',
                'group'        => $this->division.' '.$this->center.' '.'Admin Roster Attendance',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Attendance Edit',
                'module'       => 'Attendance CSV Upload',
                'group'        => $this->division.' '.$this->center.' '.'Admin Roster Attendance',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Attendance Delete',
                'module'       => 'Attendance CSV Upload',
                'group'        => $this->division.' '.$this->center.' '.'Admin Roster Attendance',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Employee Hours View',
                'module'       => 'Employee Hours Upload',
                'group'        => $this->division.' '.$this->center.' '.'Admin Roster Attendance',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Employee Hours Create',
                'module'       => 'Employee Hours Upload',
                'group'        => $this->division.' '.$this->center.' '.'Admin Roster Attendance',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Employee Hours Edit',
                'module'       => 'Employee Hours Upload',
                'group'        => $this->division.' '.$this->center.' '.'Admin Roster Attendance',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Employee Hours Delete',
                'module'       => 'Employee Hours Upload',
                'group'        => $this->division.' '.$this->center.' '.'Admin Roster Attendance',
                'division'     => $this->division,
                'center'       => $this->center
            ],
        ];

        $adminLetterAndDocumentPermissions = [
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Letter And Documents View',
                'module'       => 'Admin Letter And Documents',
                'group'        => $this->division.' '.$this->center.' '.'Admin Letter And Documents',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Letter And Documents Create',
                'module'       => 'Admin Letter And Documents',
                'group'        => $this->division.' '.$this->center.' '.'Admin Letter And Documents',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Letter And Documents Edit',
                'module'       => 'Admin Letter And Documents',
                'group'        => $this->division.' '.$this->center.' '.'Admin Letter And Documents',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Letter And Documents Delete',
                'module'       => 'Admin Letter And Documents',
                'group'        => $this->division.' '.$this->center.' '.'Admin Letter And Documents',
                'division'     => $this->division,
                'center'       => $this->center
            ],
        ];

        $adminNoticePermissions = [
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Notice And Event View',
                'module'       => 'Admin Notice And Event',
                'group'        => $this->division.' '.$this->center.' '.'Admin Notice And Event',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Notice And Event Create',
                'module'       => 'Admin Notice And Event',
                'group'        => $this->division.' '.$this->center.' '.'Admin Notice And Event',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Notice And Event Edit',
                'module'       => 'Admin Notice And Event',
                'group'        => $this->division.' '.$this->center.' '.'Admin Notice And Event',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Notice And Event Delete',
                'module'       => 'Admin Notice And Event',
                'group'        => $this->division.' '.$this->center.' '.'Admin Notice And Event',
                'division'     => $this->division,
                'center'       => $this->center
            ],
        ];

        $adminSalaryPermissions = [
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Salary View',
                'module'       => 'Salary',
                'group'        => $this->division.' '.$this->center.' '.'Admin Payroll',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Salary Create',
                'module'       => 'Salary',
                'group'        => $this->division.' '.$this->center.' '.'Admin Payroll',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Salary Edit',
                'module'       => 'Salary',
                'group'        => $this->division.' '.$this->center.' '.'Admin Payroll',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Salary Delete',
                'module'       => 'Salary',
                'group'        => $this->division.' '.$this->center.' '.'Admin Payroll',
                'division'     => $this->division,
                'center'       => $this->center
            ],
        ];


        $adminPermanentSalaryPermissions = [
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Permanent Salary View',
                'module'       => 'Salary',
                'group'        => $this->division.' '.$this->center.' '.'Admin Permanent Payroll',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Permanent Salary Create',
                'module'       => 'Salary',
                'group'        => $this->division.' '.$this->center.' '.'Admin Permanent Payroll',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Permanent Salary Edit',
                'module'       => 'Salary',
                'group'        => $this->division.' '.$this->center.' '.'Admin Permanent Payroll',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Permanent Salary Delete',
                'module'       => 'Salary',
                'group'        => $this->division.' '.$this->center.' '.'Admin Permanent Payroll',
                'division'     => $this->division,
                'center'       => $this->center
            ],
        ];

        $adminSalaryAdjustmentPermissions = [
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Salary Adjustment View',
                'module'       => 'Salary Adjustment',
                'group'        => $this->division.' '.$this->center.' '.'Admin Payroll',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Salary Adjustment Create',
                'module'       => 'Salary Adjustment',
                'group'        => $this->division.' '.$this->center.' '.'Admin Payroll',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Salary Adjustment Edit',
                'module'       => 'Salary Adjustment',
                'group'        => $this->division.' '.$this->center.' '.'Admin Payroll',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Salary Adjustment Delete',
                'module'       => 'Salary Adjustment',
                'group'        => $this->division.' '.$this->center.' '.'Admin Payroll',
                'division'     => $this->division,
                'center'       => $this->center
            ],
        ];

        $adminSalaryHoldPermissions = [
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Salary Hold View',
                'module'       => 'Salary Hold',
                'group'        => $this->division.' '.$this->center.' '.'Admin Payroll',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Salary Hold Create',
                'module'       => 'Salary Hold',
                'group'        => $this->division.' '.$this->center.' '.'Admin Payroll',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Salary Hold Edit',
                'module'       => 'Salary Hold',
                'group'        => $this->division.' '.$this->center.' '.'Admin Payroll',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Salary Hold Delete',
                'module'       => 'Salary Hold',
                'group'        => $this->division.' '.$this->center.' '.'Admin Payroll',
                'division'     => $this->division,
                'center'       => $this->center
            ],
        ];

        $adminSalaryBonusPermissions = [
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Salary Bonus View',
                'module'       => 'Bonus',
                'group'        => $this->division.' '.$this->center.' '.'Admin Payroll',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Salary Bonus Create',
                'module'       => 'Bonus',
                'group'        => $this->division.' '.$this->center.' '.'Admin Payroll',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Salary Bonus Edit',
                'module'       => 'Bonus',
                'group'        => $this->division.' '.$this->center.' '.'Admin Payroll',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Salary Bonus Delete',
                'module'       => 'Bonus',
                'group'        => $this->division.' '.$this->center.' '.'Admin Payroll',
                'division'     => $this->division,
                'center'       => $this->center
            ],
        ];

        $adminKPIPermissions = [
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin KPI View',
                'module'       => 'KPI',
                'group'        => $this->division.' '.$this->center.' '.'Admin Payroll',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin KPI Create',
                'module'       => 'KPI',
                'group'        => $this->division.' '.$this->center.' '.'Admin Payroll',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin KPI Edit',
                'module'       => 'KPI',
                'group'        => $this->division.' '.$this->center.' '.'Admin Payroll',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin KPI Delete',
                'module'       => 'KPI',
                'group'        => $this->division.' '.$this->center.' '.'Admin Payroll',
                'division'     => $this->division,
                'center'       => $this->center
            ],
        ];

        $adminTaxPermissions = [
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Tax View',
                'module'       => 'Tax',
                'group'        => $this->division.' '.$this->center.' '.'Admin Payroll',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Tax Create',
                'module'       => 'Tax',
                'group'        => $this->division.' '.$this->center.' '.'Admin Payroll',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Tax Edit',
                'module'       => 'Tax',
                'group'        => $this->division.' '.$this->center.' '.'Admin Payroll',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Tax Delete',
                'module'       => 'Tax',
                'group'        => $this->division.' '.$this->center.' '.'Admin Payroll',
                'division'     => $this->division,
                'center'       => $this->center
            ],
        ];

        $adminProvidentFundPermissions = [
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Provident Fund View',
                'module'       => 'Provident Fund',
                'group'        => $this->division.' '.$this->center.' '.'Admin Payroll',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Provident Fund Create',
                'module'       => 'Provident Fund',
                'group'        => $this->division.' '.$this->center.' '.'Admin Payroll',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Provident Fund Edit',
                'module'       => 'Provident Fund',
                'group'        => $this->division.' '.$this->center.' '.'Admin Payroll',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Provident Fund Delete',
                'module'       => 'Provident Fund',
                'group'        => $this->division.' '.$this->center.' '.'Admin Payroll',
                'division'     => $this->division,
                'center'       => $this->center
            ],
        ];

        $adminLoanPermissions = [
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Loan View',
                'module'       => 'Loan',
                'group'        => $this->division.' '.$this->center.' '.'Admin Payroll',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Loan Create',
                'module'       => 'Loan',
                'group'        => $this->division.' '.$this->center.' '.'Admin Payroll',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Loan Edit',
                'module'       => 'Loan',
                'group'        => $this->division.' '.$this->center.' '.'Admin Payroll',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Loan Delete',
                'module'       => 'Loan',
                'group'        => $this->division.' '.$this->center.' '.'Admin Payroll',
                'division'     => $this->division,
                'center'       => $this->center
            ],
        ];


        $adminEmployeeHourPermissions = [
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Employee Hour View',
                'module'       => 'Employee Hour',
                'group'        => $this->division.' '.$this->center.' '.'Admin Payroll',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Employee Hour Create',
                'module'       => 'Employee Hour',
                'group'        => $this->division.' '.$this->center.' '.'Admin Payroll',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Employee Hour Edit',
                'module'       => 'Employee Hour',
                'group'        => $this->division.' '.$this->center.' '.'Admin Payroll',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Employee Hour Delete',
                'module'       => 'Employee Hour',
                'group'        => $this->division.' '.$this->center.' '.'Admin Payroll',
                'division'     => $this->division,
                'center'       => $this->center
            ],
        ];

        $adminAssetsPermissions = [
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Asset View',
                'module'       => 'Asset',
                'group'        => $this->division.' '.$this->center.' '.'Admin Asset',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Asset Create',
                'module'       => 'Asset',
                'group'        => $this->division.' '.$this->center.' '.'Admin Asset',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Asset Edit',
                'module'       => 'Asset',
                'group'        => $this->division.' '.$this->center.' '.'Admin Asset',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Asset Delete',
                'module'       => 'Asset',
                'group'        => $this->division.' '.$this->center.' '.'Admin Asset',
                'division'     => $this->division,
                'center'       => $this->center
            ],
        ];

        $adminResourceLibraryPermissions = [
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Resource Library View',
                'module'       => 'Resource Library',
                'group'        => $this->division.' '.$this->center.' '.'Admin Resource Library',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Resource Library Create',
                'module'       => 'Resource Library',
                'group'        => $this->division.' '.$this->center.' '.'Admin Resource Library',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Resource Library Edit',
                'module'       => 'Resource Library',
                'group'        => $this->division.' '.$this->center.' '.'Admin Resource Library',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Resource Library Delete',
                'module'       => 'Resource Library',
                'group'        => $this->division.' '.$this->center.' '.'Admin Resource Library',
                'division'     => $this->division,
                'center'       => $this->center
            ],
        ];

        $adminRecruitmentPermissions = [
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Recruitment View',
                'module'       => 'Recruitment',
                'group'        => $this->division.' '.$this->center.' '.'Admin Recruitment',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Recruitment Create',
                'module'       => 'Recruitment',
                'group'        => $this->division.' '.$this->center.' '.'Admin Recruitment',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Recruitment Edit',
                'module'       => 'Recruitment',
                'group'        => $this->division.' '.$this->center.' '.'Admin Recruitment',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin Recruitment Delete',
                'module'       => 'Recruitment',
                'group'        => $this->division.' '.$this->center.' '.'Admin Recruitment',
                'division'     => $this->division,
                'center'       => $this->center
            ],
        ];

        $adminSettingsPermissions = [
            [
                'name'         => $this->division.' '.$this->center.' '.'Role View',
                'module'       => 'Role',
                'group'        => $this->division.' '.$this->center.' '.'Admin App Settings',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Role Create',
                'module'       => 'Role',
                'group'        => $this->division.' '.$this->center.' '.'Admin App Settings',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Role Edit',
                'module'       => 'Role',
                'group'        => $this->division.' '.$this->center.' '.'Admin App Settings',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Role Delete',
                'module'       => 'Role',
                'group'        => $this->division.' '.$this->center.' '.'Admin App Settings',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Permission View',
                'module'       => 'Permission',
                'group'        => $this->division.' '.$this->center.' '.'Admin App Settings',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Permission Create',
                'module'       => 'Permission',
                'group'        => $this->division.' '.$this->center.' '.'Admin App Settings',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Permission Edit',
                'module'       => 'Permission',
                'group'        => $this->division.' '.$this->center.' '.'Admin App Settings',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Permission Delete',
                'module'       => 'Permission',
                'group'        => $this->division.' '.$this->center.' '.'Admin App Settings',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'General Settings View',
                'module'       => 'General Settings',
                'group'        => $this->division.' '.$this->center.' '.'Admin App Settings',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'General Settings Create',
                'module'       => 'General Settings',
                'group'        => $this->division.' '.$this->center.' '.'Admin App Settings',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'General Settings Edit',
                'module'       => 'General Settings',
                'group'        => $this->division.' '.$this->center.' '.'Admin App Settings',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'General Settings Delete',
                'module'       => 'General Settings',
                'group'        => $this->division.' '.$this->center.' '.'Admin App Settings',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Workflow Settings View',
                'module'       => 'Workflow Settings',
                'group'        => $this->division.' '.$this->center.' '.'Admin App Settings',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Workflow Settings Create',
                'module'       => 'Workflow Settings',
                'group'        => $this->division.' '.$this->center.' '.'Admin App Settings',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Workflow Settings Edit',
                'module'       => 'Workflow Settings',
                'group'        => $this->division.' '.$this->center.' '.'Admin App Settings',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Workflow Settings Delete',
                'module'       => 'Workflow Settings',
                'group'        => $this->division.' '.$this->center.' '.'Admin App Settings',
                'division'     => $this->division,
                'center'       => $this->center
            ],
        ];

        $adminEmployeeClosingPermissions = [
            [
                'name'         => $this->division.' '.$this->center.' '.'Employee Closing Separation View',
                'module'       => 'Employee Closing Separation',
                'group'        => $this->division.' '.$this->center.' '.'Employee Closing',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Employee Closing Separation Create',
                'module'       => 'Employee Closing Separation',
                'group'        => $this->division.' '.$this->center.' '.'Employee Closing',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Employee Closing Separation Edit',
                'module'       => 'Employee Closing Separation',
                'group'        => $this->division.' '.$this->center.' '.'Employee Closing',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Employee Closing Separation Delete',
                'module'       => 'Employee Closing Separation',
                'group'        => $this->division.' '.$this->center.' '.'Employee Closing',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Employee Closing Report View',
                'module'       => 'Employee Closing Report',
                'group'        => $this->division.' '.$this->center.' '.'Employee Closing',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Employee Closing Report Create',
                'module'       => 'Employee Closing Report',
                'group'        => $this->division.' '.$this->center.' '.'Employee Closing',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Employee Closing Report Edit',
                'module'       => 'Employee Closing Report',
                'group'        => $this->division.' '.$this->center.' '.'Employee Closing',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Employee Closing Report Delete',
                'module'       => 'Employee Closing Report',
                'group'        => $this->division.' '.$this->center.' '.'Employee Closing',
                'division'     => $this->division,
                'center'       => $this->center
            ],

            [
                'name'         => $this->division.' '.$this->center.' '.'Employee Closing Setting View',
                'module'       => 'Employee Closing Setting',
                'group'        => $this->division.' '.$this->center.' '.'Employee Closing',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Employee Closing Setting Create',
                'module'       => 'Employee Closing Setting',
                'group'        => $this->division.' '.$this->center.' '.'Employee Closing',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Employee Closing Setting Edit',
                'module'       => 'Employee Closing Setting',
                'group'        => $this->division.' '.$this->center.' '.'Employee Closing',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Employee Closing Setting Delete',
                'module'       => 'Employee Closing Setting',
                'group'        => $this->division.' '.$this->center.' '.'Employee Closing',
                'division'     => $this->division,
                'center'       => $this->center
            ]
        ];

        $adminAppraisalPermissions = [
            [
                'name'         => $this->division.' '.$this->center.' '.'Appraisal Appraisal View',
                'module'       => 'Appraisal',
                'group'        => $this->division.' '.$this->center.' '.'Appraisal',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Appraisal Appraisal Create',
                'module'       => 'Appraisal',
                'group'        => $this->division.' '.$this->center.' '.'Appraisal',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Appraisal Appraisal Edit',
                'module'       => 'Appraisal',
                'group'        => $this->division.' '.$this->center.' '.'Appraisal',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Appraisal Appraisal Delete',
                'module'       => 'Appraisal',
                'group'        => $this->division.' '.$this->center.' '.'Appraisal',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Appraisal Evaluation View',
                'module'       => 'Evaluation',
                'group'        => $this->division.' '.$this->center.' '.'Appraisal',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Appraisal Evaluation Create',
                'module'       => 'Evaluation',
                'group'        => $this->division.' '.$this->center.' '.'Appraisal',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Appraisal Evaluation Edit',
                'module'       => 'Evaluation',
                'group'        => $this->division.' '.$this->center.' '.'Appraisal',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Appraisal Evaluation Delete',
                'module'       => 'Evaluation',
                'group'        => $this->division.' '.$this->center.' '.'Appraisal',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Appraisal Report View',
                'module'       => 'Report',
                'group'        => $this->division.' '.$this->center.' '.'Appraisal',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Appraisal Report Create',
                'module'       => 'Report',
                'group'        => $this->division.' '.$this->center.' '.'Appraisal',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Appraisal Report Edit',
                'module'       => 'Report',
                'group'        => $this->division.' '.$this->center.' '.'Appraisal',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Appraisal Report Delete',
                'module'       => 'Report',
                'group'        => $this->division.' '.$this->center.' '.'Appraisal',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Appraisal Setting View',
                'module'       => 'Setting',
                'group'        => $this->division.' '.$this->center.' '.'Appraisal',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Appraisal Setting Create',
                'module'       => 'Setting',
                'group'        => $this->division.' '.$this->center.' '.'Appraisal',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Appraisal Setting Edit',
                'module'       => 'Setting',
                'group'        => $this->division.' '.$this->center.' '.'Appraisal',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Appraisal Setting Delete',
                'module'       => 'Setting',
                'group'        => $this->division.' '.$this->center.' '.'Appraisal',
                'division'     => $this->division,
                'center'       => $this->center
            ]
        ];



// User permissions lists
        $userTeamPermissions = [
            // [
            //     'name'         => 'User',
            //     'module'       => 'User',
            //     'group'        => 'User Permissions'
            // ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Team View',
                'module'       => 'Team',
                'group'        => $this->division.' '.$this->center.' '.'User Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Team Create',
                'module'       => 'Team',
                'group'        => $this->division.' '.$this->center.' '.'User Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Team Edit',
                'module'       => 'Team',
                'group'        => $this->division.' '.$this->center.' '.'User Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Team Delete',
                'module'       => 'Team',
                'group'        => $this->division.' '.$this->center.' '.'User Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
        ];

        $userSupervisorPermissions = [
            [
                'name'         => $this->division.' '.$this->center.' '.'Supervisor View',
                'module'       => 'Supervisor',
                'group'        => $this->division.' '.$this->center.' '.'User Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Supervisor Create',
                'module'       => 'Supervisor',
                'group'        => $this->division.' '.$this->center.' '.'User Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Supervisor Edit',
                'module'       => 'Supervisor',
                'group'        => $this->division.' '.$this->center.' '.'User Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Supervisor Delete',
                'module'       => 'Supervisor',
                'group'        => $this->division.' '.$this->center.' '.'User Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
        ];

        $userRosterPermissions = [
            [
                'name'         => $this->division.' '.$this->center.' '.'User Roster View',
                'module'       => 'Roster',
                'group'        => $this->division.' '.$this->center.' '.'User Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'User Roster Create',
                'module'       => 'Roster',
                'group'        => $this->division.' '.$this->center.' '.'User Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'User Roster Edit',
                'module'       => 'Roster',
                'group'        => $this->division.' '.$this->center.' '.'User Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'User Roster Delete',
                'module'       => 'Roster',
                'group'        => $this->division.' '.$this->center.' '.'User Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
        ];

        $userAttendancePermissions = [
            [
                'name'         => $this->division.' '.$this->center.' '.'User Attendance View',
                'module'       => 'Attendance',
                'group'        => $this->division.' '.$this->center.' '.'User Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'User Attendance Create',
                'module'       => 'Attendance',
                'group'        => $this->division.' '.$this->center.' '.'User Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'User Attendance Edit',
                'module'       => 'Attendance',
                'group'        => $this->division.' '.$this->center.' '.'User Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'User Attendance Delete',
                'module'       => 'Attendance',
                'group'        => $this->division.' '.$this->center.' '.'User Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
        ];

        $employeeHourUploadPermissions = [
            [
                'name'         => $this->division.' '.$this->center.' '.'Employee Hour Upload View',
                'module'       => 'Employee Hour Upload',
                'group'        => $this->division.' '.$this->center.' '.'User Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Employee Hour Upload Create',
                'module'       => 'Employee Hour Upload',
                'group'        => $this->division.' '.$this->center.' '.'User Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Employee Hour Upload Edit',
                'module'       => 'Employee Hour Upload',
                'group'        => $this->division.' '.$this->center.' '.'User Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Employee Hour Upload Delete',
                'module'       => 'Employee Hour Upload',
                'group'        => $this->division.' '.$this->center.' '.'User Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
        ];


        $adminManageSalaryPermanentPermissions = [
            [
                'name'         => $this->division.' '.$this->center.' '.'Manage Salary Permanent View',
                'module'       => 'Permanent',
                'group'        => $this->division.' '.$this->center.' '.'Employees Type Access',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Manage Salary Permanent Create',
                'module'       => 'Permanent',
                'group'        => $this->division.' '.$this->center.' '.'Employees Type Access',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Manage Salary Permanent Edit',
                'module'       => 'Permanent',
                'group'        => $this->division.' '.$this->center.' '.'Employees Type Access',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Manage Salary Permanent Delete',
                'module'       => 'Permanent',
                'group'        => $this->division.' '.$this->center.' '.'Employees Type Access',
                'division'     => $this->division,
                'center'       => $this->center
            ],
        ];


        $adminManageSalaryContractualPermissions = [
            [
                'name'         => $this->division.' '.$this->center.' '.'Manage Salary Contractual View',
                'module'       => 'Contractual',
                'group'        => $this->division.' '.$this->center.' '.'Employees Type Access',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Manage Salary Contractual Create',
                'module'       => 'Contractual',
                'group'        => $this->division.' '.$this->center.' '.'Employees Type Access',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Manage Salary Contractual Edit',
                'module'       => 'Contractual',
                'group'        => $this->division.' '.$this->center.' '.'Employees Type Access',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Manage Salary Contractual Delete',
                'module'       => 'Contractual',
                'group'        => $this->division.' '.$this->center.' '.'Employees Type Access',
                'division'     => $this->division,
                'center'       => $this->center
            ],
        ];


        $adminManageSalaryHourlyPermissions = [
            [
                'name'         => $this->division.' '.$this->center.' '.'Manage Salary Hourly View',
                'module'       => 'Hourly',
                'group'        => $this->division.' '.$this->center.' '.'Employees Type Access',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Manage Salary Hourly Create',
                'module'       => 'Hourly',
                'group'        => $this->division.' '.$this->center.' '.'Employees Type Access',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Manage Salary Hourly Edit',
                'module'       => 'Hourly',
                'group'        => $this->division.' '.$this->center.' '.'Employees Type Access',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Manage Salary Hourly Delete',
                'module'       => 'Hourly',
                'group'        => $this->division.' '.$this->center.' '.'Employees Type Access',
                'division'     => $this->division,
                'center'       => $this->center
            ],
        ];

        $adminManageSalarySetupPermissions = [
            [
                'name'         => $this->division.' '.$this->center.' '.'Manage Salary Setup View',
                'module'       => 'Manage Salary Setup',
                'group'        => $this->division.' '.$this->center.' '.'Manage Salary',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Manage Salary Setup Create',
                'module'       => 'Manage Salary Setup',
                'group'        => $this->division.' '.$this->center.' '.'Manage Salary',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Manage Salary Setup Edit',
                'module'       => 'Manage Salary Setup',
                'group'        => $this->division.' '.$this->center.' '.'Manage Salary',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Manage Salary Setup Delete',
                'module'       => 'Manage Salary Setup',
                'group'        => $this->division.' '.$this->center.' '.'Manage Salary',
                'division'     => $this->division,
                'center'       => $this->center
            ],
        ];

        $adminSalaryHistoryPermissions = [
            [
                'name'         => $this->division.' '.$this->center.' '.'Salary History View',
                'module'       => 'Salary History',
                'group'        => $this->division.' '.$this->center.' '.'Manage Salary',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Salary History Create',
                'module'       => 'Salary History',
                'group'        => $this->division.' '.$this->center.' '.'Manage Salary',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Salary History Edit',
                'module'       => 'Salary History',
                'group'        => $this->division.' '.$this->center.' '.'Manage Salary',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Salary History Delete',
                'module'       => 'Salary History',
                'group'        => $this->division.' '.$this->center.' '.'Manage Salary',
                'division'     => $this->division,
                'center'       => $this->center
            ],
        ];

        $adminSalaryGeneratePermissions = [
            [
                'name'         => $this->division.' '.$this->center.' '.'Salary Generate View',
                'module'       => 'Salary Generate',
                'group'        => $this->division.' '.$this->center.' '.'Manage Salary',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Salary Generate Create',
                'module'       => 'Salary Generate',
                'group'        => $this->division.' '.$this->center.' '.'Manage Salary',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Salary Generate Edit',
                'module'       => 'Salary Generate',
                'group'        => $this->division.' '.$this->center.' '.'Manage Salary',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Salary Generate Delete',
                'module'       => 'Salary Generate',
                'group'        => $this->division.' '.$this->center.' '.'Manage Salary',
                'division'     => $this->division,
                'center'       => $this->center
            ],
        ];

        $adminEmployeeHourClearancePermissions = [
            [
                'name'         => $this->division.' '.$this->center.' '.'Employee Hour Clearance View',
                'module'       => 'Employee Hour Clearance',
                'group'        => $this->division.' '.$this->center.' '.'Clearance',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Employee Hour Clearance Create',
                'module'       => 'Employee Hour Clearance',
                'group'        => $this->division.' '.$this->center.' '.'Clearance',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Employee Hour Clearance Edit',
                'module'       => 'Employee Hour Clearance',
                'group'        => $this->division.' '.$this->center.' '.'Clearance',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Employee Hour Clearance Delete',
                'module'       => 'Employee Hour Clearance',
                'group'        => $this->division.' '.$this->center.' '.'Clearance',
                'division'     => $this->division,
                'center'       => $this->center
            ],
        ];

        $adminProvidentFundClearancePermissions = [
            [
                'name'         => $this->division.' '.$this->center.' '.'Provident Found Clearance View',
                'module'       => 'Provident Found Clearance',
                'group'        => $this->division.' '.$this->center.' '.'Clearance',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Provident Found Clearance Create',
                'module'       => 'Provident Found Clearance',
                'group'        => $this->division.' '.$this->center.' '.'Clearance',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Provident Found Clearance Edit',
                'module'       => 'Provident Found Clearance',
                'group'        => $this->division.' '.$this->center.' '.'Clearance',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Provident Found Clearance Delete',
                'module'       => 'Provident Found Clearance',
                'group'        => $this->division.' '.$this->center.' '.'Clearance',
                'division'     => $this->division,
                'center'       => $this->center
            ],
        ];

        $adminTaxClearancePermissions = [
            [
                'name'         => $this->division.' '.$this->center.' '.'Tax Clearance View',
                'module'       => 'Tax Clearance',
                'group'        => $this->division.' '.$this->center.' '.'Clearance',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Tax Clearance Create',
                'module'       => 'Tax Clearance',
                'group'        => $this->division.' '.$this->center.' '.'Clearance',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Tax Clearance Edit',
                'module'       => 'Tax Clearance',
                'group'        => $this->division.' '.$this->center.' '.'Clearance',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Tax Clearance Delete',
                'module'       => 'Tax Clearance',
                'group'        => $this->division.' '.$this->center.' '.'Clearance',
                'division'     => $this->division,
                'center'       => $this->center
            ],
        ];

        $adminAdjustmentClearancePermissions = [
            [
                'name'         => $this->division.' '.$this->center.' '.'Adjustment Clearance View',
                'module'       => 'Adjustment Clearance',
                'group'        => $this->division.' '.$this->center.' '.'Clearance',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Adjustment Clearance Create',
                'module'       => 'Adjustment Clearance',
                'group'        => $this->division.' '.$this->center.' '.'Clearance',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Adjustment Clearance Edit',
                'module'       => 'Adjustment Clearance',
                'group'        => $this->division.' '.$this->center.' '.'Clearance',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Adjustment Clearance Delete',
                'module'       => 'Adjustment Clearance',
                'group'        => $this->division.' '.$this->center.' '.'Clearance',
                'division'     => $this->division,
                'center'       => $this->center
            ],
        ];

        $adminSalaryHoldClearancePermissions = [
            [
                'name'         => $this->division.' '.$this->center.' '.'Salary Hold Clearance View',
                'module'       => 'Salary Hold Clearance',
                'group'        => $this->division.' '.$this->center.' '.'Clearance',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Salary Hold Clearance Create',
                'module'       => 'Salary Hold Clearance',
                'group'        => $this->division.' '.$this->center.' '.'Clearance',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Salary Hold Clearance Edit',
                'module'       => 'Salary Hold Clearance',
                'group'        => $this->division.' '.$this->center.' '.'Clearance',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Salary Hold Clearance Delete',
                'module'       => 'Salary Hold Clearance',
                'group'        => $this->division.' '.$this->center.' '.'Clearance',
                'division'     => $this->division,
                'center'       => $this->center
            ],
        ];

        $hrHodPermissions = [
            [
                'name'         => $this->division.' '.$this->center.' '.'Hr HOD View',
                'module'       => 'Hr HOD',
                'group'        => $this->division.' '.$this->center.' '.'User Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Hr HOD Create',
                'module'       => 'Hr HOD',
                'group'        => $this->division.' '.$this->center.' '.'User Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Hr HOD Edit',
                'module'       => 'Hr HOD',
                'group'        => $this->division.' '.$this->center.' '.'User Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Hr HOD Delete',
                'module'       => 'Hr HOD',
                'group'        => $this->division.' '.$this->center.' '.'User Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
        ];

        $hrInchargePermissions = [
            [
                'name'         => $this->division.' '.$this->center.' '.'Hr In Charge View',
                'module'       => 'Hr In Charge',
                'group'        => $this->division.' '.$this->center.' '.'User Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Hr In Charge Create',
                'module'       => 'Hr In Charge',
                'group'        => $this->division.' '.$this->center.' '.'User Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Hr In Charge Edit',
                'module'       => 'Hr In Charge',
                'group'        => $this->division.' '.$this->center.' '.'User Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Hr In Charge Delete',
                'module'       => 'Hr In Charge',
                'group'        => $this->division.' '.$this->center.' '.'User Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
        ];

        $itHodPermissions = [
            [
                'name'         => $this->division.' '.$this->center.' '.'IT HOD View',
                'module'       => 'IT HOD',
                'group'        => $this->division.' '.$this->center.' '.'User Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'IT HOD Create',
                'module'       => 'IT HOD',
                'group'        => $this->division.' '.$this->center.' '.'User Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'IT HOD Edit',
                'module'       => 'IT HOD',
                'group'        => $this->division.' '.$this->center.' '.'User Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'IT HOD Delete',
                'module'       => 'IT HOD',
                'group'        => $this->division.' '.$this->center.' '.'User Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
        ];

        $itInchargePermissions = [
            [
                'name'         => $this->division.' '.$this->center.' '.'IT In Charge View',
                'module'       => 'IT In Charge',
                'group'        => $this->division.' '.$this->center.' '.'User Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'IT In Charge Create',
                'module'       => 'IT In Charge',
                'group'        => $this->division.' '.$this->center.' '.'User Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'IT In Charge Edit',
                'module'       => 'IT In Charge',
                'group'        => $this->division.' '.$this->center.' '.'User Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'IT In Charge Delete',
                'module'       => 'IT In Charge',
                'group'        => $this->division.' '.$this->center.' '.'User Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
        ];

        $adminHodPermissions = [
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin HOD View',
                'module'       => 'Admin HOD',
                'group'        => $this->division.' '.$this->center.' '.'User Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin HOD Create',
                'module'       => 'Admin HOD',
                'group'        => $this->division.' '.$this->center.' '.'User Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin HOD Edit',
                'module'       => 'Admin HOD',
                'group'        => $this->division.' '.$this->center.' '.'User Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin HOD Delete',
                'module'       => 'Admin HOD',
                'group'        => $this->division.' '.$this->center.' '.'User Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
        ];

        $adminInchargePermissions = [
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin In Charge View',
                'module'       => 'Admin In Charge',
                'group'        => $this->division.' '.$this->center.' '.'User Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin In Charge Create',
                'module'       => 'Admin In Charge',
                'group'        => $this->division.' '.$this->center.' '.'User Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin In Charge Edit',
                'module'       => 'Admin In Charge',
                'group'        => $this->division.' '.$this->center.' '.'User Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Admin In Charge Delete',
                'module'       => 'Admin In Charge',
                'group'        => $this->division.' '.$this->center.' '.'User Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
        ];

        $accountsHodPermissions = [
            [
                'name'         => $this->division.' '.$this->center.' '.'Accounts HOD View',
                'module'       => 'Accounts HOD',
                'group'        => $this->division.' '.$this->center.' '.'User Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Accounts HOD Create',
                'module'       => 'Accounts HOD',
                'group'        => $this->division.' '.$this->center.' '.'User Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Accounts HOD Edit',
                'module'       => 'Accounts HOD',
                'group'        => $this->division.' '.$this->center.' '.'User Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Accounts HOD Delete',
                'module'       => 'Accounts HOD',
                'group'        => $this->division.' '.$this->center.' '.'User Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
        ];

        $accountsInchargePermissions = [
            [
                'name'         => $this->division.' '.$this->center.' '.'Accounts In Charge View',
                'module'       => 'Accounts In Charge',
                'group'        => $this->division.' '.$this->center.' '.'User Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Accounts In Charge Create',
                'module'       => 'Accounts In Charge',
                'group'        => $this->division.' '.$this->center.' '.'User Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Accounts In Charge Edit',
                'module'       => 'Accounts In Charge',
                'group'        => $this->division.' '.$this->center.' '.'User Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Accounts In Charge Delete',
                'module'       => 'Accounts In Charge',
                'group'        => $this->division.' '.$this->center.' '.'User Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
        ];


        $employeeAttendanceUploadPermissions = [
            [
                'name'         => $this->division.' '.$this->center.' '.'Employee Attendance Upload View',
                'module'       => 'Employee Attendance Upload',
                'group'        => $this->division.' '.$this->center.' '.'User Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Employee Attendance Upload Create',
                'module'       => 'Employee Attendance Upload',
                'group'        => $this->division.' '.$this->center.' '.'User Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Employee Attendance Upload Edit',
                'module'       => 'Employee Attendance Upload',
                'group'        => $this->division.' '.$this->center.' '.'User Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Employee Attendance Upload Delete',
                'module'       => 'Employee Attendance Upload',
                'group'        => $this->division.' '.$this->center.' '.'User Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
        ];

        $employeeAttendanceClearancePermissions = [
            [
                'name'         => $this->division.' '.$this->center.' '.'Employee Attendance Clearance View',
                'module'       => 'Employee Attendance Clearance',
                'group'        => $this->division.' '.$this->center.' '.'User Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Employee Attendance Clearance Create',
                'module'       => 'Employee Attendance Clearance',
                'group'        => $this->division.' '.$this->center.' '.'User Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Employee Attendance Clearance Edit',
                'module'       => 'Employee Attendance Clearance',
                'group'        => $this->division.' '.$this->center.' '.'User Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Employee Attendance Clearance Delete',
                'module'       => 'Employee Attendance Clearance',
                'group'        => $this->division.' '.$this->center.' '.'User Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
        ];

        $JobsSupperAdminPermissions = [
            [
                'name'         => $this->division.' '.$this->center.' '.'Jobs Super Admin View',
                'module'       => 'Jobs Super Admin',
                'group'        => $this->division.' '.$this->center.' '.'Genex Job Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Jobs Super Admin Create',
                'module'       => 'Jobs Super Admin',
                'group'        => $this->division.' '.$this->center.' '.'Genex Job Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Jobs Super Admin Edit',
                'module'       => 'Jobs Super Admin',
                'group'        => $this->division.' '.$this->center.' '.'Genex Job Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Jobs Super Admin Delete',
                'module'       => 'Jobs Super Admin',
                'group'        => $this->division.' '.$this->center.' '.'Genex Job Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
        ];

        $JobsAdminPermissions = [
            [
                'name'         => $this->division.' '.$this->center.' '.'Jobs Admin View',
                'module'       => 'Jobs Admin',
                'group'        => $this->division.' '.$this->center.' '.'Genex Job Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Jobs Admin Create',
                'module'       => 'Jobs Admin',
                'group'        => $this->division.' '.$this->center.' '.'Genex Job Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Jobs Admin Edit',
                'module'       => 'Jobs Admin',
                'group'        => $this->division.' '.$this->center.' '.'Genex Job Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Jobs Admin Delete',
                'module'       => 'Jobs Admin',
                'group'        => $this->division.' '.$this->center.' '.'Genex Job Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
        ];

        $JobsEmployerPermissions = [
            [
                'name'         => $this->division.' '.$this->center.' '.'Jobs Employer View',
                'module'       => 'Jobs Employer',
                'group'        => $this->division.' '.$this->center.' '.'Genex Job Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Jobs Employer Create',
                'module'       => 'Jobs Employer',
                'group'        => $this->division.' '.$this->center.' '.'Genex Job Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Jobs Employer Edit',
                'module'       => 'Jobs Employer',
                'group'        => $this->division.' '.$this->center.' '.'Genex Job Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
            [
                'name'         => $this->division.' '.$this->center.' '.'Jobs Employer Delete',
                'module'       => 'Jobs Employer',
                'group'        => $this->division.' '.$this->center.' '.'Genex Job Permissions',
                'division'     => $this->division,
                'center'       => $this->center
            ],
        ];



        // merge all permissions
        /* new permision adminPermanentSalaryPermissions  */
        $permissions = array_merge(
            $adminEmployeePermissions,
            $adminTeamPermissions,
            $adminLeavePermissions,
            $adminRosterAttendancePermissions,
            $adminLetterAndDocumentPermissions,
            $adminNoticePermissions,
            $adminSettingsPermissions,
            $userTeamPermissions,
            $userSupervisorPermissions,
            $userRosterPermissions,
            $userAttendancePermissions,
            $adminSalaryPermissions,
            $adminPermanentSalaryPermissions,
            $adminSalaryAdjustmentPermissions,
            $adminSalaryHoldPermissions,
            $adminSalaryBonusPermissions,
            $adminKPIPermissions,
            $adminTaxPermissions,
            $adminProvidentFundPermissions,
            $adminLoanPermissions,
            $adminAssetsPermissions,
            $adminResourceLibraryPermissions,
            $adminRecruitmentPermissions,
            $adminEmployeeClosingPermissions,
            $adminAppraisalPermissions,
            $employeeHourUploadPermissions,
            $adminManageSalaryPermanentPermissions,
            $adminManageSalaryContractualPermissions,
            $adminManageSalaryHourlyPermissions,
            $adminManageSalarySetupPermissions,
            $adminSalaryHistoryPermissions,
            $adminSalaryGeneratePermissions,
            $adminEmployeeHourClearancePermissions,
            $adminProvidentFundClearancePermissions,
            $adminTaxClearancePermissions,
            $adminAdjustmentClearancePermissions,
            $adminSalaryHoldClearancePermissions,
            $adminEmployeeHourPermissions,
            $hrHodPermissions,
            $hrInchargePermissions,
            $itHodPermissions,
            $itInchargePermissions,
            $adminHodPermissions,
            $adminInchargePermissions,
            $accountsHodPermissions,
            $accountsInchargePermissions,
            $employeeAttendanceUploadPermissions,
            $employeeAttendanceClearancePermissions,
            $JobsSupperAdminPermissions,
            $JobsAdminPermissions,
            $JobsEmployerPermissions

        );
        // clear Cache
        \Illuminate\Support\Facades\Artisan::call('cache:clear');
        \Illuminate\Support\Facades\Artisan::call('config:clear');
        //\Illuminate\Support\Facades\Artisan::call('route:cache');
        //\Illuminate\Support\Facades\Artisan::call('route:clear');
        \Illuminate\Support\Facades\Artisan::call('view:clear');
        \Illuminate\Support\Facades\Artisan::call('config:cache');
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        //dd($permissions);
        // insert permission into db
/*        \Spatie\Permission\Models\Permission::insert($permissions);*/
        foreach ($permissions as $permission){
            \Spatie\Permission\Models\Permission::firstOrCreate($permission);
        }

        foreach (\Spatie\Permission\Models\Role::all() as $role) {
            if ($role->name == "Super Admin") {
                //$role->syncPermissions($permissions);
                foreach ($permissions as $item) {
                    if(!$role->hasPermissionTo($item['name'])){
                        $role->givePermissionTo($item['name']);
                    }

                }
            }
        }

    }

}
