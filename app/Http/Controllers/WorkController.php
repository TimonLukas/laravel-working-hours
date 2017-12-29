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
        return redirect("");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = \Auth::user();

        if (!$user->isManager()) {
            return redirect('works/create/start');
        }

        return view('works.create', [
            'user' => $user,
            'work' => new Work(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createStart()
    {
        $user = \Auth::user();
        return view('works.create', [
            'user' => $user,
            'work' => new Work(),
            'option' => "createStart",
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function createEnd(int $id)
    {
        $work_unit = Work::find($id);

        $user = \Auth::user();
        return view('works.create', [
            'user' => $user,
            'work' => $work_unit,
            'option' => "createEnd",
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $option = $request->get('option') ?? "";
        $rate = $request->get('rate') ?? $request->user()->rate;

        if ($option === "createStart") {
            $projectId = $request->get('project');
            $start = Carbon::now();
            $end = Carbon::now();
            $hours = round($end->diffInMinutes($start) / 60, 2);

            Work::create([
                'user_id' => $request->user()->id,
                'project_id' => $projectId,
                'start' => $start,
                'hours' => $hours,
                'work_done' => $request->get('work_done') ?? "",
                'rate' => $rate,
                'ip_address_start' => $_SERVER['REMOTE_ADDR'],
            ]);
        } elseif ($option === "createEnd") {
            $work_unit = Work::find($request->get("work_unit"));
            $projectId = $work_unit->project->id;

            $start = $work_unit->start;
            $end = Carbon::now();
            $hours = round($end->diffInMinutes($start) / 60, 2);

            $work_unit->hours = $hours;
            $work_unit->work_done = $request->get('work_done') ?? "";
            $work_unit->ip_address_end = $_SERVER['REMOTE_ADDR'];

            $work_unit->save();
        } else {
            $projectId = $request->get('project');
            $start = Carbon::createFromFormat('Y-m-d\TH:i', $request->get('start'));
            $end = Carbon::createFromFormat('Y-m-d\TH:i', $request->get('end'));
            $hours = round($end->diffInMinutes($start) / 60, 2);

            $rate = $request->get('rate') ?? $request->user()->rate;

            $projectId = $request->get('project');

            Work::create([
                'user_id' => $request->user()->id,
                'project_id' => $projectId,
                'start' => $start,
                'hours' => $hours,
                'work_done' => $request->get('work_done') ?? "",
                'rate' => $rate,
                'ip_address_start' => $_SERVER['REMOTE_ADDR'],
                'ip_address_end' => $_SERVER['REMOTE_ADDR'],
            ]);
        }

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
        if (!$this->guard($work)) {
            return redirect("/projects/$work->project_id");
        }

        return view('works.show', ['work' => $work]);
    }

    /**
     * Checks current user privileges before allowing them through
     *
     * @param Work $work The work which will be looked at
     * @return bool
     */
    private function guard(Work $work)
    {
        $user = \Auth::user();
        if ($user->id === $work->user->id || $user->isManager()) {
            return true;
        }

        return false;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Work $work
     * @return \Illuminate\Http\Response
     */
    public function edit(Work $work)
    {
        if (!$this->guard($work)) {
            return redirect("/projects/$work->project_id");
        }

        if (!\Auth::user()->isManager()) {
            return redirect("/works/$work->id");
        }

        return view('works.edit', ['work' => $work, 'user' => \Auth::user()]);
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
        if (!$this->guard($work)) {
            return redirect("/projects/$work->project_id");
        }

        $start = Carbon::createFromFormat('Y-m-d\TH:i', $request->get('start'));
        $end = Carbon::createFromFormat('Y-m-d\TH:i', $request->get('end'));
        $hours = round($end->diffInMinutes($start) / 60, 2);

        $rate = $request->get('rate') ?? $request->user()->rate;

        $projectId = $request->get('project');

        $work->update([
            'project_id' => $projectId,
            'start' => $start,
            'hours' => $hours,
            'work_done' => $request->get('work_done'),
            'rate' => $rate,
        ]);

        return redirect("/projects/$projectId");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Work $work
     * @return \Illuminate\Http\Response
     */
    public function destroy(Work $work)
    {
        $project_id = $work->project_id;

        if (!$this->guard($work)) {
            return redirect("/projects/$project_id");
        }

        Work::find($work->id)->delete();
        return redirect("/projects/$project_id");
    }
}
