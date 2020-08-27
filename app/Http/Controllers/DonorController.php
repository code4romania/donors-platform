<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\DonorRequest;
use App\Http\Resources\DomainResource;
use App\Http\Resources\DonorResource;
use App\Http\Resources\GrantIndexResource;
use App\Models\Domain;
use App\Models\Donor;
use App\Models\Grant;
use App\Models\Grantee;
use App\Services\OrganizationType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class DonorController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Donors/Index', [
            'columns' => $this->getIndexColumns(Donor::class, [
                'name', 'type', 'hq', 'published_status',
            ]),
            'types'  => OrganizationType::all(),
            'donors' => DonorResource::collection(
                Donor::query()
                    ->with('domains')
                    ->filter()
                    ->sort()
                    ->paginate(),
            ),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Donors/Create', [
            'types'   => OrganizationType::all(),
            'domains' => DomainResource::collection(
                Domain::all()
            ),
        ]);
    }

    public function store(DonorRequest $request): RedirectResponse
    {
        $donor = Donor::create($request->except('logo'));

        $donor->publish($request->boolean('_publish'));

        $donor->domains()->sync($request->input('domains'));

        $donor->addMedia($request->file('logo'))
            ->toMediaCollection('logo');

        return Redirect::route('donors.show', $donor)
            ->with('success', __('dashboard.event.created', [
                'model' => __('model.donor.singular'),
            ]));
    }

    public function show(Donor $donor): Response
    {
        return Inertia::render('Donors/Show', [
            'columns' => $this->getIndexColumns(Grant::class, [
                'name', 'domains', 'funding_value',
            ]),
            'donor'  => DonorResource::make($donor),
            'domains' => DomainResource::collection(
                Domain::orderByTranslation('name', 'asc')->get()
            ),
            'grants' => GrantIndexResource::collection(
                $donor->grants()->with('projects')
                    ->filter()
                    ->sort()
                    ->paginate()
            ),
            'stats'  => [
                'grantees' => Grantee::query()->count(),
                'total'    => $donor->funding_value,
                'domains'  => $donor->grants()
                    ->with('domains')
                    ->get()
                    ->pluck('domains')
                    ->flatten()
                    ->pluck('id')
                    ->unique()
                    ->count(),
            ],
        ]);
    }

    public function edit(Donor $donor): Response
    {
        return Inertia::render('Donors/Edit', [
            'types'   => OrganizationType::all(),
            'donor'   => DonorResource::make($donor),
            'domains' => DomainResource::collection(
                Domain::all()
            ),
        ]);
    }

    public function update(DonorRequest $request, Donor $donor): RedirectResponse
    {
        $donor->update($request->except('logo'));

        if ($request->boolean('_publish') !== $donor->isPublished()) {
            $donor->publish($request->boolean('_publish'));
        }

        $donor->domains()->sync($request->input('domains'));

        if ($request->file('logo')) {
            $donor->clearMediaCollection('logo');
            $donor->addMedia($request->file('logo'))
                ->toMediaCollection('logo');
        }

        return Redirect::back()
            ->with('success', __('dashboard.event.updated', [
                'model' => __('model.donor.singular'),
            ]));
    }

    public function destroy(Donor $donor): RedirectResponse
    {
        $donor->delete();

        return Redirect::route('donors.index')
            ->with('success', __('dashboard.event.deleted', [
                'model' => __('model.donor.singular'),
            ]));
    }
}
