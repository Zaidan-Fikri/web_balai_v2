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

    public function show(Infografis $infografis): View
    {
        $infografis->load('images');

        $otherInfografis = Infografis::query()
            ->with('images')
            ->where('id', '!=', $infografis->id)
            ->latest()
            ->take(5)
            ->get();

        return view('pages.infografis.show', compact('infografis', 'otherInfografis'));
    }
}
