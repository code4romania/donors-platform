<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Http\Resources\GranteeResource;
use App\Http\Resources\GrantShowResource;
use App\Http\Resources\ProjectResource;
use App\Models\Grant;
use App\Models\Grantee;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Project::class);

        $this->middleware('remember')->only('index');
    }

    public function index(Grant $grant): RedirectResponse
    {
        return Redirect::route('grants.show', [
            'grant' => $grant,
        ]);
    }

    public function create(Grant $grant): Response
    {
        return Inertia::render('Projects/Create', [
            'grant'    => $grant->only('id', 'name', 'currency'),
            'grantees' => GranteeResource::collection(
                Grantee::query()
                    ->orderBy('name', 'asc')
                    ->get()
            ),
        ]);
    }

    public function store(ProjectRequest $request, Grant $grant): RedirectResponse
    {
        $project = Project::make([
            'title'      => $request->input('title'),
            'amount'     => $request->input('amount'),
            'currency'   => $grant->currency,
            'start_date' => $request->input('start_date'),
            'end_date'   => $request->input('end_date'),
        ]);

        $project->grant()->associate($grant);
        $project->save();

        $project->grantees()->sync($request->input('grantees'));

        return Redirect::route('grants.show', $grant)
            ->with('success', __('dashboard.event.created', [
                'model' => __('model.project.singular'),
            ]));
    }

    public function show(Grant $grant): RedirectResponse
    {
        return Redirect::route('grants.show', [
            'grant' => $grant,
        ]);
    }

    public function edit(Grant $grant, Project $project): Response
    {
        return Inertia::render('Projects/Edit', [
            'project'  => ProjectResource::make($project),
            'grant'    => GrantShowResource::make($grant),
            'grantees' => GranteeResource::collection(
                Grantee::query()
                    ->orderBy('name', 'asc')
                    ->get()
            ),
        ]);
    }

    public function update(ProjectRequest $request, Grant $grant, Project $project): RedirectResponse
    {
        $project->fill([
            'title'      => $request->input('title'),
            'amount'     => $request->input('amount'),
            'currency'   => $grant->currency,
            'start_date' => $request->input('start_date'),
            'end_date'   => $request->input('end_date'),
        ]);

        $project->grantees()->sync($request->input('grantees'));

        $project->save();

        return Redirect::route('grants.show', ['grant' => $grant])
            ->with('success', __('dashboard.event.updated', [
                'model' => __('model.project.singular'),
            ]));
    }

    public function destroy(Grant $grant, Project $project): RedirectResponse
    {
        $project->delete();

        return Redirect::route('grants.show', ['grant' => $grant])
            ->with('success', __('dashboard.event.deleted', [
                'model' => __('model.project.singular'),
            ]));
    }
}
