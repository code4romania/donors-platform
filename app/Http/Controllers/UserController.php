<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class);
    }

    public function index(): Response
    {
        return Inertia::render('Users/Index', [
            'columns' => $this->getIndexColumns(User::class, [
                'name', 'roleLabel',
            ]),
            'users' => UserResource::collection(
                User::paginate()
            ),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Users/Create', [
            'roles' => Role::all()->pluck('name'),
        ]);
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $user = User::create($request->all());

        $user->syncRoles($request->input('role'));

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
            'user' => UserResource::make($user),
            'roles' => Role::all()->pluck('name'),
        ]);
    }

    public function update(StoreuserRequest $request, User $user): RedirectResponse
    {
        $user->update($request->all());

        $user->syncRoles($request->input('role'));

        return Redirect::back()
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
