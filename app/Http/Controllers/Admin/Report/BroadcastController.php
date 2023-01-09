<?php

namespace App\Http\Controllers\Admin\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ReportBroadcast;
use Illuminate\Support\Facades\Validator;


class BroadcastController extends Controller
{
    public function broadcastSettings(Request $request){
        $active = 'broadcast-setting';
        $emails = ReportBroadcast::all();
        return view('admin.report.broadcast-setting', compact('active', 'emails'));
    }

    public function broadcastHistory(Request $request){
        $active = 'broadcast-history';
        $data = '';
        return view('admin.report.broadcast-history', compact('active', 'data'));
    }

    public function broadcastStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            toastr()->warning('Email address is required!');
            return redirect()->back();
        }

        $mailAddress = $request->email;
        $reportBroadcast =new ReportBroadcast;
        $reportBroadcast->email = $mailAddress;
        $reportBroadcast->created_by = auth()->user()->employee_id;
        $reportBroadcast->save();
        toastr()->success('Successfully saveed!');
        return redirect()->back();
    }

    public function broadcastEdit($id){
        $emails = ReportBroadcast::find($id);
        return view('admin.report.broadcast-edit', compact('active', 'emails', 'id'));
    }


    public function broadcastUpdate(Request $request, $id)
    {
        $reportBroadcast = ReportBroadcast::find($id);
        $reportBroadcast->email = $request->email;
        $reportBroadcast->updated_by = auth()->user()->employee_id;
        $reportBroadcast->save();
        toastr()->success('Updated successfully!');
        return redirect()->back();
    }

    public function broadcastDelete($id)
    {
        $emails = ReportBroadcast::find($id);
        if($emails!= null){
            $emails->delete();
            toastr()->success('Deleted successfully!');
        }
        return redirect()->back();
    }
}
