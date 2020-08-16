<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Resources\GranteeResource;
use App\Http\Resources\GrantShowResource;
use App\Http\Resources\ProjectShowResource;
use App\Models\Grant;
use App\Models\Grantee;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProjectController extends Controller
{
    public function index(Grant $grant): RedirectResponse
    {
        return Redirect::route('grants.show', ['grant' => $grant]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Grant $grant): Response
    {
        return Inertia::render('Projects/Create', [
            'grant'    => GrantShowResource::make($grant),
            'grantees' => GranteeResource::collection(
                Grantee::orderBy('name', 'asc')->get()
            ),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Grant          $grant
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request, Grant $grant): RedirectResponse
    {
        $grant->grantees()->attach($request->input('grantee'), [
            'title'      => $request->input('title'),
            'amount'     => $request->input('amount'),
            'currency'   => $grant->currency,
            'start_date' => $request->input('start_date'),
            'end_date'   => $request->input('end_date'),
        ]);

        return Redirect::route('grants.show', $grant)
            ->with('success', __('dashboard.event.created', [
                'model' => __('model.project.singular'),
            ]));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Grant          $grant
     * @return \Illuminate\Http\Response
     */
    public function show(Grant $grant): RedirectResponse
    {
        return Redirect::route('grants.show', ['grant' => $grant]);
    }

    public function edit(Grant $grant, int $project): Response
    {
        $grantee = $grant->grantees->firstWhere('project.id', $project);

        abort_unless($project, 403);

        return Inertia::render('Projects/Edit', [
            'project'  => ProjectShowResource::make($grantee->project),
            'grant'    => GrantShowResource::make($grant),
            'grantees' => GranteeResource::collection(
                Grantee::orderBy('name', 'asc')->get()
            ),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Grant          $grant
     * @param  \App\Model\Project        $project
     * @return \Illuminate\Http\Response
     */
    public function update(StoreProjectRequest $request, Grant $grant, Project $project): RedirectResponse
    {
        abort_unless($grant->grantees->firstWhere('project.id', $project->id), 403);

        $project->grantee_id = $request->input('grantee');

        $project->fill([
            'title'      => $request->input('title'),
            'amount'     => $request->input('amount'),
            'currency'   => $grant->currency,
            'start_date' => $request->input('start_date'),
            'end_date'   => $request->input('end_date'),
        ]);

        $project->save();

        return Redirect::back()
            ->with('success', __('dashboard.event.updated', [
                'model' => __('model.project.singular'),
            ]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Grant          $grant
     * @param  \App\Model\Project        $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Grant $grant, Project $project)
    {
        //
    }
}
