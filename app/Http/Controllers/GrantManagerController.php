<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\GrantManagerRequest;
use App\Http\Resources\DomainResource;
use App\Http\Resources\GrantManagerResource;
use App\Http\Resources\GrantResource;
use App\Models\Domain;
use App\Models\Grant;
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
                'name', 'grantee_count', 'grant_count', 'total_funding', 'published_status',
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
        $manager = GrantManager::create($request->validated());

        $manager->publish($request->boolean('_publish'));

        $manager->domains()->sync($request->input('domains'));

        return Redirect::route('managers.show', $manager)
            ->with('success', __('dashboard.event.created', [
                'model' => __('model.manager.singular'),
            ]));
    }

    public function show(GrantManager $manager): Response
    {
        return Inertia::render('Managers/Show', [
            'columns' => $this->getIndexColumns(Grant::class, [
                'name', 'regranting_amount', 'start_date', 'end_date', 'published_status',
            ]),
            'manager' => GrantManagerResource::make($manager),
            'domains' => DomainResource::collection(
                Domain::orderByTranslation('name', 'asc')->get()
            ),
            'grants' => GrantResource::collection(
                $manager->grants()
                    ->with('domains')
                    ->withTranslation()
                    ->filter()
                    ->sort()
                    ->paginate()
            ),
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
        $manager->update($request->validated());

        if ($request->boolean('_publish') !== $manager->isPublished()) {
            $manager->publish($request->boolean('_publish'));
        }

        $manager->domains()->sync($request->input('domains'));

        return Redirect::route('managers.show', $manager)
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
