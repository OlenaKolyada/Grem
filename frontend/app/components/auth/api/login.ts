// app/components/auth/api/login.ts

import { API_URL } from "@/app/lib/config";

interface LoginCredentials {
    email: string;
    password: string;
}

export async function login(credentials: LoginCredentials): Promise<{ message: string }> {
    const response = await fetch(`${API_URL}/api/login`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        credentials: 'include',
        body: JSON.stringify(credentials),
    });

    if (!response.ok) {
        const errorData = await response.json().catch(() => ({}));
        throw new Error(errorData.error || 'Login failed');
    }

    return response.json();
}
