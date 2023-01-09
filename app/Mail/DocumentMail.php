<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DocumentMail extends Mailable
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
    public function __construct($mailData, $file, $pdfData)
    {
        $this->mailData = $mailData;
        $this->filename = $file;
        $this->pdf = $pdfData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(!empty($this->mailData['subject']) ? $this->mailData['subject']:'No Header')
            ->view('mails.document-mail')
            ->attach($this->pdf);
    }
}
