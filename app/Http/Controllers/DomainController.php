<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreDomainRequest;
use App\Http\Resources\DomainResource;
use App\Models\Domain;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class DomainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Domains/Index', [
            'columns' => $this->getIndexColumns(Domain::class, [
                'name',
            ]),
            'sort' => $this->getSortProps(),
            'domains' => DomainResource::collection(
                Domain::sort()
                    ->paginate()
            ),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Domains/Create', [
            'translatable' => app(Domain::class)->translatable,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDomainRequest $request)
    {
        Domain::create($request->all());

        return Redirect::route('domains.index')
            ->with('success', __('dashboard.event.created', [
                'model' => __('dashboard.model.domain.singular'),
            ]));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Domain        $domain
     * @return \Illuminate\Http\Response
     */
    public function show(Domain $domain)
    {
        return Redirect::route('domains.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Domain        $domain
     * @return \Illuminate\Http\Response
     */
    public function edit(Domain $domain)
    {
        return Inertia::render('Domains/Edit', [
            'domain' => DomainResource::make($domain),
            'translatable' => app(Domain::class)->translatable,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Domain        $domain
     * @return \Illuminate\Http\Response
     */
    public function update(StoreDomainRequest $request, Domain $domain)
    {
        $domain->update($request->all());

        return Redirect::back()
            ->with('success', __('dashboard.event.updated', [
                'model' => __('dashboard.model.domain.singular'),
            ]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Domain        $domain
     * @return \Illuminate\Http\Response
     */
    public function destroy(Domain $domain)
    {
        $domain->delete();

        return Redirect::back()
            ->with('success', __('dashboard.event.deleted', [
                'model' => __('dashboard.model.domain.singular'),
            ]));
    }
}
