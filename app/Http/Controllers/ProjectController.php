<?php

namespace App\Http\Controllers;

use App\Project;
use App\Work;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = \Auth::user()->projects;
        return view('projects.index', ['projects' => $projects]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!\Auth::user()->isManager()) {
            return redirect('projects');
        }

        return view('projects.create', ['project' => new Project()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $project = Project::create($request->all());

        return redirect("/projects/$project->id");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Project $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        if (!$this->guard($project)) {
            return redirect("/projects");
        }

        $now = (new Carbon())->subMonth();
        $works = Work::all()->where('project_id', '=', $project->id)->where('start', '>=', $now)->all();

        $days = [];
        foreach ($works as $work) {
            $day = $work->start->format('d');
            if (!isset($days[$day])) {
                $days[$day] = 0;
            }

            $days[$day] += $work->hours;
        }

        $users = [];
        foreach ($works as $work) {
            $day = $work->start->format('d');
            if (!isset($users[$day])) {
                $users[$day] = [];
            }

            if (!in_array($work->user->id, $users[$day], true)) {
                $users[$day][] = $work->user->id;
            }
        }

        $users = array_map(function ($entry) {
            return count($entry);
        }, $users);

        $highest_cost = 0;
        $costs = [];
        foreach ($works as $work) {
            $day = $work->start->format('d');
            if (!isset($costs[$day])) {
                $costs[$day] = 0;
            }

            $costs[$day] += $work->rate * $work->hours;

            if ($highest_cost < $costs[$day]) {
                $highest_cost = $costs[$day];
            }
        }

        return view('projects.show',
            [
                'project' => $project,
                'labels' => array_keys($days),
                'hours' => array_values($days),
                'users' => array_values($users),
                'costs' => array_values($costs),
                'highest_cost' => $highest_cost,
            ]
        );
    }

    /**
     * Checks current user privileges before allowing them through
     *
     * @param Project $project The work which will be looked at
     * @return bool
     */
    private function guard(Project $project)
    {
        $user = \Auth::user();
        if ($user->isConnectedToProject($project) || $user->isManager()) {
            return true;
        }

        return false;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Project $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        if (!$this->guard($project)) {
            return redirect("/projects");
        }

        if (!\Auth::user()->isManager()) {
            return redirect("/projects/$project->id");
        }

        return view('projects.edit', ['project' => $project]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Project $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        if (!$this->guard($project)) {
            return redirect("/projects");
        }

        $project->update($request->all());
        return redirect("/projects/$project->id");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        if (!$this->guard($project)) {
            return redirect("/projects");
        }

        $project->delete();
        return redirect('/projects');
    }
}
