<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Jenssegers\Agent\Agent;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //dd(User::all());
        return view('admin.users.index', [
            'users' => User::simplePaginate(15)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, User $user)
    {
        $sessions = $this->sessions($request, $user)->all();
        // dd($sessions);

        return view('admin.users.show', [
            'user' => $user,
            'sessions' => $sessions
        ]);
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        // dd($request->all());
        $data = [
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'is_admin' => false
        ];

        if ($request->has('is_admin')) {
            $data['is_admin'] = $request->get('is_admin') === 'on';
        }

        $user->update($data);

        return back()->with('status.profile', 'Profile successfully updated.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function updatePassword(UpdatePasswordRequest $request, User $user): RedirectResponse
    {
        $user->update([
            'password' => Hash::make($request->get('password'))
        ]);

        return back()->with('status.password', 'Profile successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')->with('status.user_delete', 'User was successfully deleted');
    }

    /**
     * Get the current sessions.
     *
     * @param Request $request
     * @param User $user
     * @return Collection
     */
    public function sessions(Request $request, User $user): Collection
    {
        if (config('session.driver') !== 'database') {
            return collect();
        }

        return collect(
            DB::connection(config('session.connection'))->table(config('session.table', 'sessions'))
                ->where('user_id', $user->id)
                ->orderBy('last_activity', 'desc')
                ->get()
        )->map(function ($session) use ($request) {
            $agent = $this->createAgent($session);

            return (object) [
                'id' => $session->id,
                'agent' => [
                    'is_desktop' => $agent->isDesktop(),
                    'platform' => $agent->platform(),
                    'browser' => $agent->browser(),
                ],
                'ip_address' => $session->ip_address,
                'is_current_device' => $session->id === $request->session()->getId(),
                'last_active' => Carbon::createFromTimestamp($session->last_activity)->diffForHumans(),
            ];
        });
    }

    /**
     * Create a new agent instance from the given session.
     *
     * @param  mixed  $session
     * @return Agent
     */
    protected function createAgent(mixed $session): Agent
    {
        return tap(new Agent, function ($agent) use ($session) {
            $agent->setUserAgent($session->user_agent);
        });
    }

    /**
     * Log out from other browser sessions.
     *
     */
    public function logoutOtherBrowserSessions(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'current_session' => 'required|string',
        ]);

        if (config('session.driver') !== 'database') {
            return back()->with('status.sessions', 'Unable to delete other browser sessions - session driver is not database');
        }

        $this->deleteOtherSessionRecords($user->id, $validated['current_session']);

        return back()->with('status.sessions', 'Other browser sessions successfully deleted.');
    }

    /**
     * Delete the other browser session records from storage.
     *
     * @param $userId
     * @param $sessionId
     * @return void
     */
    protected function deleteOtherSessionRecords($userId, $sessionId): void
    {
        if (config('session.driver') !== 'database') {
            return;
        }

        DB::connection(config('session.connection'))->table(config('session.table', 'sessions'))
            ->where('user_id', $userId)
            ->where('id', '!=', $sessionId)
            ->delete();
    }
}
