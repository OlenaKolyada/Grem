// app/components/list/services/get-related-entities.ts
import { Entity } from "@/app/lib/types";

export function getRelatedEntities(
    entity: Entity | undefined,
    relatedCategoryName: string
): Entity[] {
    if (!entity || !relatedCategoryName) return [];

    const value = (entity as Record<string, any>)[relatedCategoryName];
    if (Array.isArray(value)) {
        return value;
    }

    if (entity.relatedItems && relatedCategoryName in entity.relatedItems) {
        return entity.relatedItems[relatedCategoryName] || [];
    }

    return [];
}
