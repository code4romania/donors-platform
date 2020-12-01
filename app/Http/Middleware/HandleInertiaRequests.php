<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Services\Exchange;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function share(Request $request)
    {
        return array_merge(parent::share($request), [
            'auth'    => $this->auth(),

            'locale'  => App::getLocale(),
            'locales' => config('translatable.locale_names', []),
            'route'   => $request->route()->getName(),

            'currencies' => config('money.currencies.iso', []),
            'currency'   => Exchange::currency(),

            'sort'    => $request->all('order', 'direction'),
            'search'  => $request->input('search'),
            'filters' => (object) $this->filters($request),
            'flash'   => (object) $this->flash($request),

        ]);
    }

    private function auth(): array
    {
        if (! Auth::check()) {
            return [];
        }

        $user = Auth::user();

        return [
            'id'           => $user->id,
            'name'         => $user->name,
            'email'        => $user->email,
            'avatar'       => $user->avatar,
            'role'         => $user->role,
            'permissions'  => $user->all_permissions,
            'organization' => $user->isAdmin()
                ? ['id' => null, 'name' => __('dashboard.role.admin')]
                : $user->organization->only('id', 'name'),
        ];
    }

    private function filters(Request $request): array
    {
        $filters = $request->input('filters', []);

        if (is_string($filters)) {
            $filters = json_decode($filters, true);
        }

        return $filters;
    }

    private function flash(Request $request): array
    {
        return [
            'success' => $request->session()->get('success'),
            'error'   => $request->session()->get('error'),
        ];
    }
}
