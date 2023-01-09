<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use PDF;
use Mail;
use App\Mail\ReportBroadcastMail;

class ReportBroadcastEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $mailData;
    public $mailAddress;
    public $pdfPath;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($mailData, $mailAddress, $pdfPath)
    {
        $this->mailData    = $mailData;
        $this->mailAddress = $mailAddress;
        $this->pdfPath     = $pdfPath;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
         Mail::to('khayrul@gmail.com')->send(new ReportBroadcastMail($this->mailData, 'document.pdf', $this->pdfPath));
         //  Delete pdf file
         //  unlink($my_pdf_path);
    }
}
