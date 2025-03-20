// app/lib/fetch/fetchBySlug.ts

import { API_URL } from '@/app/lib/config';

export async function fetchBySlug(entityType: string, slug: string): Promise<string | null> {
    if (!slug) {
        throw new Error("Slug is required");
    }

    try {
        const response = await fetch(`${API_URL}/api/${entityType}/resolve/${slug}`);

        if (response.status === 404) {
            return null;
        }

        if (!response.ok) {
            throw new Error(`HTTP error ${response.status}`);
        }

        const data = await response.json();
        return data.id;
    } catch (error) {
        console.error("Error fetching ID by slug:", error);
        return null;
    }
}

export async function fetchEntityBySlug(entityType: string, slug: string) {
    const id = await fetchBySlug(entityType, slug);

    if (!id) {
        return null;
    }

    try {
        const response = await fetch(`${API_URL}/api/${entityType}/${id}`);

        if (!response.ok) {
            throw new Error(`HTTP error ${response.status}`);
        }

        return await response.json();
    } catch (error) {
        console.error("Error fetching entity by ID:", error);
        return null;
    }
}