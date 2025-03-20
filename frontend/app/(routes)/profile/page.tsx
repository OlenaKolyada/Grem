import type { Metadata } from 'next';
import { ProfileContainer } from "../../components/profile";

export const metadata: Metadata = {
    title: 'Your Profile | Grem',
    description: 'Manage your Grem profile and preferences'
};

export default function Page() {
    return <ProfileContainer />;
}