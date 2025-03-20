<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function getTotalUsers()
    {
        $totalUsers = User::count();
        return response()->json(['total_users' => $totalUsers]);
    }

    public function getWorkoutPlanStats()
    {
        $totalUsers = User::count();
        $usersWithWorkoutPlans = DB::table('workout_plans')
            ->distinct('user_id')
            ->count('user_id');

        $percentageWithWorkoutPlans = $totalUsers > 0
            ? ($usersWithWorkoutPlans / $totalUsers) * 100
            : 0;

        return response()->json([
            'users_with_workout_plans' => $usersWithWorkoutPlans,
            'percentage_with_workout_plans' => $percentageWithWorkoutPlans,
        ]);
    }

    public function getMonthlyStats()
    {
        // Havi regisztrált felhasználók
        $monthlyUsers = User::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as total_users")
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Havi edzéstervet készítők (a regisztráció dátuma alapján)
        $monthlyWorkoutPlans = User::join('workout_plans', 'users.id', '=', 'workout_plans.user_id')
            ->selectRaw("DATE_FORMAT(users.created_at, '%Y-%m') as month, COUNT(DISTINCT users.id) as users_with_workout_plans")
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return response()->json([
            'monthly_users' => $monthlyUsers,
            'monthly_workout_plans' => $monthlyWorkoutPlans,
        ]);
    }
}
