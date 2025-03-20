// app/components/list/services/get-related-groups.ts
import {Entity, StatusEnum} from "@/app/lib/types";
import {getRelatedEntities, RelatedGroup} from "@/app/components";

export function getRelatedGroups(
    entityItem: Entity | undefined,
    relatedCategoryNames: string[],
    status: StatusEnum
): RelatedGroup[] {
    if (!entityItem || relatedCategoryNames.length === 0) {
        return [];
    }

    return relatedCategoryNames
        .map(categoryName => {
            const allItems = getRelatedEntities(entityItem, categoryName);
            const filteredItems = allItems.filter(item =>
                item.status === status || !item.status)
                .map(item => ({
                    ...item,
                    _categoryName: categoryName
                }));

            return { categoryName, items: filteredItems };
        })
        .filter(group => group.items.length > 0);
}