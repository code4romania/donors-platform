<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\DomainRequest;
use App\Http\Resources\DomainResource;
use App\Http\Resources\GrantResource;
use App\Models\Domain;
use App\Models\Grant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class DomainController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Domain::class);

        $this->middleware('remember')->only('index');
    }

    public function index(): Response
    {
        return Inertia::render('Domains/Index', [
            'columns' => $this->getIndexColumns(Domain::class, [
                'name', 'total_funding', 'donors_count', 'grants_count', 'projects_count',
            ]),
            'domains' => Domain::flatTree(null, ['stats']),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Domains/Create', [
            'translatable' => app(Domain::class)->translatable,
            'domains'      => $this->getSortedDomains(),
        ]);
    }

    public function store(DomainRequest $request): RedirectResponse
    {
        Domain::create($request->validated());

        return Redirect::route('domains.index')
            ->with('success', __('dashboard.event.created', [
                'model' => __('model.domain.singular'),
            ]));
    }

    public function show(Domain $domain): Response
    {
        $domain->load(
            'descendantsAndSelf.donors',
            'descendantsAndSelf.grants.grantees',
            'descendantsAndSelf.projects',
        );

        return Inertia::render('Domains/Show', [
            'columns'  => $this->getIndexColumns(Grant::class, [
                'name', 'donors', 'grantees', 'amount', 'start_date', 'end_date', 'published_status',
            ]),
            'domain' => DomainResource::make($domain),
            'donors' => $domain->donors()->count(),
            'grants' => GrantResource::collection(
                Grant::query()
                    ->search()
                    ->filter()
                    ->sort()
                    ->withTranslation()
                    ->with('primaryDomain', 'secondaryDomains', 'donors', 'manager', 'projects', 'grantees')
                    ->filterByPrimaryDomains($domain->descendantsAndSelf()->pluck('id'))
                    ->paginate()
            ),
        ]);
    }

    public function edit(Domain $domain): Response
    {
        return Inertia::render('Domains/Edit', [
            'domain'       => DomainResource::make($domain),
            'translatable' => app(Domain::class)->translatable,
            'domains'      => $this->getSortedDomains(),
        ]);
    }

    public function update(DomainRequest $request, Domain $domain): RedirectResponse
    {
        $domain->update($request->validated());

        return Redirect::route('domains.index')
            ->with('success', __('dashboard.event.updated', [
                'model' => __('model.domain.singular'),
            ]));
    }

    public function destroy(Domain $domain): RedirectResponse
    {
        $domain->delete();

        return Redirect::route('domains.index')
            ->with('success', __('dashboard.event.deleted', [
                'model' => __('model.domain.singular'),
            ]));
    }
}
