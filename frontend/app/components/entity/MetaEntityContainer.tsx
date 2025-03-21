'use client';

import { DetailedListContainer } from '@/app/components/list';
import { MetaEntityUi } from "@/app/components/entity";
import { useEntity } from "@/app/lib/hooks";
import { fetchBySlug } from "@/app/lib/fetch";
import { Entity } from "@/app/lib/types";
import { useParams } from "next/navigation";
import { useState, useEffect } from "react";

interface MetaEntityPageProps {
    categoryName: string;
    queryParams?: Record<string, string>;
    entityFields?: { label: string; value: keyof Entity; }[];
    relatedCategoryNames: string[];
}

export function MetaEntityContainer({
                                        categoryName,
                                        relatedCategoryNames,
                                        entityFields,
                                    }: MetaEntityPageProps) {
    const params = useParams();
    const slug = params.slug as string;
    const [entityId, setEntityId] = useState<string | null>(null);
    const [isFetching, setIsFetching] = useState(true);

    useEffect(() => {
        if (!slug) return;

        fetchBySlug(categoryName, slug)
            .then(id => setEntityId(id))
            .catch(() => setEntityId(null))
            .finally(() => setIsFetching(false));
    }, [slug, categoryName]);

    const { data: entityItem, loading, error } = useEntity<Entity>(
        categoryName,
        entityId || "",
        true
    );

    if (isFetching || loading) return <main className="p-9 w-4/5"></main>;
    if (error || !entityItem) return <p>Entity not found.</p>;

    const relatedEntities = relatedCategoryNames.flatMap(category => {
        const items = (entityItem as Record<string, unknown>)[category];
        return Array.isArray(items) ? items.map(item => ({
            ...item,
            _categoryName: category
        })) : [];
    });

    return (
        <main className="p-9 w-4/5">
            <MetaEntityUi
                entityItem={entityItem}
                categoryName={categoryName}
                entityFields={entityFields}
            />
            {/* Передаём связанные сущности как `entityItems` */}
            <DetailedListContainer
                entityItems={relatedEntities}
                categoryNames={relatedCategoryNames}
                entityItem={entityItem}
            />
        </main>
    );
}