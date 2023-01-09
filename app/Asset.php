<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $fillable = [
        'name',
        'asset_id',
        'details',
        'type_id',
        'price',
        'status',
    ];
    
    public function AssetType()
    {
        return $this->hasOne('App\AssetType', 'id', 'type_id');
    }
}
