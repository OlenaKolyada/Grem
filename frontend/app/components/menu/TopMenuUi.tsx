// app/components/menu/TopMenuUi.tsx
'use client';

import Link from "next/link";
import { adminLinks, profileLinks, topMenuStyles } from '@/app/components/menu';

interface TopMenuUiProps {
    isAdmin?: boolean;
    isAuthenticated?: boolean;
}

export function TopMenuUi({ isAdmin = false, isAuthenticated = false }: TopMenuUiProps) {
    return (
        <div className={`flex h-full flex-row px-3 py-4 md:px-2`}>
            {isAdmin && (
                <>
                    {adminLinks.map(link => (
                        <Link
                            key={link.name}
                            href={link.href}
                            className={topMenuStyles.link}
                            {...(link.name === 'API Doc' ? { target: "_blank", rel: "noopener noreferrer" } : {})}
                        >
                            {link.name}
                        </Link>
                    ))}
                </>
            )}

            {isAuthenticated && (
                <>
                    {profileLinks.map(link => (
                        <Link
                            key={link.name}
                            href={link.href}
                            className={topMenuStyles.link}
                        >
                            {link.name}
                        </Link>
                    ))}
                </>
            )}
        </div>
    );
}