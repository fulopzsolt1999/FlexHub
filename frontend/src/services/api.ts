import axios from 'axios';
import type { AxiosInstance, AxiosResponse } from 'axios';

const apiClient: AxiosInstance = axios.create({
    baseURL: import.meta.env.VITE_API_URL as string,
    withCredentials: true,
});

apiClient.interceptors.request.use((config) => {
    const userId = sessionStorage.getItem('userId');
    const isAdmin = sessionStorage.getItem('isAdmin');

    if (userId) {
        config.headers['X-User-Id'] = userId;
    }
    if (isAdmin) {
        config.headers['X-Is-Admin'] = isAdmin;
    }

    return config;
});

interface AuthResponse {
    message: string;
    user?: {
        id: string;
        user_name: string;
        email: string;
        is_admin: string;
    };
}

interface Gym {
    id: string;
    name: string;
    address_id: string;
    url: string;
    price_group: string;
}

interface City {
    id: string;
    name: string;
}

interface Day {
    id: string;
    name: string;
}

interface RestDay {
    id: string;
    user_id: string;
    day_id: string;
}

interface Address {
    id: string;
    city_id: string;
    street: string;
    street_number: string;
}

interface MuscleGroup {
    id: string;
    name: string;
}

interface Exercise {
    id: string;
    name: string;
    muscle_group_id: string;
    image: string;
    video: string;
}

interface WorkoutPlan {
    id: string;
    user_id: string;
    day_id: string;
    mouscle_group_id: string;
    exercise_id: string;
    series: string;
    reps: string;
    comment: string;
}

interface GymListResponse {
    gyms: Gym[];
}

interface DayListResponse {
    days: Day[];
}

interface RestDayListResponse {
    rest_days: RestDay[];
}

interface AddressResponse {
    address: Address;
}

interface CityResponse {
    city: City;
}

interface RestDayResponse {
    rest_day: RestDay;
}

interface MouscleGroupResponse {
    muscle_group: MuscleGroup;
}

interface ExerciseResponse {
    exercise: Exercise;
}

interface WorkoutPlanResponse {
    workout: WorkoutPlan;
}

export default {
    register(data: { user_name: string; email: string; password: string }): Promise<AxiosResponse<AuthResponse>> {
        return apiClient.post<AuthResponse>('/register', data);
    },
    login(data: { user_name: string; password: string }): Promise<AxiosResponse<AuthResponse>> {
        return apiClient.post<AuthResponse>('/login', data);
    },
    forgotPassword(data: { email: string }): Promise<AxiosResponse<{ message: string }>> {
        return apiClient.post('/forgot-password', data);
    },
    resetPassword(data: { token: string; password: string; password_confirmation: string }): Promise<AxiosResponse<{ message: string }>> {
        return apiClient.post('/reset-password', data);
    },
    getGyms(): Promise<AxiosResponse<GymListResponse>> {
    return apiClient.get<GymListResponse>('/gyms');
    },
    getAddressById(id: string): Promise<AxiosResponse<AddressResponse>> {
        return apiClient.get<AddressResponse>(`/addresses/${id}`);
    },
    getCityById(id: string): Promise<AxiosResponse<CityResponse>> {
        return apiClient.get<CityResponse>(`/cities/${id}`);
    },
    getDays(): Promise<AxiosResponse<DayListResponse>> {
        return apiClient.get<DayListResponse>('/days');
    },
    getRestDays(userId: string): Promise<AxiosResponse<RestDayListResponse>> {
        return apiClient.get<RestDayListResponse>(`/rest-days/${userId}`);
    },
    createRestDay(userId: string, dayId: string): Promise<AxiosResponse<RestDayResponse>> {
        return apiClient.post<RestDayResponse>(`/rest-days/${userId}/${dayId}`);
    },
    deleteRestDay(userId: string, dayId: string): Promise<AxiosResponse<RestDayResponse>> {
        return apiClient.delete<RestDayResponse>(`/rest-days/${userId}/${dayId}`);
    },
    getMuscleGroups(): Promise<AxiosResponse<MouscleGroupResponse>> {
        return apiClient.get<MouscleGroupResponse>('/muscle-groups');
    },
    getExercisesByMuscleGroup(muscleGroupId: string): Promise<AxiosResponse<ExerciseResponse>> {
        return apiClient.get<ExerciseResponse>(`/exercises/${muscleGroupId}`);
    },
    getWorkoutPlans(userId: string, dayId: number): Promise<AxiosResponse<WorkoutPlanResponse>> {
        return apiClient.get<WorkoutPlanResponse>(`/workout-plans/${userId}/${dayId}`);
    },
    getWorkoutPlan(userId: string, dayId: number): Promise<AxiosResponse<WorkoutPlanResponse>> {
        return apiClient.get<WorkoutPlanResponse>(`/workout-plan/${userId}/${dayId}`);
    },
    deleteWorkoutPlan(userId: string, dayId: number): Promise<AxiosResponse<WorkoutPlanResponse>> {
        return apiClient.delete<WorkoutPlanResponse>(`/workout-plan/${userId}/${dayId}`);
    },
    saveWorkoutPlan(userId: string, dayId: number, exercises: any[]): Promise<AxiosResponse<WorkoutPlanResponse>> {
        return apiClient.post<WorkoutPlanResponse>(`/workout-plan/${userId}/${dayId}`, { exercises });
    },
    getTotalUsers(): Promise<AxiosResponse<{ total_users: number }>> {
        return apiClient.get('/admin/total-users');
    },
    getWorkoutPlanStats(): Promise<AxiosResponse<{ users_with_workout_plans: number; percentage_with_workout_plans: number }>> {
        return apiClient.get('/admin/workout-plan-stats');
    },
    getMonthlyStats(): Promise<AxiosResponse<{ monthly_users: { month: string; total_users: number }[]; monthly_workout_plans: { month: string; users_with_workout_plans: number }[] }>> {
        return apiClient.get('/admin/monthly-stats');
    },
};