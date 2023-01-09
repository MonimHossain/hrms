<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\ReportBroadcast as rb;
use DateTime;
use PDF;
use DB;
use App\Employee;
use App\Jobs\ReportBroadcastEmailJob;
use App\Scopes\TeamDivisionCenterScope;



class ReportBroadcast extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:broadcast';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Set data and pdf generate
        $accountCompletionReport = Employee::withoutGlobalScopes()->select(DB::raw('count(*) as completed, profile_completion'))->whereHas('employeeJourney', function($q){
            $q->where('employee_status_id', 1);
        })->groupby('profile_completion')->orderby('profile_completion')->get();

        $attritionReport = DB::select( DB::raw("SELECT
            m.name,
            COUNT(CASE WHEN m.final_closing = 1 then 1 ELSE NULL END) as 'final_closing',
            COUNT(CASE WHEN m.termination_status = 1 then 1 ELSE NULL END) as 'termination_status' ,
            SUM(IFNULL(final_closing, 0) + IFNULL(termination_status, 0)) as 'total'
        FROM
            (SELECT DISTINCT
                cp.final_closing,
                    cp.termination_status,
                    (SELECT
                            p.name
                        FROM
                            processes p
                        WHERE
                            p.id = edp.process_id) AS name
            FROM
                employee_department_processes edp
            RIGHT JOIN closing_applications cp ON cp.employee_id = edp.employee_id) m group by m.name"));

        $missingReport = Employee::withoutGlobalScopes()->doesntHave('individualSalary')
                    ->whereHas('employeeJourney', function($q){
                        $q->where('employee_status_id', 1);
                    })->select(DB::raw('count(*) as count'))->first();

        $untrackEmployee = Employee::withoutGlobalScopes()->whereDoesntHave('teamMember', function($q){
            $q->withoutGlobalScope(TeamDivisionCenterScope::class);
        })
        ->whereHas('employeeJourney', function ($q) {
            $q->where('employee_status_id', 1);
        })->select(DB::raw('count(*) as count'))->first();            

        $data = [
            'accountCompletionReport' => $accountCompletionReport,
            'attritionReport' => $attritionReport,
            'missingReport' => $missingReport,
            'untrackEmployee' => $untrackEmployee
        ];

        $my_pdf_path = storage_path().'/pdf/'.$this->fileNameGenerate().'.pdf';
        PDF::loadView('admin.report.broadcast-pdf', $data)->save($my_pdf_path );

        // Email Template Data Set
        $mailData['subject'] = "Test";

        $users = rb::all()->pluck('email')->toArray();
        // Send Email
        foreach($users as $user){
           dispatch(new ReportBroadcastEmailJob($user, $mailData, $my_pdf_path));
        }

    
        // Message Show
        $this->info('report:broadcast Cummand Run successfully!');
    }
    

    public function fileNameGenerate()
    {
        $date = new DateTime();
        $countDocAndDocument = $date->getTimestamp();
        return date("ymd").str_pad($countDocAndDocument, 6, "0", STR_PAD_LEFT).rand(100,1000);
    }
}
