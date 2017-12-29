<?php

namespace App\Http\Controllers;

use App\User;
use App\UserProject;
use App\Work;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('users.index', [
            'users' => User::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create', ['user' => new User()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'is_manager' => $request->get('isManager') === 'on',
            'rate' => $request->get('rate'),
            'password' => bcrypt(random_bytes(100))
        ]);

        if ($request->has('projects')) {
            foreach ($request->get('projects') as $project) {
                UserProject::create([
                    'user_id' => $user->id,
                    'project_id' => $project,
                ]);
            }
        }

        return redirect("users/$user->id");
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        $now = (new Carbon())->subMonth();
        $works = Work::all()->where('user_id', '=', $user->id)->where('start', '>=', $now)->all();
        $works = collect($works)->sortBy('start', false);

        $days = [];
        foreach ($works as $work) {
            $day = $work->start->format('d');
            if (!isset($days[$day])) {
                $days[$day] = 0;
            }

            $days[$day] += $work->hours;
        }

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

        return view('users.show', [
            'user' => $user,
            'labels' => array_keys($days),
            'hours' => array_values($days),
            'costs' => array_values($costs),
            'highest_cost' => $highest_cost,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('users.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->update([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'is_manager' => $request->get('isManager') === 'on',
            'rate' => $request->get('rate'),
        ]);

        UserProject::whereUserId($id)->delete();

        if ($request->has('projects')) {
            foreach ($request->get('projects') as $project) {
                UserProject::create([
                    'user_id' => $id,
                    'project_id' => $project,
                ]);
            }
        }

        return redirect("/users/$id");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect('/users');
    }
}
