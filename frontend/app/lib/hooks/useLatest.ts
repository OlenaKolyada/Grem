// app/lib/hooks/useLatest.ts
"use client";

import { useState, useEffect } from "react";
import { Entity } from "@/app/lib/types/base-entity";
import { fetchLatest } from "@/app/lib/fetch/fetchLatest";

export function useLatest(categoryNames: string[]) {
    const [data, setData] = useState<Record<string, Entity> | null>(null);
    const [loading, setLoading] = useState<boolean>(true);
    const [error, setError] = useState<string | null>(null);

    useEffect(() => {
        async function loadLatestItems() {
            if (!categoryNames || categoryNames.length === 0) {
                setData(null);
                setLoading(false);
                return;
            }

            setLoading(true);
            setError(null);

            try {
                const result = await fetchLatest(categoryNames);
                setData(result);
            } catch (err) {
                setError((err as Error).message);
            } finally {
                setLoading(false);
            }
        }

        loadLatestItems();
    }, [categoryNames]);

    return { data, loading, error };
}