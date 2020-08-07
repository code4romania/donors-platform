<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Donor;
use App\Models\FocusArea;
use App\Models\Grant;
use App\Models\Grantee;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return Inertia::render('Dashboard/Index', [
            'stats' => [
                'donors' => Donor::count(),
                'funding' => 1 * Grant::sum('amount'),
                'focusAreas' => FocusArea::count(),
                'grantees' => Grantee::count(),
            ],
        ]);
    }
}
