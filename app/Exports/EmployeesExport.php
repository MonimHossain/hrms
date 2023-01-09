<?php

namespace App\Exports;

use App\Division;
use App\Employee;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use DB;

class EmployeesExport implements FromCollection, WithMapping, WithHeadings
{
    public $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $request = $this->request;
        $division = Division::where('id', $request->input('division_id'))->with('centers')->first();
        $center = $division->centers->where('id', $request->input('center_id'))->first();
        $query = Employee::withoutGlobalScopes()
            ->whereHas('employeeJourney', function ($q) use ($request) {
                $q->where('employee_status_id', 1);
            })
            ->whereHas('employeeJourney', function ($q) use ($request) {
                $q->where('employment_type_id', $request->input('employment_type_id'));
            })
            ->whereHas('employeeJourney', function ($q) use ($request) {
                $q->where('employment_type_id', $request->input('employment_type_id'));
            })
            ->whereHas('divisionCenters', function ($q) use ($center, $division) {
                $q->where('center_id', $center->id)->where('division_id', $division->id);
            })
            ->with([
                'educations:id,employee_id,exam_degree_title,institute',
                'trainings:id,employee_id,training_title,training_year',
                'employeeJourney',
                'employeeJourney.designation',
                'employeeJourney.designation',
                'employeeJourney.employmentType',
                'employeeJourney.employeeStatus',
                'divisionCenters',
                'divisionCenters.division',
                'divisionCenters.center',
            ])
            ->get()
            ->map(function($item){
                $educations = null;
                $trainings = null;
                $divisions = null;
                $centers = null;
                // add educations to collection
                foreach ($item->educations as $education){
                    $educations .= $education->exam_degree_title.'('.$education->institute.'), ';
                }
                // add trainings to collection
                foreach ($item->trainings as $training){
                    $trainings .= $training->training_title.'('.$training->training_year.'), ';
                }
                // add division centers to collection
                foreach ($item->divisionCenters as $divisionCenter){
                    $divisions .= $divisionCenter->division->name. '-' .$divisionCenter->center->center. ', ' ?? null;
                }

                $item['education_info'] = $educations;
                $item['training_info'] = $trainings;
                $item['division_info'] = $divisions;
                return $item;
            });
        return $query;
    }

    public function headings(): array
    {
        return [
            'EmpID',
            'Name',

            'Designation',
            'Job Role',
            'Employment Type',
            'Employment Status',
            'Date of join',
            'Contract Start Date',
            'Contract End Date',
            'Probation Start Date',
            'Probation End Date',
            'Permanent Doj',

            'Division',


            'Email',
            'Personal Email',
            'Gender',
            'Date of birth',
            'Religion',
            'SSC Reg.',
            'Father Name',
            'Mother Name',
            'Present Address',
            'Permanent Address',
            'Contact Number',
            'Alt Contact Number',
            'Pool Phone Number',
            'Emergency Contact Person',
            'Emergency Contact Number',
            'Relation With Employee',
            'NID',
            'Passport',
            'Marital Status',
            'Spouse Name',
            'Spouse DOB',
            'Child1 Name',
            'Child1 DOB',
            'Child2 Name',
            'Child2 DOB',
            'Child3 Name',
            'Child3 DOB',
            'Education',
            'Training',
        ];
    }

    public function map($row): array
    {

        return [
            $row->employer_id,
            $row->first_name.' '.$row->last_name,

            $row->employeeJourney->designation->name ?? null,
            $row->employeeJourney->jobRole->name ?? null,
            $row->employeeJourney->employmentType->type ?? null,
            $row->employeeJourney->employeeStatus->status ?? null,
            (($row->employeeJourney) && $tmp = $row->employeeJourney->doj) ? Carbon::parse($tmp)->toDateString() : null,
            (($row->employeeJourney) && $tmp2 = $row->employeeJourney->contract_start_date) ? Carbon::parse($tmp2)->toDateString() : null,
            (($row->employeeJourney) && $tmp3 = $row->employeeJourney->contract_end_date) ? Carbon::parse($tmp3)->toDateString() : null,
            (($row->employeeJourney) && $tmp4 = $row->employeeJourney->probation_start_date) ? Carbon::parse($tmp4)->toDateString() : null,
            (($row->employeeJourney) && $tmp5 = $row->employeeJourney->probation_end_date) ? Carbon::parse($tmp5)->toDateString() : null,
            (($row->employeeJourney) && $tmp6 = $row->employeeJourney->permanent_doj) ? Carbon::parse($tmp6)->toDateString() : null,


            $row->division_info,

            $row->email,
            $row->personal_email,
            $row->gender,
            $row->date_of_birth,
            $row->religion,
            $row->ssc_reg_num,
            $row->father_name,
            $row->mother_name,
            $row->present_address,
            $row->permanent_address,
            $row->contact_number,
            $row->alt_contact_number,
            $row->pool_phone_number,
            $row->emergency_contact_person,
            $row->emergency_contact_person_number,
            $row->relation_with_employee,
            $row->nid,
            $row->passport,
            $row->marital_status,
            $row->spouse_name,
            $row->spouse_dob,
            $row->child1_name,
            $row->child1_dob,
            $row->child2_name,
            $row->child2_dob,
            $row->child3_name,
            $row->child3_dob,
            $row->education_info,
            $row->training_info,
        ];
    }

}
