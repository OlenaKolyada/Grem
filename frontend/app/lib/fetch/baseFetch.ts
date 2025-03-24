// app/lib/fetch/baseFetch.ts
import { API_URL, API_CONFIG } from "@/app/lib/config";

export async function baseFetch<T>(
    endpoint: string,
    queryParams?: Record<string, string>
): Promise<T> {
    if (!API_URL) {
        throw new Error("API_URL is not defined");
    }

    let url = `${API_URL}/api/${endpoint}`;
    if (queryParams && Object.keys(queryParams).length > 0) {
        const searchParams = new URLSearchParams(queryParams);
        url += `?${searchParams.toString()}`;
    }

    const response = await fetch(url, {
        method: "GET",
        headers: API_CONFIG.headers,
        credentials: 'include'
    });

    if (!response.ok) {
        throw new Error(`HTTP error ${response.status}`);
    }

    return response.json();
}