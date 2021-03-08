<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\GranteeRequest;
use App\Http\Resources\GranteeResource;
use App\Http\Resources\ProjectResource;
use App\Models\Grantee;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class GranteeController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Grantee::class);

        $this->middleware('remember')->only('index');
    }

    public function index(): Response
    {
        return Inertia::render('Grantees/Index', [
            'columns' => $this->getIndexColumns(Grantee::class, [
                'name', 'projects_count', 'donors_count',
            ]),
            'donors'   => $this->getSortedDonors(),
            'managers' => $this->getSortedManagers(),
            'grantees'  => GranteeResource::collection(
                Grantee::query()
                    ->with('projects', 'donors')
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
        Grantee::create($request->validated());

        return Redirect::route('grantees.index')
            ->with('success', __('dashboard.event.created', [
                'model' => __('model.grantee.singular'),
            ]));
    }

    public function show(Grantee $grantee): Response
    {
        return Inertia::render('Grantees/Show', [
            'columns'  => $this->getIndexColumns(Project::class, [
                'title', 'grant', 'amount', 'start_date', 'end_date',
            ]),
            'grantee' => GranteeResource::make($grantee),
            'donors'  => $grantee->donors()->count(),
            'projects' => ProjectResource::collection(
                $grantee->projects()
                    ->without('grantees')
                    ->with('grant.translations')
                    ->filter()
                    ->sort()
                    ->paginate()
            ),
        ]);
    }

    public function edit(Grantee $grantee): Response
    {
        return Inertia::render('Grantees/Edit', [
            'grantee' => GranteeResource::make($grantee),
        ]);
    }

    public function update(GranteeRequest $request, Grantee $grantee): RedirectResponse
    {
        $grantee->update($request->validated());

        return Redirect::route('grantees.index')
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
