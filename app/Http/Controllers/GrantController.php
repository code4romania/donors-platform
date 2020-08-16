<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreGrantRequest;
use App\Http\Resources\DomainResource;
use App\Http\Resources\DonorResource;
use App\Http\Resources\GrantIndexResource;
use App\Http\Resources\GrantShowResource;
use App\Http\Resources\UserResource;
use App\Models\Domain;
use App\Models\Donor;
use App\Models\Grant;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class GrantController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Grants/Index', [
            'columns' => $this->getIndexColumns(Donor::class, [
                'name', 'domain', 'published_status',
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
            'managers' => UserResource::collection(
                User::withRole('manager')->get()
            ),
        ]);
    }

    public function store(StoreGrantRequest $request): RedirectResponse
    {
        $grant = Grant::create($request->all());

        $grant->publish($request->input('_publish'));

        return Redirect::route('grants.show', $grant)
            ->with('success', __('dashboard.event.created', [
                'model' => __('model.grant.singular'),
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
            'donors' => DonorResource::collection(
                Donor::orderBy('name', 'asc')->get()
            ),
            'domains' => DomainResource::collection(
                Domain::orderByTranslation('name', 'asc')->get()
            ),
            'managers' => UserResource::collection(
                User::withRole('manager')->get()
            ),
        ]);
    }

    public function update(StoreGrantRequest $request, Grant $grant): RedirectResponse
    {
        $grant->update($request->except('domain'));

        if ($request->input('_publish') !== $grant->isPublished()) {
            $grant->publish($request->input('_publish'));
        }

        $grant->domain()->associate($request->input('domain'));

        return Redirect::back()
            ->with('success', __('dashboard.event.updated', [
                'model' => __('model.grant.singular'),
            ]));
    }

    public function destroy(Grant $grant): RedirectResponse
    {
        $grant->delete();

        return Redirect::route('grants.index')
            ->with('success', __('dashboard.event.deleted', [
                'model' => __('model.grant.singular'),
            ]));
    }
}
