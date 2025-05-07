<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StandardRequest;
use App\Models\Standard;
use Illuminate\Http\Request;

class StandardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = __('messages.standard.plural');

        $standards = Standard::query()->orderBy('name');
        $standards = $standards->paginate(config('settings.paginate'));

        return view('admin.standard.index', compact(
            'title',
            'standards',
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = __('messages.standard.create');

        return view('admin.standard.create', compact(
            'title',
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StandardRequest $request)
    {
        $standard = Standard::createStandard($request);

        if (!$standard) {
            return redirect()->route('admin.standards.index')
                ->with('error', __('messages.standard.error.store'));
        }

        return redirect()->route('admin.standards.index')
            ->with('success', __('messages.standard.success.store'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Standard $standard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Standard $standard)
    {
        $title = __('messages.standard.edit', ['standard' => $standard->name]);

        return view('admin.standard.edit', compact(
            'title',
            'standard',
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StandardRequest $request, Standard $standard)
    {
        $result = Standard::updateStandard($request, $standard);

        $redirect = to_route('admin.standards.index');

        if (!$result) {
            return $redirect->with('error', __('messages.standard.error.update'));
        }

        return $redirect->with('success', __('messages.standard.success.update'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Standard $standard)
    {
        $redirect = redirect()->back();

        $is_destroyed = Standard::deleteStandard($standard);

        if ($is_destroyed === null)
        {
            return $redirect->with('error', __('messages.standard.error.destroy'));
        }

        return $redirect->with('success', __('messages.standard.success.destroy'));
    }
}
