// app/components/list/services/list-sort-service.ts

export function sortListByTitle<T extends {
    title?: string;
}>(list: Array<T>): Array<T> {
    const getTitle = (item: T) => item.title ?? '';
    return [...list].sort((a, b) => getTitle(a).localeCompare(getTitle(b)));
}

export function sortListByDate<T extends {
    updatedAt?: string | Date | null;
}>(list: Array<T>): Array<T> {
    return [...list].sort((a, b) => {
        const dateA = a.updatedAt ? new Date(a.updatedAt).getTime() : 0;
        const dateB = b.updatedAt ? new Date(b.updatedAt).getTime() : 0;
        return dateB - dateA;
    });
}

export type SortStrategy = 'title' | 'date' | 'none';

export function sortList<T extends {
    title?: string;
    updatedAt?: string | Date | null;
}>(list: Array<T>, strategy: SortStrategy = 'title'): Array<T> {
    switch (strategy) {
        case 'title':
            return sortListByTitle(list);
        case 'date':
            return sortListByDate(list);
        case 'none':
        default:
            return list;
    }
}