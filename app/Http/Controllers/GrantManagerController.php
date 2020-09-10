<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\GrantManagerRequest;
use App\Http\Resources\DomainResource;
use App\Http\Resources\GrantManagerResource;
use App\Http\Resources\GrantResource;
use App\Models\Domain;
use App\Models\Grant;
use App\Models\Grantee;
use App\Models\GrantManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class GrantManagerController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Managers/Index', [
            'columns' => $this->getIndexColumns(GrantManager::class, [
                'name', 'hq', 'published_status',
            ]),
            'managers' => GrantManagerResource::collection(
                GrantManager::query()
                    ->filter()
                    ->sort()
                    ->paginate(),
            ),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Managers/Create', [
            'domains' => DomainResource::collection(
                Domain::all()
            ),
        ]);
    }

    public function store(GrantManagerRequest $request): RedirectResponse
    {
        $manager = GrantManager::create($request->except('logo'));

        $manager->publish($request->boolean('_publish'));

        $manager->domains()->sync($request->input('domains'));

        if ($request->file('logo')) {
            $manager->addMedia($request->file('logo'))
                ->toMediaCollection('logo');
        }

        return Redirect::route('managers.show', $manager)
            ->with('success', __('dashboard.event.created', [
                'model' => __('model.manager.singular'),
            ]));
    }

    public function show(GrantManager $manager): Response
    {
        return Inertia::render('Managers/Show', [
            'columns' => $this->getIndexColumns(Grant::class, [
                'name', 'domains', 'funding_value',
            ]),
            'manager' => GrantManagerResource::make($manager),
            'domains' => DomainResource::collection(
                Domain::orderByTranslation('name', 'asc')->get()
            ),
            'grants' => GrantResource::collection(
                $manager->grants()->with('projects')
                    ->filter()
                    ->sort()
                    ->paginate()
            ),
            'stats'  => [
                'grantees' => Grantee::query()->count(),
                'total'    => $manager->funding_value,
                'domains'  => $manager->grants()
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

    public function edit(GrantManager $manager): Response
    {
        return Inertia::render('Managers/Edit', [
            'manager' => GrantManagerResource::make($manager),
            'domains' => DomainResource::collection(
                Domain::all()
            ),
        ]);
    }

    public function update(GrantManagerRequest $request, GrantManager $manager): RedirectResponse
    {
        $manager->update($request->except('logo'));

        if ($request->boolean('_publish') !== $manager->isPublished()) {
            $manager->publish($request->boolean('_publish'));
        }

        $manager->domains()->sync($request->input('domains'));

        if ($request->file('logo')) {
            $manager->clearMediaCollection('logo');
            $manager->addMedia($request->file('logo'))
                ->toMediaCollection('logo');
        }

        return Redirect::back()
            ->with('success', __('dashboard.event.updated', [
                'model' => __('model.manager.singular'),
            ]));
    }

    public function destroy(GrantManager $manager): RedirectResponse
    {
        $manager->delete();

        return Redirect::route('managers.index')
            ->with('success', __('dashboard.event.deleted', [
                'model' => __('model.manager.singular'),
            ]));
    }
}
