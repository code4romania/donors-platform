<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\GranteeRequest;
use App\Http\Resources\GranteeResource;
use App\Models\Grantee;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class GranteeController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Grantees/Index', [
            'columns' => $this->getIndexColumns(Grantee::class, [
                'name',
            ]),
            'grantees'  => GranteeResource::collection(
                Grantee::query()
                    ->filter()
                    ->sort()
                    ->paginate(),
            ),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Grantees/Create');
    }

    public function store(GranteeRequest $request): RedirectResponse
    {
        Grantee::create($request->all());

        return Redirect::route('grantees.index')
            ->with('success', __('dashboard.event.created', [
                'model' => __('model.grantee.singular'),
            ]));
    }

    public function show(Grantee $grantee): RedirectResponse
    {
        return Redirect::route('grantees.index');
    }

    public function edit(Grantee $grantee): Response
    {
        return Inertia::render('Grantees/Edit', [
            'grantee' => GranteeResource::make($grantee),
        ]);
    }

    public function update(GranteeRequest $request, Grantee $grantee): RedirectResponse
    {
        $grantee->update($request->all());

        return Redirect::back()
            ->with('success', __('dashboard.event.updated', [
                'model' => __('model.grantee.singular'),
            ]));
    }

    public function destroy(Grantee $grantee): RedirectResponse
    {
        $grantee->delete();

        return Redirect::route('grantees.index')
            ->with('success', __('dashboard.event.deleted', [
                'model' => __('model.grantee.singular'),
            ]));
    }
}
