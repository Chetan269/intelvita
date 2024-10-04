<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $activity = [
            ['user_id' => 1, 'activity_name' => 'Running', 'activity_date' => '2024-09-01', 'points' => 20],
            ['user_id' => 1, 'activity_name' => 'Swimming', 'activity_date' => '2024-10-01', 'points' => 20],
            ['user_id' => 2, 'activity_name' => 'Cycling', 'activity_date' => '2024-10-02', 'points' => 20],
            ['user_id' => 3, 'activity_name' => 'Hiking', 'activity_date' => '2024-10-02', 'points' => 20],
            ['user_id' => 2, 'activity_name' => 'Jogging', 'activity_date' => '2024-09-01', 'points' => 20],
            ['user_id' => 3, 'activity_name' => 'Jogging', 'activity_date' => '2024-09-01', 'points' => 20],
            ['user_id' => 4, 'activity_name' => 'Jogging', 'activity_date' => '2024-09-01', 'points' => 20],
            ['user_id' => 5, 'activity_name' => 'Jogging', 'activity_date' => '2024-09-01', 'points' => 20],
            ['user_id' => 6, 'activity_name' => 'Running', 'activity_date' => '2024-09-28', 'points' => 20],
            ['user_id' => 6, 'activity_name' => 'Jogging', 'activity_date' => '2024-09-01', 'points' => 20],
            ['user_id' => 5, 'activity_name' => 'Running', 'activity_date' => '2024-09-01', 'points' => 20],
        ];
        foreach($activity as $active){
            Activity::create([
                'user_id' => $active['user_id'],
                'activity_name' => $active['activity_name'],
                'activity_date' => $active['activity_date'],
                'points' => $active['points'],
            ]);
        }

        $this->recalculateRanks();
    }

    private function recalculateRanks()
    {
        $users = User::with('activities')->get();

        $userPoints = [];

        foreach ($users as $user) {
            $userPoints[$user->id] = $user->activities->sum('points');
        }

        arsort($userPoints);

        $rank = 1;
        $lastPoints = null;
        foreach ($userPoints as $userId => $totalPoints) {
            $user = User::find($userId);
            if ($totalPoints !== $lastPoints) {

                $user->rank = $rank;
                $lastPoints = $totalPoints;

                $rank++;
            } else {
                $user->rank = $rank - 1;
            }

            $user->save();
        }
    }
}
