'use client'

import { CoreEntityUi } from "@/app/components/entity";
import { fetchEntityBySlug } from "@/app/lib/fetch";
import { Entity } from "@/app/lib/types";
import { useParams } from "next/navigation";
import { useState, useEffect } from "react";

interface CoreEntityPageProps {
    categoryName: string;
    queryParams?: Record<string, string>;
    relatedMetaCategories?: string[];
    relatedCoreCategories?: string[];
    entityFields?: { label: string; value: keyof Entity; }[];
}

export function CoreEntityContainer({
                                        categoryName,
                                        relatedMetaCategories = [],
                                        relatedCoreCategories = [],
                                        entityFields = []
                                    }: CoreEntityPageProps) {
    console.log('CLIENT - CoreEntityContainer init with category:', categoryName);

    const params = useParams();
    const slug = params.slug as string;

    console.log('CLIENT - CoreEntityContainer slug from params:', slug);

    const [entityItem, setEntityItem] = useState<Entity | null>(null);
    const [isFetching, setIsFetching] = useState(true);
    const [error, setError] = useState<Error | null>(null);

    useEffect(() => {
        if (!slug) {
            console.log('CLIENT - No slug, skipping fetch');
            return;
        }

        console.log(`CLIENT - Starting fetch for ${categoryName}/${slug}`);

        fetchEntityBySlug<Entity>(categoryName, slug)
            .then(data => {
                console.log('CLIENT - Fetch completed, data received:', data ? 'YES' : 'NO');
                setEntityItem(data);
            })
            .catch(err => {
                console.error('CLIENT - Fetch error:', err);
                setError(err);
                setEntityItem(null);
            })
            .finally(() => {
                console.log('CLIENT - Fetch completed, setting isFetching to false');
                setIsFetching(false);
            });
    }, [slug, categoryName]);

    if (isFetching) {
        console.log('CLIENT - Still fetching, showing loading');
        return <main className="p-9 w-4/5"></main>;
    }

    if (error || !entityItem) {
        console.log('CLIENT - Error or no entity, showing error message');
        console.log('CLIENT - Error:', error);
        return <p>Entity not found.</p>;
    }

    console.log('CLIENT - Rendering entity UI');
    return (
        <CoreEntityUi
            entityItem={entityItem}
            categoryName={categoryName}
            entityFields={entityFields}
            relatedMetaCategories={relatedMetaCategories}
            relatedCoreCategories={relatedCoreCategories}
        />
    );
}