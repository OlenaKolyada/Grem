// app/lib/fetch/fetchLatest.ts
import { baseFetch } from "./baseFetch";
import { Entity } from "@/app/lib/types/base-entity";

export async function fetchLatest(
    categoryNames: string[]
): Promise<Record<string, Entity>> {
    const queryParams: Record<string, string> = {
        categories: categoryNames.join(',')
    };

    return baseFetch<Record<string, Entity>>(
        'latest',
        queryParams
    );
}