// app/components/protected-route.tsx
'use client';

import { useRouter } from 'next/navigation';
import { useEffect } from 'react';
import {useAuth} from "@/app/components";

export function ProtectedRoute({ children }: { children: React.ReactNode }) {
    const { isAuthenticated, loading } = useAuth();
    const router = useRouter();

    useEffect(() => {
        if (!loading && !isAuthenticated) {
            router.push('/login');
        }
    }, [isAuthenticated, loading, router]);

    if (loading) {
        return <div></div>;
    }

    if (!isAuthenticated) {
        return null; // Контент не будет отображаться во время перенаправления
    }

    return <>{children}</>;
}