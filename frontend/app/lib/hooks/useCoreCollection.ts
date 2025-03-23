"use client";

import { useState, useEffect } from "react";
import { fetchCoreCollection } from "@/app/lib/fetch";

export function useCoreCollection<T>(
    entityType: string,
    page: number = 1,
    limit: number = 9,
    status?: string,
    sort?: string
) {
    const [data, setData] = useState<T[]>([]);
    const [pagination, setPagination] = useState<{
        totalItems: number;
        page: number;
        limit: number;
        pages: number
    } | null>(null);
    const [loading, setLoading] = useState<boolean>(true);
    const [error, setError] = useState<string | null>(null);

    useEffect(() => {
        async function loadCollection() {
            setLoading(true);
            setError(null);
            try {

                const result = await fetchCoreCollection<T>(
                    entityType,
                    page,
                    limit,
                    status,
                    sort);

                if (Array.isArray(result)) {
                    setData(result);
                    setPagination({
                        totalItems: result.length,
                        page: page,
                        limit: limit,
                        pages: Math.ceil(result.length / limit)
                    });
                } else if (result && typeof result === 'object' && 'items' in result) {
                    setData(result.items);
                    setPagination(result.pagination);
                } else {
                    console.error('Unexpected API response format:', result);
                    setError('Unexpected API response format');
                    setData([]);
                }
            } catch (err) {
                console.error('Error in useCoreCollection:', err);
                setError((err as Error).message);
                setData([]);
            } finally {
                setLoading(false);
            }
        }

        loadCollection();
    }, [entityType, page, limit, status, sort]);

    return { data, pagination, loading, error };
}