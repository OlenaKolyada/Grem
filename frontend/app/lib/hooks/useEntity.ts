// app/lib/hooks/useEntity.ts
"use client";

import { useState, useEffect } from "react";
import { fetchEntity } from "@/app/lib/fetch";

export function useEntity<T>(
    entityType: string,
    id: string,
    includeRelated: boolean = true
) {
    const [data, setData]
        = useState<T | null>(null);
    const [loading, setLoading]
        = useState<boolean>(true);
    const [error, setError]
        = useState<string | null>(null);

    useEffect(() => {
        async function loadEntity() {
            if (!id) {
                return;
            }

            setLoading(true);
            setError(null);
            try {
                const result = await fetchEntity<T>(
                    entityType, id, includeRelated);
                setData(result);
            } catch (err) {
                setError((err as Error).message);
            } finally {
                setLoading(false);
            }
        }

        loadEntity();
    }, [entityType, id, includeRelated]);

    return { data, loading, error };
}