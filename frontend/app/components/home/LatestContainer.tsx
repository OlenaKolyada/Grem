// app/components/home/LatestContainer.tsx
'use client'

import React from 'react';
import { useLatest } from '@/app/lib/hooks/useLatest';
import { LatestUi } from './LatestUi';

type LatestContainerProps = {
    categoryNames: string[];
}

export function LatestContainer({ categoryNames }: LatestContainerProps) {
    const { data, loading, error } = useLatest(categoryNames);

    if (loading) {
        return <div className="text-center py-10"></div>;
    }

    if (error) {
        return <div className="text-center py-10 text-red-500">Error: {error}</div>;
    }

    if (!data) {
        return <div className="text-center py-10">No data.</div>;
    }

    return (
        <LatestUi latestItems={data} />
    );
}