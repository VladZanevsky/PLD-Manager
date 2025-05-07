<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ManufacturerRequest;
use App\Models\Manufacturer;
use Illuminate\Http\Request;

class ManufacturerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = __('messages.manufacturer.plural');

        $manufacturers = Manufacturer::query()->orderBy('name');
        $manufacturers = $manufacturers->paginate(config('settings.paginate'));

        return view('admin.manufacturer.index', compact(
            'title',
            'manufacturers',
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = __('messages.manufacturer.create');

        return view('admin.manufacturer.create', compact(
            'title',
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ManufacturerRequest $request)
    {
        $manufacturer = Manufacturer::createManufacturer($request);

        if (!$manufacturer) {
            return redirect()->route('admin.manufacturers.index')
                ->with('error', __('messages.manufacturer.error.store'));
        }

        return redirect()->route('admin.manufacturers.index')
            ->with('success', __('messages.manufacturer.success.store'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Manufacturer $manufacturer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Manufacturer $manufacturer)
    {
        $title = __('messages.manufacturer.edit', ['manufacturer' => $manufacturer->name]);

        return view('admin.manufacturer.edit', compact(
            'title',
            'manufacturer',
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ManufacturerRequest $request, Manufacturer $manufacturer)
    {
        $result = Manufacturer::updateManufacturer($request, $manufacturer);

        $redirect = to_route('admin.manufacturers.index');

        if (!$result) {
            return $redirect->with('error', __('messages.manufacturer.error.update'));
        }

        return $redirect->with('success', __('messages.manufacturer.success.update'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Manufacturer $manufacturer)
    {
        $redirect = redirect()->back();

        $is_destroyed = Manufacturer::deleteManufacturer($manufacturer);

        if ($is_destroyed === null)
        {
            return $redirect->with('error', __('messages.manufacturer.error.destroy'));
        }

        return $redirect->with('success', __('messages.manufacturer.success.destroy'));
    }
}
