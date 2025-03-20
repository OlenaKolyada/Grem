// app/lib/hooks/useMetaCollection.ts
"use client";

import { useState, useEffect } from "react";
import { fetchMetaCollection } from "@/app/lib/fetch";

export function useMetaCollection<T>(
    entityType: string
) {
    const [data, setData] =
        useState<T[]>([]);
    const [loading, setLoading] =
        useState<boolean>(true);
    const [error, setError] =
        useState<string | null>(null);

    useEffect(() => {
        async function loadCollection() {
            setLoading(true);
            setError(null);
            try {
                const result = await fetchMetaCollection<T>(entityType);
                setData(result);
            } catch (err) {
                setError((err as Error).message);
            } finally {
                setLoading(false);
            }
        }

        loadCollection();
    }, [entityType]);

    return { data, loading, error };
}
