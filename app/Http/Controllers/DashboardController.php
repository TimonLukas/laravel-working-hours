<?php

namespace App\Http\Controllers;

use App\Work;

class DashboardController extends Controller
{

    public function index()
    {
        if (!\Auth::user()->isManager()) {
            return redirect('projects');
        }

        return view('dashboard', [
            'works' => Work::all()->sortByDesc("created_at"),
        ]);
    }
}
