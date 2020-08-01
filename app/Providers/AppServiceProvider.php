<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\UrlWindow;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerInertia();
        $this->registerLengthAwarePaginator();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::morphMap([
            'donor' => \App\Models\Donor::class,
            'user'  => \App\Models\User::class,
        ]);
    }

    private function registerInertia(): void
    {
        Inertia::version(fn () => md5_file(public_path('assets/mix-manifest.json')));

        Inertia::setRootView('layouts.app');

        Inertia::share([
            'locale' => fn () => app()->getLocale(),

            'auth' => function () {
                return [
                    'user' => Auth::user() ? [
                        'id'    => Auth::user()->id,
                        'name'  => Auth::user()->name,
                        'email' => Auth::user()->email,
                        'role'  => Auth::user()->role,
                    ] : null,
                ];
            },

            'flash' => function () {
                return [
                    'success' => Session::get('success'),
                    'error'   => Session::get('error'),
                ];
            },

            'errors' => function () {
                return Session::get('errors')
                    ? Session::get('errors')->getBag('default')->getMessages()
                    : (object) [];
            },
        ]);
    }

    protected function registerLengthAwarePaginator()
    {
        $this->app->bind(LengthAwarePaginator::class, function ($app, $values) {
            return new class(...array_values($values)) extends LengthAwarePaginator {
                protected array $columns;

                public function only(...$attributes)
                {
                    $this->columns = $attributes;

                    array_unshift($attributes, 'id');

                    return $this->transform(fn ($item) => $item->only($attributes));
                }

                public function transform($callback)
                {
                    $this->items->transform($callback);

                    return $this;
                }

                public function toArray()
                {
                    return [
                        'columns' => $this->columns,
                        'data'    => $this->items->toArray(),
                        'links'   => $this->links(),
                    ];
                }

                public function links($view = null, $data = [])
                {
                    $this->appends(Request::all());

                    $window = UrlWindow::make($this);

                    $elements = array_filter([
                        $window['first'],
                        is_array($window['slider']) ? '...' : null,
                        $window['slider'],
                        is_array($window['last']) ? '...' : null,
                        $window['last'],
                    ]);

                    return collect([
                        'prev' => [
                            'url'    => $this->previousPageUrl(),
                            'label'  => __('pagination.previous'),
                            'active' => false,
                        ],
                        'next' => [
                            'url'    => $this->nextPageUrl(),
                            'label'  => __('pagination.next'),
                            'active' => false,
                        ],
                        'pages' => Collection::make($elements)->flatMap(function ($item) {
                            if (is_array($item)) {
                                return Collection::make($item)->map(function ($url, $page) {
                                    return [
                                        'url'    => $url,
                                        'label'  => $page,
                                        'active' => $this->currentPage() === $page,
                                    ];
                                });
                            } else {
                                return [
                                    [
                                        'url'    => null,
                                        'label'  => '...',
                                        'active' => false,
                                    ],
                                ];
                            }
                        }),
                    ]);
                }
            };
        });
    }
}
