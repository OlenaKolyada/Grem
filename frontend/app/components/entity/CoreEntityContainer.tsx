// app/components/entity/CoreEntityContainer.tsx
'use client'

import { CoreEntityUi } from "@/app/components/entity";
import { useEntity } from "@/app/lib/hooks";
import { fetchBySlug } from "@/app/lib/fetch";
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
    const [entityId, setEntityId]
        = useState<string | null>(null);
    const [isFetching, setIsFetching]
        = useState(true);

    useEffect(() => {
        if (!slug) return;

        fetchBySlug(categoryName, slug)
            .then(id => setEntityId(id))
            .catch(() => setEntityId(null))
            .finally(() => setIsFetching(false));
    }, [slug, categoryName]);

    const { data: entityItem, loading, error }
        = useEntity<Entity>(
        categoryName,
        entityId || "",
        true
    );

    if (isFetching || loading) return <main className="p-9 w-4/5"></main>;
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