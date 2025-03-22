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
    const params = useParams();
    const slug = params.slug as string;
    const [entityItem, setEntityItem] = useState<Entity | null>(null);
    const [isFetching, setIsFetching] = useState(true);
    const [error, setError] = useState<Error | null>(null);

    useEffect(() => {
        if (!slug) return;

        fetchEntityBySlug(categoryName, slug)
            .then(data => setEntityItem(data))
            .catch(err => {
                setError(err);
                setEntityItem(null);
            })
            .finally(() => setIsFetching(false));
    }, [slug, categoryName]);

    if (isFetching) return <main className="p-9 w-4/5"></main>;
    if (error || !entityItem) return <p>Entity not found.</p>;

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