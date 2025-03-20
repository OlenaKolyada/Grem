// app/components/collection/containers/MetaCollectionContainer.tsx
"use client";

import { BriefListContainer } from "@/app/components/list";
import { useMetaCollection } from "@/app/lib/hooks";
import { Entity } from "@/app/lib/types";

interface MetaCollectionPageProps {
    categoryName: string;
}

export function MetaCollectionContainer({ categoryName }: MetaCollectionPageProps) {

    const { data, loading, error } = useMetaCollection<Entity>(categoryName);

    if (loading) return <main className="p-9 w-4/5"></main>;
    if (error) return <p>Error: {error}</p>;
    if (!data.length) return <p>No data available.</p>;

    return (
        <div className="p-9">
            <BriefListContainer
                entityItems={data}
                categoryNames={[categoryName]}
            />
        </div>
    );
}