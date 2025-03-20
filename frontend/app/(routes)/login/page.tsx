import { LoginContainer } from "@/app/components/login";
import type { Metadata } from 'next';

export const metadata: Metadata = {
    title: 'Login | Grem',
    description: 'Log in to your Grem account'
};

export default function LoginPage() {
    return <LoginContainer />;
}