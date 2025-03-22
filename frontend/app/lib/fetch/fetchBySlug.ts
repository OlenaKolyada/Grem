import { API_URL } from '@/app/lib/config';

export async function fetchEntityBySlug(entityType: string, slug: string) {
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
        return data; // Возвращаем полностью полученный объект, а не только id
    } catch (error) {
        console.error("Error fetching entity by slug:", error);
        return null;
    }
}