// app/components/collection/containers/Pagination.tsx
'use client'

import React from 'react';
import {
    PaginationInfo,
    PaginationUI,
    usePagination
} from '@/app/components/collection';

interface PaginationContainerProps {
    pagination: PaginationInfo;
    baseQueryParams?: Record<string, string>;
}

export function PaginationContainer({
                                        pagination,
                                        baseQueryParams = {}
                                    }: PaginationContainerProps) {
    // Используем хук для логики пагинации
    const {
        page,
        pages,
        pageNumbers,
        totalItems,
        limit,
        createPageUrl,
        hasPagination
    } = usePagination({ pagination, baseQueryParams });

    // Если нет страниц для пагинации, не рендерим ничего
    if (!hasPagination) {
        return null;
    }

    return (
        <PaginationUI
            page={page}
            pages={pages}
            pageNumbers={pageNumbers}
            totalItems={totalItems}
            limit={limit}
            createPageUrl={createPageUrl}
        />
    );
}