// app/components/list/containers/DetailedListContainer.tsx
'use client'

import React from 'react';
import {
    DetailedListItemUi,
    DetailedListUi,
    DetailedListProps,
    useListParams
} from '@/app/components/list';
import { Entity } from '@/app/lib/types';

export function DetailedListContainer({
                                          entityItems = [],
                                          categoryNames = [],
                                          entityItem,
                                          relatedCategoryNames = [],
                                          defaultStatus
                                      }: DetailedListProps) {

    const { status } = useListParams(defaultStatus);

    const renderEntityCard = (
        entityItem: Entity,
        categoryName: string,
        uniqueKey: string
    ) => (
        <DetailedListItemUi
            key={uniqueKey}
            entityItem={entityItem}
            categoryName={categoryName}
        />
    );

    return (
        <DetailedListUi
            entityItems={entityItems}
            categoryNames={categoryNames}
            entityItem={entityItem}
            relatedCategoryNames={relatedCategoryNames}
            renderEntityCard={renderEntityCard}
            status={status}
        />
    );
}