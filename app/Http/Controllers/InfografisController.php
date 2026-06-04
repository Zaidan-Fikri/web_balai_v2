<?php

namespace App\Http\Controllers;

use App\Models\Infografis;
use Illuminate\View\View;

class InfografisController extends Controller
{
    public function index(): View
    {
        $infografisItems = Infografis::query()
            ->with('images')
            ->latest()
            ->paginate(12);

        return view('pages.infografis.index', compact('infografisItems'));
    }
}
