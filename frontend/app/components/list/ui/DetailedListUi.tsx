// app/components/list/ui/DetailedListUi.tsx
'use client'

import React from 'react';
import { DetailedListLayoutProps, useGridData } from '@/app/components/list';

export function DetailedListUi({
                                   entityItems = [],
                                   categoryNames = [],
                                   entityItem,
                                   relatedCategoryNames = [],
                                   renderEntityCard,
                                   status
                               }: DetailedListLayoutProps) {

    // Используем хук для подготовки данных сетки
    const { rows, hasContent } = useGridData(
        renderEntityCard,
        entityItems,
        categoryNames,
        entityItem,
        relatedCategoryNames,
        status
    );

    // Если нет содержимого, не рендерим ничего
    if (!hasContent) {
        return null;
    }

    return (
        <div className="space-y-6">
            {rows.map((rowItems, rowIndex) => (
                <div
                    key={`row-${rowIndex}`}
                    className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6"
                >
                    {rowItems}
                </div>
            ))}
        </div>
    );
}