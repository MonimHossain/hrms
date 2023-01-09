<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssetRequisition extends Model
{
    protected $table = 'asset_recuisition';
    protected $fillable = [
        "asset_type_id",
        "employee_id",        
        "due_date",
        "specification",
        "status"
    ];
    public function assetType()
    {
        return $this->hasOne('App\AssetType', 'id', 'asset_type_id');
    }
    public function employee()
    {
        return $this->hasOne('App\Employee', 'id', 'employee_id');
    }
}
