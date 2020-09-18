<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;

class PageController extends Controller
{
    public function __invoke(string $locale, string $slug = 'index')
    {
        $view = "public.pages.$slug";

        abort_unless(View::exists($view), 404);

        return View::make($view);
    }
}
