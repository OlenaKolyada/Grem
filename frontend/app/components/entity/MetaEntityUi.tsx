// app/components/entity/MetaEntityUi.tsx
'use client'

import { Entity } from '@/app/lib/types';
import {
    EntityCollectionLink,
    EntityFields,
    EntityTitle
} from "@/app/ui/elements";

interface MetaEntityCardProps {
    entityItem: Entity;
    categoryName: string;
    entityFields?: { label: string; value: keyof Entity; }[];
}

export function MetaEntityUi({
                                   entityItem,
                                   categoryName,
                                   entityFields = []
}: MetaEntityCardProps) {
    return (
        <div className="mb-2 flex flex-col gap-2 w-4/5">

            <div className="flex items-center">
                <EntityTitle title={entityItem?.title}/>
                <EntityCollectionLink categoryName={categoryName}/>
            </div>

            <div>
                <EntityFields
                    entityItem={entityItem}
                    entityFields={entityFields}
                />
            </div>

        </div>
    );
}