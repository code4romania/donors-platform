<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\GrantRequest;
use App\Http\Resources\GrantIndexResource;
use App\Http\Resources\GrantShowResource;
use App\Http\Resources\NameResource;
use App\Http\Resources\ProjectIndexResource;
use App\Models\Domain;
use App\Models\Donor;
use App\Models\Grant;
use App\Models\GrantManager;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class GrantController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Grants/Index', [
            'columns' => $this->getIndexColumns(Grant::class, [
                'name', 'domains', 'amount', 'published_status',
            ]),
            'grants' => GrantIndexResource::collection(
                Grant::query()
                    ->with('domains', 'projects')
                    ->filter()
                    ->sort()
                    ->paginate(),
            ),
            'donors' => NameResource::collection(
                Donor::orderBy('name', 'asc')->getColumn('name')
            ),
            'domains' => NameResource::collection(
                Domain::orderByTranslation('name', 'asc')->getColumn('name')
            ),
            'managers' => NameResource::collection(
                GrantManager::getColumn('name'),
            ),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Grants/Create', [
            'donors' => NameResource::collection(
                Donor::orderBy('name', 'asc')->getColumn('name')
            ),
            'domains' => NameResource::collection(
                Domain::orderByTranslation('name', 'asc')->getColumn('name')
            ),
            'managers' => NameResource::collection(
                GrantManager::getColumn('name'),
            ),
        ]);
    }

    public function store(GrantRequest $request): RedirectResponse
    {
        $grant = Grant::create($request->all());

        $grant->setPublished($request->boolean('_publish'));

        $grant->domains()->sync($request->input('domains'));
        $grant->donors()->sync($request->input('donors'));
        $grant->manager()->associate($request->input('manager'));

        $grant->save();

        return Redirect::route('grants.show', $grant)
            ->with('success', __('dashboard.event.created', [
                'model' => __('model.grant.singular'),
            ]));
    }

    public function show(Grant $grant): Response
    {
        return Inertia::render('Grants/Show', [
            'grant'    => GrantShowResource::make($grant),
            'columns'  => $this->getIndexColumns(Project::class, [
                'grantee.name', 'title', 'amount', 'start_date', 'end_date',
            ]),
            'projects' => ProjectIndexResource::collection(
                Project::query()
                    ->where('grant_id', $grant->id)
                    ->filter()
                    ->sort()
                    ->paginate()
            ),
        ]);
    }

    public function edit(Grant $grant): Response
    {
        return Inertia::render('Grants/Edit', [
            'grant' => GrantShowResource::make($grant),
            'donors' => NameResource::collection(
                Donor::orderBy('name', 'asc')->getColumn('name')
            ),
            'domains' => NameResource::collection(
                Domain::orderByTranslation('name', 'asc')->getColumn('name')
            ),
            'managers' => NameResource::collection(
                GrantManager::getColumn('name'),
            ),
        ]);
    }

    public function update(GrantRequest $request, Grant $grant): RedirectResponse
    {
        $grant->update($request->except('domain'));

        if ($request->boolean('_publish') !== $grant->isPublished()) {
            $grant->publish($request->boolean('_publish'));
        }

        $grant->domains()->sync($request->input('domains'));
        $grant->donors()->sync($request->input('donors'));
        $grant->manager()->associate($request->input('manager'));

        $grant->save();

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
