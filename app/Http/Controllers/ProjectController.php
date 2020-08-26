<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Http\Resources\GranteeResource;
use App\Http\Resources\GrantShowResource;
use App\Http\Resources\ProjectShowResource;
use App\Models\Grant;
use App\Models\Grantee;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ProjectController extends Controller
{
    public function index(Grant $grant): RedirectResponse
    {
        return Redirect::route('grants.show', ['grant' => $grant]);
    }

    public function create(Grant $grant): Response
    {
        return Inertia::render('Projects/Create', [
            'grant'    => GrantShowResource::make($grant),
            'grantees' => GranteeResource::collection(
                Grantee::orderBy('name', 'asc')->get()
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
        $project->grantee()->associate($request->input('grantee'));

        $project->save();

        return Redirect::route('grants.show', $grant)
            ->with('success', __('dashboard.event.created', [
                'model' => __('model.project.singular'),
            ]));
    }

    public function show(Grant $grant): RedirectResponse
    {
        return Redirect::route('grants.show', ['grant' => $grant]);
    }

    public function edit(Grant $grant, Project $project): Response
    {
        abort_unless($grant->is($project->grant), 403);

        return Inertia::render('Projects/Edit', [
            'project'  => ProjectShowResource::make($project),
            'grant'    => GrantShowResource::make($grant),
            'grantees' => GranteeResource::collection(
                Grantee::orderBy('name', 'asc')->get()
            ),
        ]);
    }

    public function update(ProjectRequest $request, Grant $grant, Project $project): RedirectResponse
    {
        abort_unless($grant->is($project->grant), 403);

        $project->fill([
            'title'      => $request->input('title'),
            'amount'     => $request->input('amount'),
            'currency'   => $grant->currency,
            'start_date' => $request->input('start_date'),
            'end_date'   => $request->input('end_date'),
        ]);

        $project->grantee()->associate($request->input('grantee'));

        $project->save();

        return Redirect::back()
            ->with('success', __('dashboard.event.updated', [
                'model' => __('model.project.singular'),
            ]));
    }

    public function destroy(Grant $grant, Project $project): RedirectResponse
    {
        abort_unless($grant->is($project->grant), 403);

        $project->delete();

        return Redirect::route('grants.show', ['grant' => $grant])
            ->with('success', __('dashboard.event.deleted', [
                'model' => __('model.project.singular'),
            ]));
    }
}
