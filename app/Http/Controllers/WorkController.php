<?php

namespace App\Http\Controllers;

use App\Work;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WorkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = \Auth::user();
        return view('works.create', ['user' => $user]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $start = Carbon::createFromFormat('Y-m-d\TH:i', $request->get('start'));
        $end = Carbon::createFromFormat('Y-m-d\TH:i', $request->get('end'));
        $hours = $end->diffInMinutes($start) / 60;

        $projectId = $request->get('project');

        Work::create([
            'user_id' => $request->user()->id,
            'project_id' => $projectId,
            'start' => $start,
            'hours' => $hours,
            'work_done' => $request->get('work_done'),
            'rate' => $request->get('rate'),
        ]);

        return redirect("/projects/$projectId");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Work $work
     * @return \Illuminate\Http\Response
     */
    public function show(Work $work)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Work $work
     * @return \Illuminate\Http\Response
     */
    public function edit(Work $work)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Work $work
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Work $work)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Work $work
     * @return \Illuminate\Http\Response
     */
    public function destroy(Work $work)
    {
        //
    }
}
