<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReportBroadcastMail extends Mailable
{
    use Queueable, SerializesModels;

    public $mailData;
    public $filename;
    public $pdf;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mailData, $file, $pdfPath)
    {
        $this->mailData = $mailData;
        $this->filename = $file;
        $this->pdf = $pdfPath;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(!empty($this->mailData['subject']) ? $this->mailData['subject']:'Report Broadcast')
            ->view('mails.report-broadcast-mail')
            ->attach($this->pdf);
    }
}
