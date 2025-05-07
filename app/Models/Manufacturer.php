<?php

namespace App\Models;

use App\Http\Requests\ManufacturerRequest;
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

    public static function createManufacturer(ManufacturerRequest $request)
    {
        $data = $request->validated();

        return self::query()->create($data);
    }

    public static function updateManufacturer(ManufacturerRequest $request, self $manufacturer)
    {
        $data = $request->validated();

        return $manufacturer->update($data);
    }

    public static function deleteManufacturer(self $manufacturer)
    {
        return $manufacturer->delete();
    }
}
