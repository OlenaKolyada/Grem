// app/components/auth/api/logout.ts

const API_URL = 'http://localhost:8000/api';

export async function logout(): Promise<{ message: string }> {
    const response = await fetch(`${API_URL}/logout`, {
        method: 'POST',
        credentials: 'include',
    });

    if (!response.ok) {
        const errorData = await response.json().catch(() => ({}));
        throw new Error(errorData.error || 'Logout failed');
    }

    return response.json();
}
