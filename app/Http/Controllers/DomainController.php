<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\DomainRequest;
use App\Http\Resources\DomainResource;
use App\Models\Domain;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Inertia\Response;

class DomainController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Domains/Index', [
            'columns' => $this->getIndexColumns(Domain::class, [
                'name',
            ]),
            'sort'    => Request::all('order', 'direction'),
            'domains' => DomainResource::collection(
                Domain::sort()
                    ->paginate()
            ),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Domains/Create', [
            'translatable' => app(Domain::class)->translatable,
        ]);
    }

    public function store(DomainRequest $request): RedirectResponse
    {
        Domain::create($request->all());

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
            'domain' => DomainResource::make($domain),
            'translatable' => app(Domain::class)->translatable,
        ]);
    }

    public function update(DomainRequest $request, Domain $domain): RedirectResponse
    {
        $domain->update($request->all());

        return Redirect::back()
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
