<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreDonorRequest;
use App\Models\Donor;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DonorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $columns = ['name', 'type', 'hq'];

        return Inertia::render('Donors/Index', [
            'columns' => $columns,
            'donors' => Donor::query()
                ->paginate()
                ->only(...$columns),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Donors/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDonorRequest $request)
    {
        $donor = Donor::create($request->all());

        return redirect()->route('donors.show', $donor);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Donor                $donor
     * @return \Illuminate\Http\Response
     */
    public function show(Donor $donor)
    {
        return Inertia::render('Donors/Show', [
            'donor' => $donor,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Donor                $donor
     * @return \Illuminate\Http\Response
     */
    public function edit(Donor $donor)
    {
        return Inertia::render('Donors/Edit', [
            'donor' => $donor,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Donor                $donor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Donor $donor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Donor                $donor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Donor $donor)
    {
        //
    }
}
