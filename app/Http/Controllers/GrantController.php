<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreGrantRequest;
use App\Http\Resources\DomainResource;
use App\Http\Resources\DonorResource;
use App\Http\Resources\GranteeResource;
use App\Http\Resources\GrantIndexResource;
use App\Http\Resources\GrantShowResource;
use App\Models\Domain;
use App\Models\Donor;
use App\Models\Grant;
use App\Models\Grantee;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class GrantController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Grants/Index', [
            'columns' => $this->getIndexColumns(Donor::class, [
                'name', 'area',
            ]),
            'sort' => $this->getSortProps(),
            'grants'  => GrantIndexResource::collection(
                Grant::with('domain')
                    ->sort()
                    ->paginate(),
            ),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Grants/Create', [
            'donors' => DonorResource::collection(
                Donor::orderBy('name', 'asc')->get()
            ),
            'domains' => DomainResource::collection(
                Domain::orderByTranslation('name', 'asc')->get()
            ),
            'grantees' => GranteeResource::collection(
                Grantee::orderBy('name', 'asc')->get()
            ),
        ]);
    }

    public function store(StoreGrantRequest $request): RedirectResponse
    {
        $grant = Grant::create($request->except('grantees'));

        $grant->grantees()->sync($request->input('grantees'));

        return Redirect::route('grants.show', $grant)
            ->with('success', __('dashboard.event.created', [
                'model' => __('dashboard.model.grant.singular'),
            ]));
    }

    public function show(Grant $grant): Response
    {
        return Inertia::render('Grants/Show', [
            'grant' => GrantShowResource::make($grant),
        ]);
    }

    public function edit(Grant $grant): Response
    {
        return Inertia::render('Grants/Edit', [
            'grant' => GrantShowResource::make($grant),
        ]);
    }

    public function update(Request $request, Grant $grant): RedirectResponse
    {
        return Redirect::back()
            ->with('success', __('dashboard.event.updated', [
                'model' => __('dashboard.model.grant.singular'),
            ]));
    }

    public function destroy(Grant $grant): RedirectResponse
    {
        $grant->delete();

        return Redirect::back()
            ->with('success', __('dashboard.event.deleted', [
                'model' => __('dashboard.model.grant.singular'),
            ]));
    }
}
