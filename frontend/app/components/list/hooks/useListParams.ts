'use client';

import { useSearchParams } from "next/navigation";
import { StatusEnum } from "@/app/lib/types";

/**
 * Хук для получения параметров списка из URL
 */
export function useListParams(defaultStatus = StatusEnum.Published) {
    const searchParams = useSearchParams();

    const status = (searchParams.get('status') as StatusEnum) || defaultStatus;
    const page = Number(searchParams.get('page') || 1);
    const limit = Number(searchParams.get('limit') || 9);

    const getBaseQueryParams = (overrides: Record<string, string> = {}) => {
        const params: Record<string, string> = {};

        if (status !== StatusEnum.Published) {
            params.status = status;
        }

        return { ...params, ...overrides };
    };

    return {
        status,
        page,
        limit,
        getBaseQueryParams,
    };
}
