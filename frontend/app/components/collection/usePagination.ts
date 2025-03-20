// app/components/collection/hooks/usePagination.ts
'use client'

import { usePathname, useSearchParams } from 'next/navigation';
import { PaginationInfo } from './pagination-info';

interface UsePaginationProps {
    pagination: PaginationInfo;
    baseQueryParams?: Record<string, string>;
    maxPages?: number;
}

export function usePagination({
                                  pagination,
                                  baseQueryParams = {},
                                  maxPages = 10
                              }: UsePaginationProps) {
    const pathname = usePathname();
    const searchParams = useSearchParams();
    const { page, pages, totalItems, limit } = pagination;

    // Создание URL для перехода на страницу
    const createPageUrl = (newPage: number) => {
        const params = new URLSearchParams(searchParams.toString());

        Object.entries(baseQueryParams).forEach(([key, value]) => {
            if (value) {
                params.set(key, value);
            }
        });

        params.set('page', newPage.toString());
        return `${pathname}?${params.toString()}`;
    };

    // Определяем диапазон номеров страниц для отображения
    let startPage = Math.max(1, page - Math.floor(maxPages / 2));
    const endPage = Math.min(pages, startPage + maxPages - 1);

    if (endPage - startPage + 1 < maxPages) {
        startPage = Math.max(1, endPage - maxPages + 1);
    }

    // Создаем массив номеров страниц
    const pageNumbers = [];
    for (let i = startPage; i <= endPage; i++) {
        pageNumbers.push(i);
    }

    return {
        page,
        pages,
        pageNumbers,
        totalItems,
        limit,
        createPageUrl,
        hasPagination: pages > 1
    };
}