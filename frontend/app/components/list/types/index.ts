// app/components/list/types/index.ts

import { Entity, StatusEnum } from '@/app/lib/types';
import React from 'react';

// Базовые интерфейсы
export interface BaseListProps {
    categoryNames: string[];
    label?: string;
}

export interface ListItemProps {
    entityItem: Entity;
    categoryName: string;
}

// Brief List типы
export interface BriefListProps extends BaseListProps {
    entityItems: Entity[];
    filterStatus?: boolean;
}

export interface BriefListLayoutProps extends BaseListProps {
    sortedList: Entity[];
}

// Detailed List типы
export interface DetailedListProps extends BaseListProps {
    entityItems?: Entity[];
    entityItem?: Entity;
    relatedCategoryNames?: string[];
    defaultStatus?: StatusEnum;
}

export interface DetailedListLayoutProps extends BaseListProps {
    entityItems?: Entity[];
    entityItem?: Entity;
    relatedCategoryNames?: string[];
    renderEntityCard: (
        item: Entity,
        categoryName: string,
        uniqueKey: string
    ) => React.ReactNode;
    status?: StatusEnum;
}

// Grid типы
export interface GridResult {
    rows: React.ReactNode[][];
    hasContent: boolean;
}

export interface RelatedGroup {
    categoryName: string;
    items: Entity[];
}
