<?php


namespace App\Http\Controllers\Admin\LetterAndDocs;

use App\Department;
use App\DocSetup;
use App\DocumentHeaderTemplate;
use App\DocumentReqHistory;
use App\DocumentReqTemplate;
use App\DocumentTemplate;
use App\Employee;
use App\Events\LetterAndDocument\SendNotifyToEmployeeEvent;
use App\Http\Controllers\Controller;
use App\LetterAndDocument;
use App\Mail\DocumentMail;
use App\Notifications\DocumentNotification;
use App\Process;
use App\Utils\DocumentAndLetter;
use App\Utils\ReferenceNumber;
use Cassandra\Date;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use PDF;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use Carbon\Carbon;
use App\Document;
use Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class LetterAndDocController
{

    public function documentCreate()
    {
        $active = 'document-create';
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

    public function documentRequestHistory(Request $request)
    {
        $active = 'document-request-history';
        $paginate = 10;
        $docTypes = DocSetup::all();
        $employees = Employee::all();

        /*start count total doc*/
        $query = DocumentReqHistory::query();
        $documentResult = $query
            ->selectRaw('
            count(case when status=0 then 1 end) as new_cnt,
            count(case when status=1 then 1 end) as process_cnt,
            count(case when status=2 then 1 end) as reject_cnt,
            count(case when status=3 then 1 end) as done_cnt,
            count(*) as total_cnt'
            )
            ->first();
        /*end count total doc*/

        $requestCheck = $request->all();
        if (!$requestCheck) {
            //$docRequest = DocumentReqHistory::all();
            $docRequest = [];
            return view('admin.letterAndDocs.admin.request_history', compact('active', 'docTypes', 'employees', 'docRequest', 'documentResult'));
        }

        $query = DocumentReqHistory::query();
        if ($request->status != null) {
            $query->where('status', $request->status);
        }

        if ($request->doc_type){
            $query->where('type_id', $request->doc_type);
        }

        if ($request->start_date || $request->end_date){
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        if ($request->employee_id){
            $query->where('employee_id', $request->employee_id);
        }

        $docRequest = $query->paginate($paginate);;

        return view('admin.letterAndDocs.admin.request_history', compact('active', 'docTypes', 'employees', 'docRequest', 'documentResult'));
    }

    public function documentHistory(Request $request)
    {
        $active = 'document-history';
        $docTypes = DocSetup::all();
        $employees = Employee::all();
        $documents = Document::all();
        $pagination = 10;

        $requestCheck = $request->all();
        if (!$requestCheck) {
            $docHistory = []; //Document::orderBy('id', 'desc')->get();
            return view('admin.letterAndDocs.admin.doc_history', compact('active', 'docTypes', 'employees', 'docHistory', 'documents'));
        }

        $query = Document::query();

        if($request->doc_type){
            $query->where('doc_type_id', $request->doc_type);
        }

        if ($request->start_date || $request->end_date){
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        if ($request->employee_id){
            $query->where('employee_id', $request->employee_id);
        }

        if ($request->ref_id){
            $query->where('ref_id', $request->ref_id);
        }

        $docHistory = $query->orderBy('id', 'desc')->paginate($pagination);

        return view('admin.letterAndDocs.admin.doc_history', compact('active', 'docTypes', 'employees', 'docHistory', 'documents'));
    }

    public function documentRequestHistoryView(Request $request)
    {
        $docTemplate = DocumentReqHistory::find($request->doc_id);
        return $docTemplate->content ?? '';
    }

    public function documentRequestHistoryChangeStatus(Request $request)
    {
        $user = auth()->user();
        $doc = DocumentReqHistory::find($request->input('doc_id'));
        $doc->status = $request->input('status');
        $doc->processed_by = $user->employee_id;
        $doc->remarks = $request->input('remarks');
        $doc->save();
        return redirect()->route('admin.document.request.history');
    }


    public function documentTemplateEdit($id)
    {
        $active = 'document-template';
        $docTypes = DocSetup::all();
        $docTemplate = DocumentTemplate::find($id);
        return view('admin.letterAndDocs.admin.edit_doc_template', compact('active', 'docTypes', 'docTemplate'));

    }


    public function loadPageByDocType(Request $request)
    {
        $inputField = $request->input('type');
        $employer_id = $request->input('employer_id');

        if($employer_id){
            $data = Employee::where('employer_id', $employer_id)->first();
        }else{
            $data = '';
        }

        $ref = $this->generateRefNumber();

        if($inputField){
            $path = $request->input('type');
        }else{
            $path = 'admin.letterAndDocs.docs.not-found';
        }
        return view($path, compact('data', 'ref'));
    }


    public function documentAndLetterWithPdf($id, $type)
    {
        $pdfData = Document::where('id',$id)->first();
        $data = ['data' => $pdfData, 'type' => $type];
        $pdf = PDF::loadView('admin.letterAndDocs.pdf', $data);
        $file = $this->fileNameGenerate('documents');
        return $pdf->download($file.'.pdf');
    }

    public function documentAndLetterChangeStatus(Request $request)
    {
        $status = Document::find($request->doc_id);
        if($status->status == 1){
            $status->status = 0;
            $status->save();
        }else{
            $status->status = 1;
            $status->save();
        }
        return response()->json(true);
    }


    public function saveDocumentAndLetterWithWord(Request $request)
    {
      $phpWord = new PhpWord();
      $section = $phpWord->addSection();
      $text = $section->addText($request->input('employer_id'));
      $text = $section->addText($request->input('content_hidden'));
      $text = $section->addText($request->input('content_hidden'),array('name'=>'Arial','size' => 20,'bold' => true));
      $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
      $file = $this->fileNameGenerate('documents');
      $objWriter->save($file.'.docx');
      return response()->download(public_path($file.'.docx'));
    }


    public function saveDocumentAndLetterWithPrint(Request $request)
    {
        $data = $request->input('content_hidden');
        return view('admin.letterAndDocs.print', compact('data'));
    }


    public function saveDocAndDocument($user, $path)
    {
        $document = new LetterAndDocument();
        $document->year = Date('Y');
        $document->ref_id = $this->generateRefNumber();
        $document->employer_id = $user;
        $document->content = $path;
        $document->status = 1;
        $document->save();
    }


    public function generateRefNumber(){
        $countDocAndDocument = LetterAndDocument::where('year', Date('Y'))->select('id')->max('id') + 1;
        return ReferenceNumber::AppointmentLetter.date("ymd").str_pad($countDocAndDocument, 6, "0", STR_PAD_LEFT);
    }

    public function fileNameGenerate($table)
    {
        $countDocAndDocument = DB::table($table)->where('year', Date('Y'))->select('id')->max('id') + 1;
        return date("ymd").str_pad($countDocAndDocument, 6, "0", STR_PAD_LEFT).rand(100,1000);
    }


    public function adminSaveDocument(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'editor1' => 'required',
            'employee_id' => 'required',
            'ref_number' => 'required',
            'pad_id' => 'required',
        ]);

        if ($validator->fails()) {
            toastr()->success('Document Process is Required!');
            return redirect()->route('admin.document.create')->withInput();
        }

        $employee = Employee::where('id',$request->employee_id)->first();


        $document = new Document;
        $data = [
            'ref_id' => $request->ref_number,
            'year' => Carbon::now()->year,
            'doc_type_id' => $request->docType,
            'employee_id' => $employee->id ?? 0,
            'content' => $request->editor1,
            'status' => 1,
            'document_header_id' => $request->pad_id,
            'created_by' => auth()->user()->employee_id
        ];
//        dd($data);
        $document->create($data);

        toastr()->success('New Document created successfully !');


        Notification::send($employee->userDetails, new DocumentNotification($employee->FullName, 'Your Document Has Been Created', 'employee.documents.history'));

        return redirect()->route('admin.document.history');
    }

    public function SendDocumentToEmployeeByEmail($id)
    {
        $employeId = Document::find($id)->employee_id;
        $employeeInfo = Employee::find($employeId);
        $emailAddress = $employeeInfo->email ?? 'test@gmail.com';
        $type = 'yes';
        $pdfData = Document::where('id',$id)->first();
        $data = ['data' => $pdfData, 'type'=> $type];
        //$my_pdf_path = $_SERVER["DOCUMENT_ROOT"].'/storage/hrmsDocs/pdf/'.$this->fileNameGenerate('documents').'.pdf';
        $my_pdf_path = storage_path('app/public/hrmsDocs/pdf/'.$this->fileNameGenerate('documents').'.pdf');
        // $my_pdf_path = storage_path('app/pdf/'.$this->fileNameGenerate('documents').'.pdf');
        //dd($my_pdf_path);

        PDF::loadView('admin.letterAndDocs.pdf', $data)->save($my_pdf_path);

        $mailData['name'] = $employeeInfo->FullName;
        $mailData['employer_id'] = $employeeInfo->employer_id;
        $mailData['subject'] = "Test";

        Mail::to($emailAddress)->send(new DocumentMail($mailData, 'document.pdf', $my_pdf_path));

        unlink($my_pdf_path);

        return redirect()->route('admin.document.history');
    }

    public function requestDocumentSetupTemplate()
    {
        $active = 'document-req-setup-template';
        $docTypes = DocSetup::where('permission', 1)->get();
        $templates = DocumentReqTemplate::all();
        return view('admin.letterAndDocs.admin.request_document_setup_template', compact('active', 'docTypes', 'templates'));
    }

    public function requestDocumentSetupTemplateCreate()
    {
        $active = 'document-req-setup-template';
        $docTypes = DocSetup::where('permission', 1)->get();
        return view('admin.letterAndDocs.admin.request_document_setup_template_create', compact('active', 'docTypes'));
    }

    public function requestDocumentSetupTemplateStore(Request $request)
    {
        $doc = new DocumentReqTemplate;
        $doc->type_id = $request->input('type_id');
        $doc->content = $request->input('content_text');
        $doc->created_by = auth()->user()->id;
        $doc->updated_by = auth()->user()->id;
        $doc->save();
        return redirect()->route('admin.request.doc.setup');
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


    // leave document upload
    public function documentUpload($request, $name)
    {
        $file = $request->file($name);
        $reName = uniqid() . '_' . trim($file->getClientOriginalName());
        $request->file($name)->storeAs('public/hrmsDocs/template', $reName);
        return $reName;
    }


    public function documentAndLetterReport(Request $request)
    {
        $active = 'letter-document-report';
        $docTypes = DocSetup::all();
        $departments = Department::all();
        $processes = Process::all();


        $query = DocumentReqHistory::query();
        if(isset($request->monthYear)){
            $monthYear = explode('-', $request->monthYear);
            $query->whereYear('created_at', $monthYear[0]); /*$montYear[0] = Year*/
            $query->whereMonth('created_at', $monthYear[1]); /*$montYear[1] = Month*/
        }else{
            $documentResult = [];
            return view('admin.letterAndDocs.admin.document_report', compact('active',  'docTypes', 'documentResult', 'departments', 'processes'));
        }

        if(isset($request->docType)){
            $query->where('type_id', $request->docType);
        }

        if(isset($request->department)){
            $query->whereHas('employeeDepartmentProcess', function ($q) use($request){
                $q->where('department_id', $request->department);
            });
        }

        if(isset($request->process)){
            $query->whereHas('employeeDepartmentProcess', function ($q) use($request){
                $q->where('process_id', $request->process);
            });
        }

        $documentResult = $query
            ->selectRaw('type_id,
            count(case when status=0 then 1 end) as new_cnt,
            count(case when status=3 then 1 end) as done_cnt,
            count(*) as total_cnt'
            )
            ->groupBy('type_id')
            ->get();
        return view('admin.letterAndDocs.admin.document_report', compact('active', 'documentResult', 'docTypes', 'departments', 'processes'));

    }




}
