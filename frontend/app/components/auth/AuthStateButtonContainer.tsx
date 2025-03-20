'use client';

import { useRouter } from 'next/navigation';
import { useAuth } from "@/app/components";
import { AuthStateButtonUi } from './AuthStateButtonUi';
import { useState } from "react";

export function AuthStateButtonContainer() {
    const { isAuthenticated, user, logout, loading } = useAuth();
    const router = useRouter();
    const [isLoggingOut, setIsLoggingOut] = useState(false);

    async function handleLogout() {
        try {
            setIsLoggingOut(true);
            await logout();
            router.push('/login');
        } catch (error) {
            console.error('Logout failed', error);
            setIsLoggingOut(false);
        }
    }

    if (loading || isLoggingOut) {
        return (
            <div className="w-48 h-10 bg-gray-200 animate-pulse rounded"></div>
        );
    }

    return (
        <AuthStateButtonUi
            isAuthenticated={isAuthenticated}
            user={user}
            handleLogout={handleLogout}
        />
    );
}