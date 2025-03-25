// app/lib/fetch/fetchMetaCollection.ts
import { baseFetch } from "./baseFetch";

export async function fetchMetaCollection<T>(
    entityType: string
): Promise<T[]> {
    return baseFetch<T[]>(`${entityType}`);
}



