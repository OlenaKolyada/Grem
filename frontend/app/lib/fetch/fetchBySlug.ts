// app/lib/fetch/fetchBySlug.ts
import { baseFetch } from '@/app/lib/fetch/baseFetch';
import { API_URL } from '@/app/lib/config';

export async function fetchEntityBySlug<T>(
    entityType: string,
    slug: string
): Promise<T | null> {
    if (!slug) {
        console.error("Slug is required");
        throw new Error("Slug is required");
    }

    console.log(`Fetching ${entityType} with slug: ${slug}`);

    try {
        // Пробуем использовать baseFetch
        try {
            console.log(`Using baseFetch for ${entityType}/resolve/${slug}`);
            const data = await baseFetch<T>(`${entityType}/resolve/${slug}`);
            console.log(`baseFetch success, got data:`, data);
            return data;
        } catch (baseFetchError) {
            console.warn(`baseFetch failed:`, baseFetchError);

            // Если baseFetch не сработал, пробуем прямой fetch как было раньше
            console.log(`Falling back to direct fetch at ${API_URL}/api/${entityType}/resolve/${slug}`);
            const response = await fetch(`${API_URL}/api/${entityType}/resolve/${slug}`);

            if (response.status === 404) {
                console.log(`Entity not found: ${entityType}/${slug} (404)`);
                return null;
            }

            if (!response.ok) {
                throw new Error(`HTTP error ${response.status}`);
            }

            const data = await response.json();
            console.log(`Direct fetch success, got data:`, data);
            return data as T;
        }
    } catch (error) {
        console.error(`Error fetching entity ${entityType}/${slug}:`, error);
        return null;
    }
}