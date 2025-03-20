// app/components/list/hooks/useGridData.ts

import { useMemo } from 'react';
import { Entity, StatusEnum } from "@/app/lib/types";
import { prepareGridData } from '../services';
import { GridResult } from '../types';

/**
 * Хук для подготовки данных сетки
 */
export function useGridData(
    renderEntityCard: (item: Entity, categoryName: string, uniqueKey: string) => React.ReactNode,
    entityItems: Entity[] = [],
    categoryNames: string[] = [],
    entityItem?: Entity,
    relatedCategoryNames: string[] = [],
    status: StatusEnum = StatusEnum.Published
): GridResult {
    // Мемоизируем результат для предотвращения лишних вычислений
    return useMemo(() => {
        return prepareGridData(
            renderEntityCard,
            entityItems,
            categoryNames,
            entityItem,
            relatedCategoryNames,
            status
        );
    }, [
        renderEntityCard,
        entityItems,
        categoryNames,
        entityItem,
        relatedCategoryNames,
        status
    ]);
}