<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Champion;
use Illuminate\Http\Request;

class ChampionController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->validate([
            'query' => 'nullable'
        ]);

        $query = Champion::query();

        if (isset($data['query'])) {
            $query->where('name', 'LIKE', '%' . $data['query'] . '%');
        }

        return response()->json($query->get());
    }
}
