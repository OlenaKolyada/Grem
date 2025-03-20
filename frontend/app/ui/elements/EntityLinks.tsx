// app/ui/elements/EntityLinks.tsx

import React from 'react';
import Link from "next/link";

interface EntityLinksProps {
    className?: string;
}

export function EntityCollectionLink({
                                                categoryName,
                                                className = "bg-gray-200 text-slate-600 text-xs px-3 py-1 m-1 rounded-full hover:opacity-80"
                                            }: EntityLinksProps & { categoryName?: string }) {
    if (!categoryName) return null;

    return (
        <Link
            href={`/${categoryName}`}
            className={className}
        >
            All {categoryName}s
        </Link>
    );
}

interface ReadMoreProps extends EntityLinksProps {
    id?: number;
    slug?: string;
    categoryName: string;
}

export function ReadMore({
                                    id,
                                    slug,
                                    categoryName,
                                    className = "text-blue-500 hover:text-blue-700"
                                }: ReadMoreProps) {
    if (id === undefined) return null;

    return (
        <Link
            href={`/${categoryName}/${slug || id}`}
            className={className}
        >
            Read more
        </Link>
    );
}