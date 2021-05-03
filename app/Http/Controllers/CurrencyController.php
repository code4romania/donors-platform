<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\CurrencyRequest;
use Illuminate\Http\RedirectResponse;

class CurrencyController extends Controller
{
    public function __invoke(CurrencyRequest $request): RedirectResponse
    {
        session()->put('currency', $request->currency);

        return redirect()->back();
    }
}
