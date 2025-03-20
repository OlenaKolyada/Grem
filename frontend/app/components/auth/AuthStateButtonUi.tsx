// app/components/auth/AuthStateButtonUi.tsx
import Link from 'next/link';
import { Button } from '@/app/ui/elements';
import { BG_LIGHT_BLUE_HOVER, BG_MEDIUM_BLUE } from "@/app/ui/theme/colors";
import { User } from '@/app/lib/types';

interface AuthStateButtonUiProps {
    isAuthenticated: boolean;
    user: User | null;
    handleLogout: () => Promise<void>;
}

export function AuthStateButtonUi({ isAuthenticated, user, handleLogout }: AuthStateButtonUiProps) {
    if (isAuthenticated) {
        return (
            <div className="flex items-center gap-3">
                <div className="flex flex-col mr-3">
                    <span className="text-xl text-white">Hello, {user?.nickname}!</span>
                    <span className="text-sm text-gray-300">{user?.email}</span>
                </div>
                <Button
                    onClick={handleLogout}
                    className={`px-3 py-1 w-40 justify-center ${BG_MEDIUM_BLUE} ${BG_LIGHT_BLUE_HOVER}`}
                >
                    Sign Out
                </Button>
            </div>
        );
    }

    return (
        <Link href="/login" className="block">
            <Button className={`px-3 py-1 w-48 justify-center ${BG_MEDIUM_BLUE} ${BG_LIGHT_BLUE_HOVER}`}>
                Sign In | Register
            </Button>
        </Link>
    );
}