<?php

namespace App\Models;

use App\Http\Requests\FpgaComponentRequest;
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
        return $this->belongsToMany(Standard::class, 'fpga_standards', 'fpga_component_id', 'standard_id');
    }

    public static function createFpgaComponent(FpgaComponentRequest $request)
    {
        $data = $request->validated();

        return self::query()->create($data);
    }

    public static function updateFpgaComponent(FpgaComponentRequest $request, self $fpga_component)
    {
        $data = $request->validated();

        return $fpga_component->update($data);
    }

    public static function deleteFpgaComponent(self $fpga_component)
    {
        return $fpga_component->delete();
    }
}
