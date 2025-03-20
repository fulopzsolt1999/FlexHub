import axios from 'axios';
import type { AxiosInstance, AxiosResponse } from 'axios';

const apiClient: AxiosInstance = axios.create({
    baseURL: import.meta.env.VITE_API_URL as string,
    withCredentials: true,
});

// Interceptor hozzáadása az Axios-hoz, hogy minden kéréshez hozzáadjuk a userId-t és isAdmin-t
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

// Define the API response type for register and login
interface AuthResponse {
    message: string;
    user?: {
        id: string;
        user_name: string;
        email: string;
        is_admin: string;
    };
}

// Define the Gym type
interface Gym {
    id: string;
    name: string;
    address_id: string;
    url: string;
    price_group: string;
}

// Define the City type
interface City {
    id: string;
    name: string;
}

// Define the Day type
interface Day {
    id: string;
    name: string;
}

// Define the RestDay type
interface RestDay {
    id: string;
    user_id: string;
    day_id: string;
}

// Define the Address type
interface Address {
    id: string;
    city_id: string;
    street: string;
    street_number: string;
}

// Define the MuscleGroup type
interface MuscleGroup {
    id: string;
    name: string;
}

// Define the Exercise type
interface Exercise {
    id: string;
    name: string;
    muscle_group_id: string;
    image: string;
    video: string;
}

// Define the WorkoutPlan type
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

// Define the API response type for a list of gyms
interface GymListResponse {
    gyms: Gym[];
}

// Define the API response type for a list of days
interface DayListResponse {
    days: Day[];
}

// Define the API response type for a list of days
interface RestDayListResponse {
    rest_days: RestDay[];
}

// Define the API response type for a single address
interface AddressResponse {
    address: Address;
}

// Define the API response type for a single city
interface CityResponse {
    city: City;
}

// Define the API response type for a single rest day
interface RestDayResponse {
    rest_day: RestDay;
}

// Define the API response type for a list of muscle groups
interface MouscleGroupResponse {
    muscle_group: MuscleGroup;
}

// Define the API response type for a list of exercises
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