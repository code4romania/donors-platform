<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\GrantManagerRequest;
use App\Http\Resources\DomainResource;
use App\Http\Resources\GrantManagerResource;
use App\Models\Domain;
use App\Models\GrantManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
            'sort' => $this->getSortProps(),
            'managers' => GrantManagerResource::collection(
                GrantManager::query()
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
            'manager' => GrantManagerResource::make($manager),
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
