<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Standard extends Model
{
    protected $fillable = [
        'name'
    ];

    public function fpgaComponents()
    {
        return $this->belongsToMany(FpgaComponent::class, 'fpga_standards');
    }
}
