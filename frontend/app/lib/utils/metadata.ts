// app/lib/utils/metadata.ts

import type { Metadata } from 'next';
import { capitalizeFirstLetter } from "@/app/lib/utils";

/**
 * Генерирует заголовок для страниц сайта
 * @param params - параметры для генерации заголовка
 * @returns строка заголовка
 */
export function generatePageTitle(params: {
    categoryName?: string;
    itemTitle?: string;
}): string {
    const { categoryName, itemTitle } = params;
    const siteName = 'Grem';

    if (itemTitle && categoryName) {
        return `${itemTitle} | ${capitalizeFirstLetter(categoryName)} | ${siteName}`;
    } else if (categoryName) {
        return `${capitalizeFirstLetter(categoryName)} Collection | ${siteName}`;
    }

    return `${siteName} | Video game's news and reviews`;
}

/**
 * Генерирует метаданные для страниц элементов
 * @param params - параметры для генерации метаданных
 * @returns объект метаданных для Next.js
 */
export function generateItemMetadata(params: {
    categoryName: string;
    itemTitle: string;
}): Metadata {
    const { categoryName, itemTitle } = params;

    return {
        title: generatePageTitle({ categoryName, itemTitle }),
        description: `${itemTitle} - ${categoryName} details on Grem`
    };
}

/**
 * Генерирует метаданные для страниц коллекций
 * @param categoryName - название категории
 * @returns объект метаданных для Next.js
 */
export function generateCollectionMetadata(categoryName: string): Metadata {
    return {
        title: generatePageTitle({ categoryName }),
        description: `Browse our collection of ${categoryName} on Grem`
    };
}