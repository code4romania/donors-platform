<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\GrantRequest;
use App\Http\Resources\GrantResource;
use App\Http\Resources\ProjectResource;
use App\Models\Grant;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class GrantController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Grant::class);

        $this->middleware('remember')->only('index', 'show');
    }

    public function index(): Response
    {
        return Inertia::render('Grants/Index', [
            'columns' => $this->getIndexColumns(Grant::class, [
                'name', 'donors', 'grantees', 'amount', 'start_date', 'end_date', 'published_status',
            ]),
            'grants' => GrantResource::collection(
                Grant::query()
                    ->withTranslation()
                    ->with('primaryDomain', 'secondaryDomains', 'donors', 'manager', 'projects', 'grantees')
                    ->filter()
                    ->sort()
                    ->paginate(),
            ),
            'domains'  => $this->getSortedDomains(),
            'donors'   => $this->getSortedDonors(),
            'grantees' => $this->getSortedGrantees(),
            'managers' => $this->getSortedManagers(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Grants/Create', [
            'donors'   => $this->getSortedDonors(),
            'domains'  => $this->getSortedDomains(),
            'managers' => $this->getSortedManagers(),
            'translatable' => app(Grant::class)->translatable,
        ]);
    }

    public function store(GrantRequest $request): RedirectResponse
    {
        $grant = Grant::create($request->validated());

        $grant->setPublished($request->boolean('_publish'));

        $grant->syncDomains(
            $request->input('primary_domain'),
            $request->input('secondary_domains')
        );

        $grant->syncDonors($request->input('donors'), $request->input('currency'));
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
            'grant'    => GrantResource::make($grant),
            'columns'  => $this->getIndexColumns(Project::class, [
                'grantees', 'amount', 'start_date', 'end_date',
            ]),
            'projects' => ProjectResource::collection(
                $grant->projects()
                    ->with('grantees')
                    ->filter()
                    ->sort()
                    ->paginate()
            ),
        ]);
    }

    public function edit(Grant $grant): Response
    {
        return Inertia::render('Grants/Edit', [
            'grant'    => GrantResource::make($grant),
            'donors'   => $this->getSortedDonors(),
            'domains'  => $this->getSortedDomains(),
            'managers' => $this->getSortedManagers(),
            'translatable' => $grant->translatable,
        ]);
    }

    public function update(GrantRequest $request, Grant $grant): RedirectResponse
    {
        $grant->fill($request->validated());

        if ($request->boolean('_publish') !== $grant->isPublished()) {
            $grant->publish($request->boolean('_publish'));
        }

        $grant->syncDomains(
            $request->input('primary_domain'),
            $request->input('secondary_domains')
        );

        $grant->syncDonors($request->input('donors'), $request->input('currency'));

        $grant->manager()->associate($request->input('manager'));

        $grant->save();

        return Redirect::route('grants.show', $grant)
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
