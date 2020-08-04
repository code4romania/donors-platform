<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreFocusAreaRequest;
use App\Http\Resources\FocusAreaResource;
use App\Models\FocusArea;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class FocusAreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $columns = ['name'];

        return Inertia::render('FocusAreas/Index', [
            'columns' => $columns,
            'focusAreas' => FocusAreaResource::collection(
                FocusArea::paginate()
            ),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('FocusAreas/Create', [
            'translatable' => app(FocusArea::class)->translatable,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFocusAreaRequest $request)
    {
        $focusArea = FocusArea::create($request->all());

        return Redirect::route('focus-areas.index')
            ->with('success', __('dashboard.event.created', ['model' => __('dashboard.model.focusArea.singular')]));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\FocusArea            $focusArea
     * @return \Illuminate\Http\Response
     */
    public function show(FocusArea $focusArea)
    {
        return Redirect::route('focus-areas.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FocusArea            $focusArea
     * @return \Illuminate\Http\Response
     */
    public function edit(FocusArea $focusArea)
    {
        return Inertia::render('FocusAreas/Edit', [
            'focusArea' => FocusAreaResource::make($focusArea),
            'translatable' => app(FocusArea::class)->translatable,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FocusArea            $focusArea
     * @return \Illuminate\Http\Response
     */
    public function update(StoreFocusAreaRequest $request, FocusArea $focusArea)
    {
        $focusArea->update($request->all());

        return Redirect::back()
            ->with('success', __('dashboard.event.updated', ['model' => __('dashboard.model.focusArea.singular')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FocusArea            $focusArea
     * @return \Illuminate\Http\Response
     */
    public function destroy(FocusArea $focusArea)
    {
        $focusArea->delete();

        return Redirect::back()
            ->with('success', __('dashboard.event.deleted', ['model' => __('dashboard.model.focusArea.singular')]));
    }
}
