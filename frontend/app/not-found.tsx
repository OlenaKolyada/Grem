import type { Metadata } from 'next';
import Link from 'next/link';
import { Button } from '@/app/ui/elements';

export const metadata: Metadata = {
    title: 'Page Not Found | Grem',
    description: 'The page you are looking for does not exist'
};

export default function NotFound() {
    return (
        <div className="w-full max-w-full mx-auto flex flex-col items-center justify-center min-h-[70vh] px-4 text-center">
            <h1 className="text-6xl text-gray-800 mb-4">404</h1>
            <p className="text-xl text-gray-600 mb-6">Page not found</p>
            <Link href="/" className="block">
                <Button variant="secondary">
                    Back to home
                </Button>
            </Link>
        </div>
    );
}