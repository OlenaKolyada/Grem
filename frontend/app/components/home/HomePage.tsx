// app/components/home/HomePage.tsx
'use client';

import React from 'react';
import { LatestContainer } from '@/app/components/home';

export function HomePage() {

    const featuredCategories = ['news', 'review', 'game'];

    return (
        <div className="container mx-auto py-8">
            <section className="mb-3">
                <LatestContainer categoryNames={featuredCategories} />
            </section>

        </div>
    );
}