// app/lib/hooks/useCoreCollection.ts
"use client";

import { useState, useEffect } from "react";
import { fetchCoreCollection } from "@/app/lib/fetch";

export function useCoreCollection<T>(
    entityType: string,
    page: number = 1,
    limit: number = 9,
    status?: string
) {
    const [data, setData] =
        useState<T[]>([]);
    const [pagination, setPagination] =
        useState<{
        totalItems: number;
        page: number; limit:
                number;
        pages: number
    } | null>(null);
    const [loading, setLoading] =
        useState<boolean>(true);
    const [error, setError] =
        useState<string | null>(null);

    useEffect(() => {
        async function loadCollection() {
            setLoading(true);
            setError(null);
            try {
                const result = await fetchCoreCollection<T>(
                    entityType,
                    page,
                    limit,
                    status);
                setData(result.items);
                setPagination(result.pagination);
            } catch (err) {
                setError((err as Error).message);
            } finally {
                setLoading(false);
            }
        }

        loadCollection();
    }, [entityType, page, limit, status]);

    return { data, pagination, loading, error };
}
