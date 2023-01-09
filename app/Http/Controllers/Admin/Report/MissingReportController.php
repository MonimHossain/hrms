<?php

namespace App\Http\Controllers\Admin\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\EmployeeHours;
use App\Employee;
use App\EmployeeAttendance;
use App\Kpi;
use App\ProvidentHistory;
use App\TaxHistory;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use Rap2hpoutre\FastExcel\FastExcel;

class MissingReportController extends Controller
{
    public function employeeHourCsv(Request $request){
        $active = 'missing-report-employee-hour-csv';
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $hour_type = array(
            '0' => 'Regular',
            '1' => 'Adjusted',
            '2' => 'Overtime'
        );
        $paginate = 10;
        $allEmployees = collect(DB::select(DB::raw("SELECT e.id, e.employer_id FROM `employees` e")))->pluck('employer_id')->toArray();
        $query = EmployeeHours::whereNotIn('employer_id', $allEmployees)->with('employee');
        $requestCheck = $request->all();
        if (!$requestCheck) {
            $salary_history = $query->paginate($paginate);
            return view('admin.report.missingReport.employee-hour', compact('active', 'hour_type', 'salary_history', 'startDate', 'endDate'));
        }
        if ($startDate && $endDate) {
            $from = date('Y-m-d', strtotime($startDate));
            $to = date('Y-m-d', strtotime($endDate));
            $salary_history = $query->whereBetween('date', [$from, $to]);
        }
        if ($request->employee_id) {
            $query->where('employer_id', $request->employee_id);
        }


        if (!empty($request->get('csv'))) {
            $hour_history =  $query->get();
            return (new FastExcel($hour_history))->download('employee-hour-missing-csv.csv', function ($hour) {
                return [
                    'Date' => $hour->date,
                    'Agent ID' => $hour->employer_id,
                    'Ready Hour' => $hour->ready_hour,
                    'Lag Hour' => $hour->lag_hour,
                    'Created at' => $hour->created_at
                ];
            });
        } else {
            $salary_history = $query->paginate(10);
        }
        return view('admin.report.missingReport.employee-hour', compact('active', 'hour_type', 'salary_history', 'startDate', 'endDate'));
    }



    public function employeeAttendanceCsv(Request $request){
        $active = 'missing-report-employee-attendance-csv';
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $paginate = 10;
        $allEmployees = collect(DB::select(DB::raw("SELECT e.id, e.employer_id FROM `employees` e")))->pluck('employer_id')->toArray();
        $query = EmployeeAttendance::whereNotIn('employer_id', $allEmployees)->with('employee');
        $requestCheck = $request->all();
        if (!$requestCheck) {
            $salary_history = $query->paginate($paginate);
            return view('admin.report.missingReport.employee-attendance', compact('active', 'hour_type', 'salary_history', 'startDate', 'endDate'));
        }
        if ($startDate && $endDate) {
            $from = date('Y-m-d', strtotime($startDate));
            $to = date('Y-m-d', strtotime($endDate));
            $salary_history = $query->whereBetween('date', [$from, $to]);
        }
        if ($request->employee_id) {
            $query->where('employer_id', $request->employee_id);
        }

        if (!empty($request->get('csv'))) {
            $hour_history =  $query->get();
            return (new FastExcel($hour_history))->download('employee-attendance-missing-csv.csv', function ($hour) {
                return [
                    'Date' => $hour->date,
                    'EmpID' => $hour->employer_id,
                    'Attendance status' => $hour->status,
                    'Created at' => $hour->created_at
                ];
            });
        } else {
            $salary_history = $query->paginate(10);
        }
        return view('admin.report.missingReport.employee-attendance', compact('active', 'hour_type', 'salary_history', 'startDate', 'endDate'));
    }

    public function employeeKpiCsv(Request $request){
        $active = 'missing-report-kpi-csv';
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $paginate = 10;
        $allEmployees = collect(DB::select(DB::raw("SELECT e.id, e.employer_id FROM `employees` e")))->pluck('employer_id')->toArray();
        $query = Kpi::whereNotIn('employer_id', $allEmployees)->with('employee');
        $requestCheck = $request->all();
        if (!$requestCheck) {
            $salary_history = $query->paginate($paginate);
            return view('admin.report.missingReport.employee-kpi', compact('active', 'hour_type', 'salary_history', 'startDate', 'endDate'));
        }
        if ($startDate && $endDate) {
            $from = date('Y-m-d', strtotime($startDate));
            $to = date('Y-m-d', strtotime($endDate));
            $salary_history = $query->whereBetween('date', [$from, $to]);
        }
        if ($request->employee_id) {
            $query->where('employer_id', $request->employee_id);
        }

        if (!empty($request->get('csv'))) {
            $hour_history =  $query->get();
            return (new FastExcel($hour_history))->download('employee-kpi-missing-csv.csv', function ($hour) {
                return [
                    'Month' => $hour->monthly_date,
                    'employee_id' => $hour->employer_id,
                    'Amount' => $hour->amount,
                    'Grade' => $hour->grade
                ];
            });
        } else {
            $salary_history = $query->paginate(10);
        }
        return view('admin.report.missingReport.employee-kpi', compact('active', 'hour_type', 'salary_history', 'startDate', 'endDate'));
    }



    public function employeePfCsv(Request $request){
        $active = 'missing-report-pf-csv';
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $paginate = 10;
        $allEmployees = collect(DB::select(DB::raw("SELECT e.id, e.employer_id FROM `employees` e")))->pluck('employer_id')->toArray();
        $query = ProvidentHistory::whereNotIn('employer_id', $allEmployees)->with('employee');
        $requestCheck = $request->all();
        if (!$requestCheck) {
            $salary_history = $query->paginate($paginate);
            return view('admin.report.missingReport.employee-pf', compact('active', 'hour_type', 'salary_history', 'startDate', 'endDate'));
        }
        if ($startDate && $endDate) {
            $from = date('Y-m-d', strtotime($startDate));
            $to = date('Y-m-d', strtotime($endDate));
            $salary_history = $query->whereBetween('date', [$from, $to]);
        }
        if ($request->employee_id) {
            $query->where('employer_id', $request->employee_id);
        }

        if (!empty($request->get('csv'))) {
            $hour_history =  $query->get();
            return (new FastExcel($hour_history))->download('employee-pf-missing-csv.csv', function ($hour) {
                return [
                    'Date' => $hour->month,
                    'Employee Id' => $hour->employer_id,
                    'Amount' => $hour->amount
                ];
            });
        } else {
            $salary_history = $query->paginate(10);
        }
        return view('admin.report.missingReport.employee-pf', compact('active', 'hour_type', 'salary_history', 'startDate', 'endDate'));
    }



    public function employeeTaxCsv(Request $request){
        $active = 'missing-report-tax-csv';
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $paginate = 10;
        $allEmployees = collect(DB::select(DB::raw("SELECT e.id, e.employer_id FROM `employees` e")))->pluck('employer_id')->toArray();
        $query = TaxHistory::whereNotIn('employer_id', $allEmployees)->with('employee');
        $requestCheck = $request->all();
        if (!$requestCheck) {
            $salary_history = $query->paginate($paginate);
            return view('admin.report.missingReport.employee-tax', compact('active', 'hour_type', 'salary_history', 'startDate', 'endDate'));
        }
        if ($startDate && $endDate) {
            $from = date('Y-m-d', strtotime($startDate));
            $to = date('Y-m-d', strtotime($endDate));
            $salary_history = $query->whereBetween('date', [$from, $to]);
        }
        if ($request->employee_id) {
            $query->where('employer_id', $request->employee_id);
        }

        if (!empty($request->get('csv'))) {
            $hour_history =  $query->get();
            return (new FastExcel($hour_history))->download('employee-tax-missing-csv.csv', function ($hour) {
                return [
                    'Date' => $hour->month,
                    'Employee Id' => $hour->employer_id,
                    'Amount' => $hour->amount
                ];
            });
        } else {
            $salary_history = $query->paginate(10);
        }
        return view('admin.report.missingReport.employee-tax', compact('active', 'hour_type', 'salary_history', 'startDate', 'endDate'));
    }





}
