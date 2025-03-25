'use client';

import { useAuth } from '@/app/components/auth';
import { TopMenuUi } from '@/app/components/menu';
import { AuthStateButtonContainer } from '@/app/components/auth/AuthStateButtonContainer';

export function TopMenuContainer() {
    const { user, isAuthenticated, loading } = useAuth();
    const isAdmin = isAuthenticated && user?.roles && user.roles.includes('ROLE_ADMIN');

    if (loading) {
        return (
            <div className="flex h-full flex-row px-3 py-4 md:px-2 justify-between">
                <div className="flex space-x-4">
                    {/* Скелетон для пунктов меню */}
                    {[1, 2, 3].map((item) => (
                        <div key={item} className="h-10 w-20 animate-pulse rounded"></div>
                    ))}
                </div>
                <div className="w-20 h-10 animate-pulse rounded"></div>
            </div>
        );
    }

    return (
        <div className="w-full flex justify-between items-center">
            <TopMenuUi isAdmin={isAdmin} isAuthenticated={isAuthenticated} />
            <div className="flex-shrink-0">
                <AuthStateButtonContainer />
            </div>
        </div>
    );
}