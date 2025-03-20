// app/components/list/services/prepare-grid-data.ts
import {Entity, StatusEnum} from "@/app/lib/types";
import {createGridRows, filterByStatus, GridResult} from "@/app/components";
import {getRelatedGroups} from "@/app/components/list/services/get-related-groups";

export function prepareGridData(
    renderEntityCard: (item: Entity, categoryName: string, uniqueKey: string) => React.ReactNode,
    entityItems: Entity[] = [],
    categoryNames: string[] = [],
    entityItem?: Entity,
    relatedCategoryNames: string[] = [],
    status: StatusEnum = StatusEnum.Published
): GridResult {
    const mainItems = filterByStatus(entityItems, status);
    const relatedGroups = getRelatedGroups(entityItem, relatedCategoryNames, status);

    if (mainItems.length === 0 && relatedGroups.length === 0) {
        return { rows: [], hasContent: false };
    }

    const rows = createGridRows(renderEntityCard, mainItems, categoryNames, relatedGroups);
    return { rows, hasContent: true };
}