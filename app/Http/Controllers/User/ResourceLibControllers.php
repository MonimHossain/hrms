<?php

namespace App\Http\Controllers\User;

use App\Center;
use App\Division;
use App\Employee;
use App\EventNotice;
use App\ResourceLib;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;


class ResourceLibControllers extends Controller
{
    public function library()
    {
        $active = 'user-resource-lib';
        $resources = $this->getFilterDataForResourceLibrary();
        return view('user.resource.resource-library', compact('active', 'resources'));
    }


    public function getFilterDataForResourceLibrary()
    {
        $user_id = auth()->user()->employee_id;
        $division = Division::where('name', session()->get('division'))->first()->id ?? 0;
        $center = Center::where('center', session()->get('center'))->first()->id ?? 0;
        $department = (!empty(Employee::find($user_id)->employeeDepartmentProcess)) ? Employee::find($user_id)->employeeDepartmentProcess->where('removed_at', '==', NULL)->pluck('department_id') :[0];
        $process = (!empty(Employee::find($user_id)->employeeDepartmentProcess)) ? Employee::find($user_id)->employeeDepartmentProcess->where('removed_at', '==', NULL)->pluck('process_id') : [0];
        $processSegment = (!empty(Employee::find($user_id)->employeeDepartmentProcess)) ? Employee::find($user_id)->employeeDepartmentProcess->where('removed_at', '==', NULL)->pluck('process_segment_id') : [0];

        $expOne = ResourceLib::whereHas('resourceLibraryFilter', function($q) use ($division){
            $q->where('division_id', $division);
            $q->whereIn('center_id', [0]);
            $q->whereIn('department_id', [0]);
            $q->whereIn('process_id', [0]);
            $q->whereIn('process_segment_id', [0]);
        })->get();

        $expTwo = ResourceLib::whereHas('resourceLibraryFilter', function($q) use ($division,$center){
            $q->where('division_id', $division);
            $q->where('center_id', $center);
            $q->whereIn('department_id', [0]);
            $q->whereIn('process_id', [0]);
            $q->whereIn('process_segment_id', [0]);
        })->get();

        $expThree = ResourceLib::whereHas('resourceLibraryFilter', function($q) use ($division,$center, $department){
            $q->where('division_id', $division);
            $q->where('center_id', $center);
            $q->whereIn('department_id', $department);
            $q->whereIn('process_id', [0]);
            $q->whereIn('process_segment_id', [0]);
        })->get();

        $expFour = ResourceLib::whereHas('resourceLibraryFilter', function($q) use ($division,$center, $department, $process){
            $q->where('division_id', $division);
            $q->where('center_id', $center);
            $q->whereIn('department_id', $department);
            $q->whereIn('process_id', $process);
            $q->whereIn('process_segment_id', [0]);
        })->get();

        $expFive = ResourceLib::whereHas('resourceLibraryFilter', function($q) use ($division,$center, $department, $process, $processSegment){
            $q->where('division_id', $division);
            $q->where('center_id', $center);
            $q->whereIn('department_id', $department);
            $q->whereIn('process_id', $process);
            $q->whereIn('process_segment_id', $processSegment);
        })->get();

        $expSix = ResourceLib::doesnthave('resourceLibraryFilter')->get();

        return collect($expOne)->merge($expTwo)->merge($expThree)->merge($expFour)->merge($expFive)->merge($expSix)->sortByDesc('id');
    }

    public function libraryView($id)
    {
        $document = ResourceLib::findOrFail($id);
        $document_name = $document->file;

        if($document_name)
        {

            $file = public_path('storage/uploads/resources/'.$document_name);


            if (file_exists($file)){
            $ext =File::extension($file);
                if($ext=='pdf'){
                    $content_types='application/pdf';
                }elseif ($ext=='doc') {
                    exit('Requested file does not exist on our server!');
                    //$content_types='application/msword';
                }elseif ($ext=='docx') {
                    exit('Requested file does not exist on our server!');
                    //$content_types='application/vnd.openxmlformats-officedocument.wordprocessingml.document';
                }elseif ($ext=='xls') {
                    exit('Requested file does not exist on our server!');
                    //$content_types='application/vnd.ms-excel';
                }elseif ($ext=='xlsx') {
                    exit('Requested file does not exist on our server!');
                    //$content_types='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
                }elseif ($ext=='txt') {
                    $content_types='application/octet-stream';
                }

                return view('user.resourceLib.view', compact('document_name'));
            }else{
                exit('Requested file does not exist on our server!');
            }

            }else{
                exit('Invalid Request');
            }
    }

    public static function convert_from_latin1_to_utf8_recursively($dat)
    {
        if (is_string($dat)) {
            return utf8_encode($dat);
        } elseif (is_array($dat)) {
            $ret = [];
            foreach ($dat as $i => $d) $ret[ $i ] = self::convert_from_latin1_to_utf8_recursively($d);

            return $ret;
        } elseif (is_object($dat)) {
            foreach ($dat as $i => $d) $dat->$i = self::convert_from_latin1_to_utf8_recursively($d);

            return $dat;
        } else {
            return $dat;
        }
    }


}
