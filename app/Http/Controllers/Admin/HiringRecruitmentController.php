<?php

namespace App\Http\Controllers\Admin;

use App\Employee;
use App\HiringRecruitment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use \Validator;


class HiringRecruitmentController extends Controller
{
    public function ticketCreate()
    {
        $active = 'hiring-recruitment-list';
        $docTypes = DocSetup::all();
        $employees = Employee::all();
        $documentTemplates = DocumentHeaderTemplate::all();
        return view('admin.letterAndDocs.admin.create_doc', compact('active', 'docTypes', 'employees', 'documentTemplates'));
    }


    public function loadDocumentName(Request $request)
    {
        $id = $request->input('id');
        $documentName = DocumentTemplate::where('type_id',$id)->get();
        $result['document'] = $documentName->pluck('name', 'id')->all();

        $prefix = 'GL-HR-';
        $prefix .= DocSetup::find($id)->prefix ?? 'NO';
        $prefix .= '-'.Carbon::parse(Carbon::now())->format('Y-m-d');
        $serialNumber = (Document::where('doc_type_id',$id)->where('year', Carbon::parse(Carbon::now())->format('Y'))->count() ?? 0) + 1;
        $result['prefix'] = $prefix.'-'.str_pad($serialNumber,  4, "0", STR_PAD_LEFT);
        return $result;
    }

    public function loadDocumentContent(Request $request)
    {
        $id = $request->input('id');
        $documentContent = DocumentTemplate::where('id',$id)->get();
        return $documentContent->pluck('content')->all();
    }

    public function getDocEmployeeInformation(Request $request)
    {
        $id = $request->input('id');
        $employees = Employee::where('id',$id)->first();
        $result = [];
        $html = '';


            foreach ($employees->departmentProcess->unique('department_id') as $item) {
                $result['department'] = $item->department->name ?? '';
            }

            foreach ($employees->departmentProcess->unique('department_id') as $item) {
                $result['process'] = $item->process->name ?? '';
            }

            foreach ($employees->departmentProcess->unique('department_id') as $item) {
                $result['segment'] = $item->processSegment->name ?? '';
            }

            $result['name'] = $employees->employer_id . ' - ' . $employees->FullName;
            $result['designation'] = $employees->employeeJourney->designation->name ?? null;
            $result['employeeType'] = $employees->employeeJourney->employmentType->type ?? null;
            $result['doj'] = $employees->employeeJourney->doj ?? null;
            $result['dop'] = $employees->employeeJourney->permanent_doj ?? null;
            $result['phone'] = $employees->contact_number ?? null;
            $result['email'] = $employees->email ?? null;
            $department = isset($result['department']) ? $result['department'] : '';
            $process = isset($result['process']) ? $result['process'] : '';
            $segment = isset($result['segment']) ? $result['segment'] : '';

            $html .= '<div class="alert alert--marginless" role="alert">
                                    <table class="table-responsive info-table">
                                        <tr>
                                            <td>Name </td>
                                            <td>Designation </td>
                                            <td>Date Of Joining </td>
                                            <td>Date Of Permanent </td>
                                            <td>Department </td>
                                            <td>Process </td>
                                            <td>Segment </td>
                                            <td>Phone </td>
                                            <td>Email </td>
                                        </tr>
                                        <tr>
                                            <td>' . $result['name'] . '</td>
                                            <td>' . $result['designation'] . '</td>
                                            <td>' . Carbon::parse($result['doj'])->format('d M, Y') . '</td>
                                            <td>' . Carbon::parse($result['dop'])->format('d M, Y') . '</td>
                                            <td>' . $department . '</td>
                                            <td>' . $process . '</td>
                                            <td>' . $segment . '</td>
                                            <td>' . $result['phone'] . '</td>
                                            <td>' . $result['email'] . '</td>
                                        </tr>
                                    </table>
                                    <hr>
                                </div>';

        return $html;
    }

    public function documentTemplate()
    {
        $active = 'document-template';
        $docTypes = DocSetup::all();
        $employees = Employee::all();
        $templates = DocumentTemplate::all();
        return view('admin.letterAndDocs.admin.doc_template', compact('active', 'docTypes', 'employees', 'templates'));
    }

    public function documentTemplateSearch(Request $request)
    {
        $type = $request->input('search');

        if($type){
            $docTemplate = DocumentTemplate::where('type_id',$type)->get();
        }else{
            $docTemplate = DocumentTemplate::all();
        }
        $active = 'document-template';
        $docTypes = DocSetup::all();
        $employees = Employee::all();

        return view('admin.letterAndDocs.admin.doc_template_search', compact('active', 'docTypes', 'employees', 'docTemplate'));
    }

    public function saveDocumentTemplate(Request $request)
    {
//        dd($request->all());
        $user = auth()->user();
        $doc = new DocumentTemplate;
        $doc->name = $request->name;
        $doc->type_id = $request->type_id;
        $doc->user_id = $user->employee_id ?? 0;
        $doc->content = $request->content_text;
        $doc->save();
        return redirect()->route('admin.document.template');
    }

    public function updateDocumentTemplate(Request $request)
    {
        $user = auth()->user();
        $doc = DocumentTemplate::find($request->input('template_id'));
        $doc->name = $request->name;
        $doc->type_id = $request->type_id;
        $doc->user_id = $user->id;
        $doc->content = $request->content_text;
        $doc->save();
        return redirect()->route('admin.document.template');
    }

    public function viewDocumentTemplate(Request $request)
    {
        $docTemplate = DocumentTemplate::find($request->doc_id);
        return $docTemplate->content ?? '';
    }

    public function changeStatusDocumentTemplate(Request $request)
    {
        $status = DocumentTemplate::find($request->doc_id);
            if($status->status == 1){
                $status->status = 0;
                $status->save();
            }else{
                $status->status = 1;
                $status->save();
            }
        return response()->json(true);
    }

    public function documentTemplateCreate()
    {
        $active = 'document-template';
        $docTypes = DocSetup::all();
        return view('admin.letterAndDocs.admin.create_doc_template', compact('active', 'docTypes'));
    }

    public function hiringRequestHistory(Request $request)
    {
        $button  = [];
        $user = auth()->user()->employee_id;
        $active = 'hiring-recruitment-list';
        $paginate = 10;
        $data = [];
        $requestList = HiringRecruitment::all()->map(function($q) use($user, $data){
            if($q->approved_by == $user){
                $data['approved'] = true;
            }else{
                $data['approved'] = false;
            }
            $data['id'] = $q->id;
            $data['job_title'] = $q->job_title;
            $data['min_salary'] = $q->min_salary;
            $data['max_salary'] = $q->max_salary;
            $data['max_salary'] = $q->job_title;
            $data['number_of_vacancy'] = $q->number_of_vacancy;
            $data['job_requirement'] = $q->job_requirement;
            $data['job_description'] = $q->job_description;
            $data['approved_id'] = $q->approvedBy->employer_id;
            $data['approved_by'] = $q->approvedBy->FullName;
            $data['status'] = $q->status;
            $data['created_id'] = $q->createdBy->employer_id;
            $data['created_by'] = $q->createdBy->FullName;
            $data['updated_by'] = $q->createdBy->FullName;
            $data['created_at'] = $q->created_at;
            $data['updated_at'] = $q->updated_at;
            $data['expected_date'] = $q->expected_date;

            return $data;
        });

        // dd($requestList);

        $requestCheck = $request->all();
        if (!$requestCheck) {
            $docRequest = [];
            return view('admin.hiring.request_history', compact('active', 'requestList', 'button'));
        }

        // $query = DocumentReqHistory::query();
        // if ($request->status != null) {
        //     $query->where('status', $request->status);
        // }

        // if ($request->doc_type){
        //     $query->where('type_id', $request->doc_type);
        // }

        // if ($request->start_date || $request->end_date){
        //     $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        // }

        // if ($request->employee_id){
        //     $query->where('employee_id', $request->employee_id);
        // }

        // $docRequest = $query->paginate($paginate);;

        // return view('admin.letterAndDocs.admin.request_history', compact('active', 'docTypes', 'employees', 'docRequest', 'documentResult'));
    }

    public function hiringRequestCreate()
    {
        $active = 'hiring-recruitment-list';
        $employees = Employee::all();
        return view('admin.hiring.create_doc_template', compact('active', 'employees'));
    }


    public function hiringRequestStore(Request $request){

        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'job_title' => 'required',
            'propose_to' => 'required',
            'min_salary' => 'required',
            'max_salary' => 'required',
            'number_of_vacancy' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()
                        ->route('admin.hiring.request.history')
                        ->withErrors($validator)
                        ->withInput();
        }

        $user = auth()->user()->employee_id;

        $data = [
            'job_title'=> $request->job_title,
            'approved_by'=> $request->propose_to,
            'min_salary'=> $request->min_salary,
            'max_salary'=> $request->max_salary,
            'number_of_vacancy'=> $request->number_of_vacancy,
            'job_requirement'=> $request->requirement,
            'job_description'=> $request->description,
            'expected_date'=> Carbon::create($request->expected_date)->format('Y-m-d'),
            'status'=> 0,
            'created_by'=> $user,
            'created_at'=> Carbon::now(),
        ];
        // dd($data);
        HiringRecruitment::create($data);
        return redirect()->route('admin.hiring.request.history');
    }


    public function hiringRequestView($id)
    {
        $views = HiringRecruitment::find($id);
        return view('admin.hiring.view', compact('views'));
    }

    public function hiringRequestEdit($id)
    {
        return view('admin.hiring.edit', compact('id'));
    }

    public function hiringRequestUpdate(Request $request, $id){
        $data = [
            'status' => $request->status,
            'remarks' => $request->remarks
        ];

        HiringRecruitment::find($id)->update($data);
        return redirect()->route('admin.hiring.request.history');
    }


    public function requestDocumentSetupTemplateEdit($id)
    {
        $active = 'document-req-setup-template';
        $docTypes = DocSetup::where('permission', 1)->get();
        $activeRow = DocumentReqTemplate::find($id);
        return view('admin.letterAndDocs.admin.request_document_setup_template_edit', compact('active', 'docTypes', 'activeRow'));
    }

    public function requestDocumentSetupTemplateUpdate($id)
    {
        $doc =  DocumentReqTemplate::find($id);
        $doc->type_id = Input::get('type_id');
        $doc->content = Input::get('content_text');
        $doc->updated_by = auth()->user()->id;
        $doc->save();
        return redirect()->route('admin.request.doc.setup');
    }


    public function documentHeaderTemplate()
    {
        $active = 'document-header-template';
        $templates = DocumentHeaderTemplate::all();
        return view('admin.letterAndDocs.admin.document_header_template', compact('active', 'templates'));
    }

    public function documentHeaderTemplateCreate()
    {
        $active = 'document-header-template';
        return view('admin.letterAndDocs.admin.document_header_template_create', compact('active'));
    }

    public function documentHeaderTemplateStore(Request $request)
    {
        $documentHeader = new DocumentHeaderTemplate;
        $documentHeader->name = $request->name;
        $documentHeader->header_path = $this->documentUpload($request, 'header_path');
        $documentHeader->footer_path = $this->documentUpload($request, 'footer_path');
        $documentHeader->status = 1;
        $documentHeader->save();
        return redirect()->route('admin.doc.header.template');
    }

    public function documentHeaderTemplateShow($id)
    {
        $active = 'document-header-template';
        $documentHeaders = DocumentHeaderTemplate::find($id);
        return view('admin.letterAndDocs.admin.document_header_template_show', compact('active', 'documentHeaders'));
    }

    public function documentHeaderTemplateEdit($id)
    {
        $active = 'document-header-template';
        $documentHeaders = DocumentHeaderTemplate::find($id);
        return view('admin.letterAndDocs.admin.document_header_template_edit', compact('active', 'documentHeaders'));
    }

    public function documentHeaderTemplateUpdate(Request $request)
    {
        $documentHeader = DocumentHeaderTemplate::find(Input::get('id'));
        $documentHeader->name = Input::get('name');
        $documentHeader->header_path = (!$request->hasFile('header_path')) ? Input::get('header_path_exist') : $this->documentUpload($request, 'header_path');
        $documentHeader->footer_path = (!$request->hasFile('footer_path')) ? Input::get('footer_path_exist')  : $this->documentUpload($request, 'footer_path');
        $documentHeader->status = 1;
        $documentHeader->save();
        return redirect()->route('admin.doc.header.template');
    }



}
