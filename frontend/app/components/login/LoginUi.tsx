// app/components/login/LoginUi.tsx
'use client';

import { Button } from '@/app/ui/elements';

interface LoginLayoutProps {
    email: string;
    setEmail: (email: string) => void;
    password: string;
    setPassword: (password: string) => void;
    error: string;
    loading: boolean;
    onSubmit: (e: React.FormEvent) => void;
}

export function LoginUi({
                                        email,
                                        setEmail,
                                        password,
                                        setPassword,
                                        error,
                                        loading,
                                        onSubmit
                                    }: LoginLayoutProps) {
    return (
        <div className="max-w-md mx-auto mt-10 p-6 bg-white rounded-lg shadow-md">
            <h2 className="text-2xl font-bold mb-6">Login</h2>

            {error && (
                <div className="mb-4 p-3 bg-red-100 text-red-700 rounded">
                    {error}
                </div>
            )}

            <form onSubmit={onSubmit}>
                <div className="mb-4">
                    <label className="block text-gray-700 mb-2" htmlFor="email">
                        Email
                    </label>
                    <input
                        id="email"
                        type="email"
                        value={email}
                        onChange={(e) => setEmail(e.target.value)}
                        className="w-full px-3 py-2 border border-gray-300 rounded"
                        required
                    />
                </div>

                <div className="mb-6">
                    <label className="block text-gray-700 mb-2" htmlFor="password">
                        Password
                    </label>
                    <input
                        id="password"
                        type="password"
                        value={password}
                        onChange={(e) => setPassword(e.target.value)}
                        className="w-full px-3 py-2 border border-gray-300 rounded"
                        required
                    />
                </div>

                <Button
                    type="submit"
                    disabled={loading}
                    variant="primary"
                    className="w-full justify-center"
                >
                    Login
                </Button>
            </form>
        </div>
    );
}