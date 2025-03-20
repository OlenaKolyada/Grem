// app/lib/hooks/useUser.ts
"use client";

import { useState, useEffect } from "react";
import { fetchUser } from "@/app/lib/fetch";

export function useUser<T>(id: string) {
    const [data, setData]
        = useState<T | null>(null);
    const [loading, setLoading]
        = useState<boolean>(true);
    const [error, setError]
        = useState<string | null>(null);

    useEffect(() => {
        async function loadUser() {
            if (!id) {
                return;
            }

            setLoading(true);
            setError(null);
            try {
                const result = await fetchUser<T>(id);
                setData(result);
            } catch (err) {
                setError((err as Error).message);
            } finally {
                setLoading(false);
            }
        }

        loadUser();
    }, [id]);

    return { data, loading, error };
}
