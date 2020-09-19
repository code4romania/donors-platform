<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\DonorRequest;
use App\Http\Resources\DonorResource;
use App\Http\Resources\GrantResource;
use App\Http\Resources\NameResource;
use App\Models\Domain;
use App\Models\Donor;
use App\Models\Grant;
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
                'name', 'type', 'grantee_count', 'grant_count', 'total_funding', 'published_status',
            ]),
            'types'  => OrganizationType::all(),
            'domains' => NameResource::collection(
                Domain::orderByTranslation('name', 'asc')->getColumn('name')
            ),
            'donors' => DonorResource::collection(
                Donor::query()
                    ->with('domains.translation')
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
            'domains' => NameResource::collection(
                Domain::orderByTranslation('name', 'asc')->getColumn('name')
            ),
        ]);
    }

    public function store(DonorRequest $request): RedirectResponse
    {
        $donor = Donor::create($request->validated());

        $donor->publish($request->boolean('_publish'));

        $donor->domains()->sync($request->input('domains'));

        return Redirect::route('donors.show', $donor)
            ->with('success', __('dashboard.event.created', [
                'model' => __('model.donor.singular'),
            ]));
    }

    public function show(Donor $donor): Response
    {
        return Inertia::render('Donors/Show', [
            'columns' => $this->getIndexColumns(Grant::class, [
                'name', 'amount', 'start_date', 'end_date', 'published_status',
            ]),
            'donor'  => DonorResource::make($donor),
            'domains' => NameResource::collection(
                Domain::orderByTranslation('name', 'asc')->getColumn('name')
            ),
            'grants' => GrantResource::collection(
                $donor->grants()
                    ->filter()
                    ->sort()
                    ->paginate()
            ),
        ]);
    }

    public function edit(Donor $donor): Response
    {
        return Inertia::render('Donors/Edit', [
            'types'   => OrganizationType::all(),
            'donor'   => DonorResource::make($donor),
            'domains' => NameResource::collection(
                Domain::orderByTranslation('name', 'asc')->getColumn('name')
            ),
        ]);
    }

    public function update(DonorRequest $request, Donor $donor): RedirectResponse
    {
        $donor->update($request->validated());

        if ($request->boolean('_publish') !== $donor->isPublished()) {
            $donor->publish($request->boolean('_publish'));
        }

        $donor->domains()->sync($request->input('domains'));

        return Redirect::route('donors.show', $donor)
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
