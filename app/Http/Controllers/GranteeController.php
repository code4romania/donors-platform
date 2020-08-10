<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreGranteeRequest;
use App\Http\Resources\GranteeResource;
use App\Models\Grantee;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class GranteeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Grantees/Index', [
            'columns' => $this->getIndexColumns(Grantee::class, [
                'name',
            ]),
            'sort' => $this->getSortProps(),
            'grantees'  => GranteeResource::collection(
                Grantee::sort()
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
        return Inertia::render('Grantees/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGranteeRequest $request)
    {
        Grantee::create($request->all());

        return Redirect::route('grantees.index')
            ->with('success', __('dashboard.event.created', [
                'model' => __('dashboard.model.grantee.singular'),
            ]));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Grantee       $grantee
     * @return \Illuminate\Http\Response
     */
    public function show(Grantee $grantee)
    {
        return Redirect::route('grantees.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Grantee       $grantee
     * @return \Illuminate\Http\Response
     */
    public function edit(Grantee $grantee)
    {
        return Inertia::render('Grantees/Edit', [
            'grantee' => GranteeResource::make($grantee),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Grantee       $grantee
     * @return \Illuminate\Http\Response
     */
    public function update(StoreGranteeRequest $request, Grantee $grantee)
    {
        $grantee->update($request->all());

        return Redirect::back()
            ->with('success', __('dashboard.event.updated', [
                'model' => __('dashboard.model.grantee.singular'),
            ]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Grantee       $grantee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Grantee $grantee)
    {
        //
    }
}
