// app/components/list/ui/BriefListItemUi.tsx
'use client'

import Link from 'next/link';
import { ListItemProps } from '@/app/components/list';

export function BriefListItemUi({
                                    entityItem,
                                    categoryName
                                }: ListItemProps) {
    return (
        <Link
            href={`/${categoryName}/${entityItem.slug || entityItem.id}`}
            className="bg-gray-200 text-gray-800 px-3 py-1 rounded-full hover:opacity-80"
        >
            {entityItem.title}
        </Link>
    );
}