import axios from 'axios';
import type { AxiosInstance, AxiosResponse } from 'axios';

const apiClient: AxiosInstance = axios.create({
    baseURL: import.meta.env.VITE_API_URL as string
});

// Define the Gym type
interface Gym {
    id: string;
    name: string;
    address_id: string;
    url: string;
    price_group: string;
}

// Define the API response type for a list of gyms
interface GymListResponse {
    gyms: Gym[];
}

// Define the API response type for a single gym
interface GymResponse {
    gym: Gym;
}

export default {
    getGyms(): Promise<AxiosResponse<GymListResponse>> {
    return apiClient.get<GymListResponse>('/gyms');
    },
    /*getGymById(id: string): Promise<AxiosResponse<GymResponse>> {
        return apiClient.get<GymResponse>(`/gyms/${id}`);
    },*/
// További API hívások hozzáadása itt
};