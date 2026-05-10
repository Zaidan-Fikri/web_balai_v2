<?php

namespace App\Http\Controllers;

use App\Models\Buletin;
use Illuminate\View\View;

class BuletinController extends Controller
{
    public function index(): View
    {
        $buletins = Buletin::query()
            ->published()
            ->with(['author', 'images'])
            ->latest('published_at')
            ->paginate(9);

        return view('pages.buletin.index', compact('buletins'));
    }

    public function show(Buletin $buletin): View
    {
        abort_unless($buletin->status === Buletin::STATUS_PUBLISHED && $buletin->published_at && $buletin->published_at->lte(now()), 404);

        $buletin->load(['author', 'images']);
        $buletin->increment('views');
        $buletin->refresh();
        $buletin->load(['author', 'images']);

        return view('pages.buletin.show', compact('buletin'));
    }
}
