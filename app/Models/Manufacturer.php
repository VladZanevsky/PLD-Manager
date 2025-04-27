<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Manufacturer extends Model
{
    protected $fillable = [
        'name',
        'country'
    ];

    public function fpgaComponents()
    {
        return $this->hasMany(FpgaComponent::class);
    }
}
