<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FpgaComponent extends Model
{
    protected $fillable = [
        'manufacturer_id',
        'model',
        'frequency',
        'lut_count',
        'power',
        'io_count',
        'cost',
        'availability'
    ];

    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class);
    }

    public function standards()
    {
        return $this->belongsToMany(Standard::class, 'fpga_standards');
    }
}
