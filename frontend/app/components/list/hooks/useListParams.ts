// app/components/list/hooks/useListParams.ts
'use client';

import { useSearchParams } from "next/navigation";
import { StatusEnum } from "@/app/lib/types";

/**
 * Хук для получения параметров списка из URL
 */
export function useListParams(defaultStatus = StatusEnum.Published) {
    const searchParams = useSearchParams();

    // Получаем параметры из URL или используем значения по умолчанию
    const status = (searchParams.get('status') as StatusEnum) || defaultStatus;
    const page = Number(searchParams.get('page') || 1);
    const limit = Number(searchParams.get('limit') || 9);

    return {
        status,
        page,
        limit,

        // Формирует базовые параметры запроса
        getBaseQueryParams: (overrides = {}) => {
            const params: Record<string, string> = {};

            // Добавляем статус только если он отличается от Published
            if (status !== StatusEnum.Published) {
                params.status = status;
            }

            // Объединяем с переопределениями
            return { ...params, ...overrides };
        }
    };
}