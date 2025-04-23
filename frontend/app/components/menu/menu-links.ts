// app/components/menu/menu-links.ts

import { API_URL } from "@/app/lib/config/config";

type Link = {
    name: string;
    href: string;
};

export const navLinks: Link[] = [
    { name: 'News', href: '/news' },
    { name: 'News Draft', href: '/news?status=Draft' },
    { name: 'News Archived', href: '/news?status=Archived' },
    { name: 'News Deleted', href: '/news?status=Deleted' },
    { name: 'Reviews', href: '/review' },
    { name: 'Reviews Draft', href: '/review?status=Draft' },
    { name: 'Reviews Archived', href: '/review?status=Archived' },
    { name: 'Reviews Deleted', href: '/review?status=Deleted' },
    { name: 'Games', href: '/game' },
    { name: 'Games Draft', href: '/game?status=Draft' },
    { name: 'Games Archived', href: '/game?status=Archived' },
    { name: 'Games Deleted', href: '/game?status=Deleted' }
];

export const adminLinks: Link[] = [
    { name: 'Admin', href: `${API_URL}/api/admin` },
    { name: 'API Doc', href: `${API_URL}/api/doc` }
];

export const profileLinks: Link[] = [
    { name: 'User Profile', href: '/profile' }
];

export const topMenuStyles = {
    link: 'flex h-[48px] grow items-center justify-center gap-2 text-xl font-medium text-white-50 hover:text-blue-400 mr-9',
    activeLink: 'text-blue-600 text-sky-300',
    icon: 'w-6',
    text: 'block',
};

export const sideMenuStyles = {
    link: 'w-full hidden md:flex md:h-[48px] md:flex-none md:justify-start md:p-2 md:px-3',
    activeLink: 'bg-gray-400 text-gray-900',
    text: 'md:block',
};