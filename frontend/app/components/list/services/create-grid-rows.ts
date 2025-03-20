// app/components/list/services/create-grid-rows.ts
import { Entity } from "@/app/lib/types";
import {getCategoryName} from "@/app/components/list/services/get-category-name";

export function createGridRows(
    renderEntityCard: (item: Entity, categoryName: string, uniqueKey: string) => React.ReactNode,
    mainItems: Entity[],
    categoryNames: string[],
    relatedGroups: { categoryName: string; items: Entity[] }[],
    maxItemsPerRow: number = 3
): React.ReactNode[][] {
    const rows: React.ReactNode[][] = [];
    let currentRow: React.ReactNode[] = [];

    function addItemToRow(item: Entity, categoryName: string, keyPrefix: string, index: number) {
        const uniqueKey = `${keyPrefix}-${categoryName}-${item.id || index}`;
        currentRow.push(renderEntityCard(item, categoryName, uniqueKey));

        if (currentRow.length === maxItemsPerRow) {
            rows.push([...currentRow]);
            currentRow = [];
        }
    }

    if (mainItems.length > 0) {
        mainItems.forEach((item, index) => {
            const categoryName = getCategoryName(categoryNames, index);
            addItemToRow(item, categoryName, 'main', index);
        });
    }

    relatedGroups.forEach(group => {
        group.items.forEach((item, index) => {
            addItemToRow(item, group.categoryName, group.categoryName, index);
        });
    });

    if (currentRow.length > 0) {
        rows.push([...currentRow]);
    }

    return rows;
}
