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

// Define the City type
interface City {
    id: string;
    name: string;
}

// Define the Address type
interface Address {
    id: string;
    city_id: string;
    street: string;
    street_number: string;
}

// Define the API response type for a list of gyms
interface GymListResponse {
    gyms: Gym[];
}

// Define the API response type for a single address
interface AddressResponse {
    address: Address;
}

// Define the API response type for a single city
interface CityResponse {
    city: City;
}

export default {
    getGyms(): Promise<AxiosResponse<GymListResponse>> {
    return apiClient.get<GymListResponse>('/gyms');
    },
    getAddressById(id: string): Promise<AxiosResponse<AddressResponse>> {
        return apiClient.get<AddressResponse>(`/addresses/${id}`);
    },
    getCityById(id: string): Promise<AxiosResponse<CityResponse>> {
        return apiClient.get<CityResponse>(`/cities/${id}`);
    },
// További API hívások hozzáadása itt
};