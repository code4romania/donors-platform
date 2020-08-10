<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreDonorRequest;
use App\Http\Resources\DomainResource;
use App\Http\Resources\DonorResource;
use App\Models\Domain;
use App\Models\Donor;
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
        return Inertia::render('Donors/Index', [
            'columns' => $this->getIndexColumns(Donor::class, [
                'name', 'type', 'hq', 'published_status',
            ]),
            'sort' => $this->getSortProps(),
            'donors' => DonorResource::collection(
                Donor::with('domains')
                    ->sort()
                    ->paginate(),
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
        return Inertia::render('Donors/Create', [
            'domains' => DomainResource::collection(
                Domain::all()
            ),
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

        $donor->publish($request->input('_publish'));

        $donor->domains()->sync($request->input('domains'));

        $donor->addMedia($request->file('logo'))
            ->toMediaCollection('logo');

        return Redirect::route('donors.show', $donor)
            ->with('success', __('dashboard.event.created', [
                'model' => __('dashboard.model.donor.singular'),
            ]));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Donor         $donor
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
     * @param  \App\Models\Donor         $donor
     * @return \Illuminate\Http\Response
     */
    public function edit(Donor $donor)
    {
        return Inertia::render('Donors/Edit', [
            'donor'   => DonorResource::make($donor),
            'domains' => DomainResource::collection(
                Domain::all()
            ),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Donor         $donor
     * @return \Illuminate\Http\Response
     */
    public function update(StoreDonorRequest $request, Donor $donor)
    {
        $donor->update($request->except('logo', 'areas'));

        if ($request->input('_publish') !== $donor->isPublished()) {
            $donor->publish($request->input('_publish'));
        }

        $donor->domains()->sync($request->input('domains'));

        return Redirect::back()
            ->with('success', __('dashboard.event.updated', [
                'model' => __('dashboard.model.donor.singular'),
            ]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Donor         $donor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Donor $donor)
    {
        $donor->delete();

        return Redirect::back()
            ->with('success', __('dashboard.event.deleted', [
                'model' => __('dashboard.model.donor.singular'),
            ]));
    }
}
