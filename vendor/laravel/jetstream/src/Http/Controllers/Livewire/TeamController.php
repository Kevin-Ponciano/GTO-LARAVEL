<?php

namespace Laravel\Jetstream\Http\Controllers\Livewire;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Laravel\Jetstream\Jetstream;

class TeamController extends Controller
{
    /**
     * Show the team management screen.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $teamId
     * @return \Illuminate\View\View
     */
    public function show(Request $request, $teamId)
    {
        $team = Jetstream::newTeamModel()->findOrFail($teamId);

        if (!$team->userHasPermission(\Auth::user(), 'manager')) {
            return abort(404);
        }

        return view('teams.show', [
            'user' => $request->user(),
            'team' => $team,
        ]);
    }

    /**
     * Show the team creation screen.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        Gate::authorize('create', Jetstream::newTeamModel());

        return view('teams.create', [
            'user' => $request->user(),
        ]);
    }
}
