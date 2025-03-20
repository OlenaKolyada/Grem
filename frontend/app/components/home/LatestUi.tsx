// app/components/home/LatestUi.tsx
'use client'

import React from 'react';
import { Entity } from '@/app/lib/types/base-entity';
import { DetailedListItemUi } from '@/app/components/list';

type LatestUiProps = {
    latestItems: Record<string, Entity>;
}

export function LatestUi({ latestItems }: LatestUiProps) {
    const categories = Object.keys(latestItems);

    return (
        <div className="container mx-auto">
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                {categories.map(category => (
                    <div key={category} className="flex flex-col">
                        <h2 className="text-xl font-bold mb-4 capitalize">
                            Latest {category}
                        </h2>
                        <DetailedListItemUi
                            entityItem={latestItems[category]}
                            categoryName={category}
                        />
                    </div>
                ))}
            </div>
        </div>
    );
}