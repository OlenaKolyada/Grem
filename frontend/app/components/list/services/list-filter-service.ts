// app/components/list/services/list-filter-service.ts
import { Entity, StatusEnum } from "@/app/lib/types";

export function filterByStatus(items: Entity[], status: StatusEnum): Entity[] {
    return items.filter(item => item.status === status);
}

export function filterByStatusOrEmpty(
    items: Entity[],
    status: StatusEnum,
    includeEmpty: boolean = false
): Entity[] {
    return items.filter(item =>
        item.status === status || (includeEmpty && !item.status)
    );
}

export function filterPublished(items: Entity[]): Entity[] {
    return filterByStatusOrEmpty(items, StatusEnum.Published, true);
}

export function applyStatusFilter(
    items: Entity[],
    filterStatus: boolean = true
): Entity[] {
    return filterStatus
        ? filterPublished(items)
        : items;
}