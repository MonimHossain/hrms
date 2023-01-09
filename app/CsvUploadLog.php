<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CsvUploadLog extends Model
{
    protected $fillable = [
        'total_number_of_row',
        'faild_qnt',
        'success_qnt',
        'emp_id',
        'remarks',
        'csv_upload_logable_id',
        'csv_upload_logable_type',
        'created_by',
        'updated_by'
    ];

    
}
