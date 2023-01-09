<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssetAllocation extends Model
{
    protected $table = 'asset_allocations';
    protected $fillable = [
        "asset_id",
        "employee_id",
        "allocaiton_date",
        "allocation_note",
        "return_date",
        "return_note",
        "is_damaged",
        "damage_amount",
        'allocated_by'
    ];
    public function asset()
    {
        return $this->hasOne('App\Asset', 'id', 'asset_id');
    }
    public function employee()
    {
        return $this->hasOne('App\Employee', 'id', 'employee_id');
    }

    public function allocatedBy()
    {
        return $this->hasOne('App\Employee', 'id', 'allocated_by');
    }

    public function receivedBy()
    {
        return $this->hasOne('App\Employee', 'id', 'received_by');
    }
}
