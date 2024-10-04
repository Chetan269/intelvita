<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
class LeaderboardController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->input('filter', 'all');

        $currentDate = Carbon::now();

        $users = User::select('users.id', 'users.full_name', 'users.rank')
            ->join('activities', 'users.id', '=', 'activities.user_id')
            ->selectRaw('SUM(activities.points) as filtered_points')
            ->groupBy('users.id', 'users.full_name', 'users.rank');

        if ($filter == 'day') {
            $users->whereDate('activities.activity_date', $currentDate->toDateString());
        } elseif ($filter == 'month') {
            $users->whereMonth('activities.activity_date', $currentDate->month)
                ->whereYear('activities.activity_date', $currentDate->year);
        } elseif ($filter == 'year') {
            $users->whereYear('activities.activity_date', $currentDate->year);
        }

        $priorityUserId = $request->input('user_id');

        if ($priorityUserId) {
            $users->orderByRaw('CASE WHEN users.id = ? THEN 0 ELSE 1 END', [$priorityUserId]);
        }

        $users = $users->orderBy('filtered_points', 'desc')->get();

        return view('leaderboard', compact('users', 'filter','priorityUserId'));
    }


    public function recalculate()
    {
        $users = User::with('activities')->get();

        // Prepare an array to hold user total points
        $userPoints = [];

        // Calculate total points for each user
        foreach ($users as $user) {
            $userPoints[$user->id] = $user->activities->sum('points');
        }

        // Sort users by total points in descending order
        arsort($userPoints);

        $rank = 1;
        $lastPoints = null;
        foreach ($userPoints as $userId => $totalPoints) {
            $user = User::find($userId); // Find the user by ID
            if ($totalPoints !== $lastPoints) {

                $user->rank = $rank;
                $lastPoints = $totalPoints;

                $rank++;
            } else {
                $user->rank = $rank - 1;
            }

            $user->save();
        }
        return redirect()->route('leaderboard');
    }
}
