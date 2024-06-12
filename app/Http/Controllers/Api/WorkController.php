<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Work;
use Illuminate\Http\Request;

class WorkController extends Controller
{
    public function index(Request $request){

        $results = Work::with('type', 'technologies')->paginate(10);

        return response()->json([
            'results' => $results,
        ]);

    }
}
