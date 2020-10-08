<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\DomainRequest;
use App\Http\Resources\DomainResource;
use App\Models\Domain;
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
                'name',
            ]),
            'domains' => Domain::flatTree(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Domains/Create', [
            'translatable' => app(Domain::class)->translatable,
            'domains'      => $this->getSortedDomainsTree(),
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

    public function show(Domain $domain): RedirectResponse
    {
        return Redirect::route('domains.index');
    }

    public function edit(Domain $domain): Response
    {
        return Inertia::render('Domains/Edit', [
            'domain'       => DomainResource::make($domain),
            'translatable' => app(Domain::class)->translatable,
            'domains'      => $this->getSortedDomainsTree(),
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
