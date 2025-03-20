'use client';

import Link from 'next/link';
import { usePathname, useSearchParams } from 'next/navigation';
import clsx from 'clsx';
import { navLinks } from '@/app/components/menu';
import { Button } from '@/app/ui/elements';

type NavLinksUiProps = {
    styles: {
        link: string;
        activeLink: string;
        text: string;
    };
}

export function NavLinksUi({ styles }: NavLinksUiProps) {
    const pathname = usePathname();
    const searchParams = useSearchParams();

    return (
        <>
            {navLinks.map((link) => {
                const isActive = () => {
                    const linkHref = link.href;

                    if (linkHref.startsWith('http')) {
                        return false;
                    }

                    const [linkPath, linkQuery] = linkHref.split('?');

                    if (pathname !== linkPath) {
                        return false;
                    }

                    if (!linkQuery) {
                        return !searchParams.has('status');
                    }

                    const linkStatus = new URLSearchParams(linkQuery).get('status');

                    return linkStatus === searchParams.get('status');
                };

                return (
                    <Link
                        key={link.name}
                        href={link.href}
                        className={styles.link}
                    >
                        <Button
                            variant="secondary"
                            isActive={isActive()}
                            className={clsx(
                                "w-40",
                                isActive() && styles.activeLink
                            )}
                        >
                            <span className={styles.text}>{link.name}</span>
                        </Button>
                    </Link>
                );
            })}
        </>
    );
}