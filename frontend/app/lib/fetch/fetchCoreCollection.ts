// app/lib/fetch/fetchCoreCollection.ts

import { baseFetch } from "./baseFetch";

export async function fetchCoreCollection<T>(
    entityType: string,
    page: number = 1,
    limit: number = 9,
    status?: string
): Promise<{ items: T[]; pagination: {
    totalItems: number;
    page: number;
    limit: number;
    pages: number
} }> {
    const queryParams: Record<string, string> = {
        page: page.toString(),
        limit: limit.toString(),
    };

    if (status) {
        queryParams.status = status;
    }

    return baseFetch<{ items: T[]; pagination: {
        totalItems: number;
        page: number;
        limit: number;
        pages: number
    } }>(
        `${entityType}`,
        queryParams
    );
}
