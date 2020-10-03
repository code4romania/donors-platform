<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class);

        $this->middleware('remember')->only('index');
    }

    public function index(): Response
    {
        return Inertia::render('Users/Index', [
            'columns' => $this->getIndexColumns(User::class, [
                'name', 'role', 'organization',
            ]),
            'roles' => UserRole::asOptions(),
            'users' => UserResource::collection(
                User::query()
                    ->filter()
                    ->sort()
                    ->paginate()
            ),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Users/Create', [
            'roles'       => UserRole::asOptions(),
            'donors'      => $this->getSortedDonors(),
            'managers'    => $this->getSortedManagers(),
        ]);
    }

    public function store(UserRequest $request): RedirectResponse
    {
        $user = User::make($request->validated());

        $user->associateOrganization($request->input('organization_id'));

        $user->save();

        return Redirect::route('users.index')
            ->with('success', __('dashboard.event.created', [
                'model' => __('model.user.singular'),
            ]));
    }

    public function show(User $user): Response
    {
        return Inertia::render('Users/Show', [
            'user' => UserResource::make($user),
        ]);
    }

    public function edit(User $user): Response
    {
        return Inertia::render('Users/Edit', [
            'user'        => UserResource::make($user),
            'roles'       => UserRole::asOptions(),
            'donors'      => $this->getSortedDonors(),
            'managers'    => $this->getSortedManagers(),
        ]);
    }

    public function update(UserRequest $request, User $user): RedirectResponse
    {
        $user->update($request->validated());

        $user->associateOrganization($request->input('organization_id'));

        return Redirect::route('users.index')
            ->with('success', __('dashboard.event.updated', [
                'model' => __('model.user.singular'),
            ]));
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return Redirect::route('users.index')
            ->with('success', __('dashboard.event.deleted', [
                'model' => __('model.user.singular'),
            ]));
    }
}
