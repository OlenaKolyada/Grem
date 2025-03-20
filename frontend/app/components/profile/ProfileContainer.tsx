// app/components/profile/ProfileContainer.tsx
'use client';

import { ProfileUi } from "@/app/components/profile";
import { ProtectedRoute, useAuth } from "@/app/components/auth";

export function ProfileContainer() {
    const { user, loading } = useAuth();

    return (
        <ProtectedRoute>
            {loading && <p></p>}
            {!loading && user && <ProfileUi user={user} />}
        </ProtectedRoute>
    );
}