// app/lib/fetch/fetchUser.ts

import { baseFetch } from "./baseFetch";

export async function fetchUser<T>(id: string): Promise<T> {
    if (!id) {
        throw new Error("User ID is required to fetch profile data");
    }

    return baseFetch<T>(`user/${id}`);
}
