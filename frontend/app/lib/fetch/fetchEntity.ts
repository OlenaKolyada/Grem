// app/lib/fetch/fetchEntity.ts

import { baseFetch } from "./baseFetch";

export async function fetchEntity<T>(
    entityType: string,
    id: string,
    includeRelated: boolean = true
): Promise<T> {
    if (!id) {
        throw new Error("ID is required to fetch an entity");
    }

    const queryParams: Record<string, string> =
        includeRelated ? { include: "related" } : {};

    return baseFetch<T>(
        `${entityType}/${id}`,
        Object.keys(queryParams).length > 0
            ? queryParams : undefined
    );
}