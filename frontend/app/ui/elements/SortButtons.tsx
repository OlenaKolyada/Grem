'use client';

import { useRouter, useSearchParams } from 'next/navigation';

export function SortButtons() {
    const router = useRouter();
    const searchParams = useSearchParams();

    const currentSort = searchParams.get('sort') || 'updatedAt:desc';

    const handleSortChange = (sortValue: string) => {
        const params = new URLSearchParams(searchParams.toString());
        params.set('sort', sortValue);
        params.set('page', '1');
        router.push(`?${params.toString()}`);
    };

    return (
        <div className="mb-4 flex gap-2">
            <button
                className={`px-3 py-1 border rounded ${
                    currentSort === 'updatedAt:desc' ? 'bg-gray-200' : ''
                }`}
                onClick={() => handleSortChange('updatedAt:desc')}
            >
                Newest first
            </button>
            <button
                className={`px-3 py-1 border rounded ${
                    currentSort === 'updatedAt:asc' ? 'bg-gray-200' : ''
                }`}
                onClick={() => handleSortChange('updatedAt:asc')}
            >
                Oldest first
            </button>
        </div>
    );
}
