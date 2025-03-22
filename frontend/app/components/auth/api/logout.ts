// app/components/auth/api/logout.ts

import { API_URL } from "@/app/lib/config";

export async function logout(): Promise<{ message: string }> {
    const response = await fetch(`${API_URL}/api/logout`, {
        method: 'POST',
        credentials: 'include',
    });

    if (!response.ok) {
        const errorData = await response.json().catch(() => ({}));
        throw new Error(errorData.error || 'Logout failed');
    }

    return response.json();
}
