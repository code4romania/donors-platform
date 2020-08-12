<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreGrantRequest;
use App\Http\Resources\DomainResource;
use App\Http\Resources\DonorResource;
use App\Http\Resources\GranteeResource;
use App\Http\Resources\GrantIndexResource;
use App\Http\Resources\GrantShowResource;
use App\Models\Domain;
use App\Models\Donor;
use App\Models\Grant;
use App\Models\Grantee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class GrantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Grants/Index', [
            'columns' => $this->getIndexColumns(Donor::class, [
                'name', 'area',
            ]),
            'sort' => $this->getSortProps(),
            'grants'  => GrantIndexResource::collection(
                Grant::with('domain')
                    ->sort()
                    ->paginate(),
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
        return Inertia::render('Grants/Create', [
            'donors' => DonorResource::collection(
                Donor::orderBy('name', 'asc')->get()
            ),
            'domains' => DomainResource::collection(
                Domain::orderByTranslation('name', 'asc')->get()
            ),
            'grantees' => GranteeResource::collection(
                Grantee::orderBy('name', 'asc')->get()
            ),

        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGrantRequest $request)
    {
        $grant = Grant::create($request->except('grantees'));

        $grant->grantees()->sync($request->input('grantees'));

        return Redirect::route('grants.show', $grant)
            ->with('success', __('dashboard.event.created', [
                'model' => __('dashboard.model.grant.singular'),
            ]));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Grant         $grant
     * @return \Illuminate\Http\Response
     */
    public function show(Grant $grant)
    {
        return Inertia::render('Grants/Show', [
            'grant' => GrantShowResource::make($grant),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Grant         $grant
     * @return \Illuminate\Http\Response
     */
    public function edit(Grant $grant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Grant         $grant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Grant $grant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Grant         $grant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Grant $grant)
    {
        //
    }
}
