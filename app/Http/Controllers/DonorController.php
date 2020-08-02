<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreDonorRequest;
use App\Http\Resources\DonorResource;
use App\Http\Resources\FocusAreaResource;
use App\Models\Donor;
use App\Models\FocusArea;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class DonorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $columns = ['name', 'type', 'hq'];

        return Inertia::render('Donors/Index', [
            'columns' => $columns,
            'donors' => Donor::query()
                ->paginate()
                ->only(...$columns),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Donors/Create', [
            'focus_areas' => FocusAreaResource::collection(FocusArea::all()),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDonorRequest $request)
    {
        $donor = Donor::create($request->except('logo', 'areas'));

        $donor->focusAreas()->sync($request->input('areas'));

        $donor->addMedia($request->file('logo'))
            ->toMediaCollection('logo');

        return Redirect::route('donors.show', $donor)
            ->with('success', __('dashboard.event.created', ['model' => __('dashboard.model.donor.singular')]));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Donor                $donor
     * @return \Illuminate\Http\Response
     */
    public function show(Donor $donor)
    {
        return Inertia::render('Donors/Show', [
            'donor' => DonorResource::make($donor),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Donor                $donor
     * @return \Illuminate\Http\Response
     */
    public function edit(Donor $donor)
    {
        return Inertia::render('Donors/Edit', [
            'donor'       => DonorResource::make($donor),
            'focus_areas' => FocusAreaResource::collection(FocusArea::all()),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Donor                $donor
     * @return \Illuminate\Http\Response
     */
    public function update(StoreDonorRequest $request, Donor $donor)
    {
        $donor->update($request->all());

        $donor->focusAreas()->sync($request->input('areas'));

        return Redirect::back()
            ->with('success', __('dashboard.event.updated', ['model' => __('dashboard.model.donor.singular')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Donor                $donor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Donor $donor)
    {
        $donor->delete();

        return Redirect::back()
            ->with('success', __('dashboard.event.deleted', ['model' => __('dashboard.model.donor.singular')]));
    }
}
