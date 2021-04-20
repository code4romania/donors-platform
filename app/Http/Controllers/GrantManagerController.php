<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\GrantManagerRequest;
use App\Http\Resources\GrantManagerResource;
use App\Http\Resources\GrantResource;
use App\Models\Grant;
use App\Models\GrantManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class GrantManagerController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(GrantManager::class, 'manager');

        $this->middleware('remember')->only('index');
    }

    public function index(): Response
    {
        return Inertia::render('Managers/Index', [
            'columns' => $this->getIndexColumns(GrantManager::class, [
                'name', 'grantees_count', 'grants_count', 'total_funding', 'published_status',
            ]),
            'domains'  => $this->getSortedDomains(),
            'donors'  => $this->getSortedDonors(),
            'managers' => GrantManagerResource::collection(
                GrantManager::query()
                    ->search()
                    ->filter()
                    ->sort()
                    ->paginate(),
            ),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Managers/Create', [
            'domains' => $this->getSortedDomains(),
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
            'domains' => $this->getSortedDomains(),
            'grants'  => GrantResource::collection(
                $manager->grants()
                    ->search()
                    ->filter()
                    ->sort()
                    ->with('domains')
                    ->withTranslation()
                    ->paginate()
            ),
        ]);
    }

    public function edit(GrantManager $manager): Response
    {
        return Inertia::render('Managers/Edit', [
            'manager' => GrantManagerResource::make($manager),
            'domains' => $this->getSortedDomains(),
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
