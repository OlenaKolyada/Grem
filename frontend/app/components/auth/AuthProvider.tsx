// app/components/auth/AuthProvider.tsx
'use client';

import React, { createContext, useState, useEffect, ReactNode } from 'react';
import * as api from './api';
import {User} from "@/app/lib/types";

interface AuthContextType {
    user: User | null;
    isAuthenticated: boolean;
    loading: boolean;
    login: (email: string, password: string) => Promise<void>;
    logout: () => Promise<void>;
}

const AuthContext = createContext<AuthContextType | undefined>(undefined);

export function AuthProvider({ children }: { children: ReactNode }) {
    const [user, setUser] = useState<User | null>(null);
    const [loading, setLoading] = useState(true);

    async function checkAuth() {
        try {
            const userData = await api.profile();
            setUser(userData);
        } catch {
            setUser(null);
        } finally {
            setLoading(false);
        }
    }

    useEffect(() => {
        checkAuth();
    }, []);

    async function login(email: string, password: string) {
        setLoading(true);
        try {
            await api.login({ email, password });
            await checkAuth();
        } finally {
            setLoading(false);
        }
    }

    async function logout() {
        setLoading(true);
        try {
            await api.logout();
            setUser(null);
        } finally {
            setLoading(false);
        }
    }

    return (
        <AuthContext.Provider value={{
            user,
            isAuthenticated: !!user,
            loading,
            login,
            logout
        }}>
            {children}
        </AuthContext.Provider>
    );
}

export default AuthContext;