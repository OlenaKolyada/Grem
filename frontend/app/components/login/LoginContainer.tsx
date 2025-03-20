// app/components/login/LoginContainer.tsx
'use client';

import { useState } from 'react';
import { useAuth } from '@/app/components/auth';
import { useRouter } from 'next/navigation';
import { LoginUi } from './LoginUi';

export function LoginContainer() {
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [error, setError] = useState('');
    const { login, loading } = useAuth();
    const router = useRouter();

    async function handleSubmit(e: React.FormEvent) {
        e.preventDefault();
        setError('');

        try {
            await login(email, password);
            router.push('/profile');
        } catch {
            setError('Invalid email or password');
        }
    }

    return (
        <LoginUi
            email={email}
            setEmail={setEmail}
            password={password}
            setPassword={setPassword}
            error={error}
            loading={loading}
            onSubmit={handleSubmit}
        />
    );
}