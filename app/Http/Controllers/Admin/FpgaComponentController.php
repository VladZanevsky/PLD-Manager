<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FpgaComponentRequest;
use App\Models\FpgaComponent;
use App\Models\Manufacturer;
use App\Models\Standard;
use Illuminate\Http\Request;

class FpgaComponentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = __('messages.fpga_component.plural');

        $fpga_components = FpgaComponent::query()->orderBy('created_at', 'desc');
        $fpga_components = $fpga_components->paginate(config('settings.paginate'));

        return view('admin.fpga_component.index', compact(
            'title',
            'fpga_components',
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = __('messages.fpga_component.create');

        $manufacturers = Manufacturer::query()->orderBy('name')->get();
        $standards = Standard::query()->orderBy('name')->get();

        return view('admin.fpga_component.create', compact(
            'title',
            'manufacturers',
            'standards',
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FpgaComponentRequest $request)
    {

        $fpgaComponent = FpgaComponent::createFpgaComponent($request);

        if (!$fpgaComponent) {
            return redirect()->route('admin.fpga-components.index')
                ->with('error', __('messages.fpga_component.error.store'));
        }

        if ($request->has('standard_id')) {
            $fpgaComponent->standards()->attach($request->input('standard_id'));
        }

        return redirect()->route('admin.fpga-components.index')
            ->with('success', __('messages.fpga_component.success.store'));
    }

    /**
     * Display the specified resource.
     */
    public function show(FpgaComponent $fpga_component)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FpgaComponent $fpga_component)
    {
        $title = __('messages.fpga_component.edit', ['fpga_component' => $fpga_component->model]);
        $manufacturers = Manufacturer::query()->orderBy('name')->get();
        $standards = Standard::query()->orderBy('name')->get();

        return view('admin.fpga_component.edit', compact(
            'title',
            'fpga_component',
            'manufacturers',
            'standards',
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FpgaComponentRequest $request, FpgaComponent $fpga_component)
    {
        //dd($request);
        $result = FpgaComponent::updateFpgaComponent($request, $fpga_component);
        // Синхронизируем стандарты (массив standard_id)
        $fpga_component->standards()->sync($request->input('standard_id'));

        $redirect = to_route('admin.fpga-components.index');

        if (!$result) {
            return $redirect->with('error', __('messages.fpga_component.error.update'));
        }

        return $redirect->with('success', __('messages.fpga_component.success.update'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FpgaComponent $fpga_component)
    {
        $redirect = redirect()->back();

        $is_destroyed = FpgaComponent::deleteFpgaComponent($fpga_component);

        if ($is_destroyed === null)
        {
            return $redirect->with('error', __('messages.fpga_component.error.destroy'));
        }

        return $redirect->with('success', __('messages.fpga_component.success.destroy'));
    }
}
