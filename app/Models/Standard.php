<?php

namespace App\Models;

use App\Http\Requests\StandardRequest;
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

    public static function createStandard(StandardRequest $request)
    {
        $data = $request->validated();

        return self::query()->create($data);
    }

    public static function updateStandard(StandardRequest $request, self $standard)
    {
        $data = $request->validated();

        return $standard->update($data);
    }

    public static function deleteStandard(self $standard)
    {
        return $standard->delete();
    }
}
