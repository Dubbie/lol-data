<?php

namespace App\Http\Controllers;

use App\Models\Champion;
use Inertia\Inertia;

class ChampionController extends Controller
{
    public function index()
    {
        return Inertia::render('Champion/Index');
    }

    public function show(string $champion)
    {
        $champion = Champion::where('name', $champion)->first();

        if (!$champion) {
            return redirect(route('champion.index'));
        }

        return Inertia::render('Champion/Show', [
            'champion' => $champion
        ]);
    }
}
