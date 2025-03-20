// app/components/list/containers/BriefListContainer.tsx
'use client'

import {
    BriefListUi,
    BriefListProps,
    sortListByTitle,
    applyStatusFilter
} from '@/app/components/list';

export function BriefListContainer({
                                       entityItems = [],
                                       categoryNames = [],
                                       label = '',
                                       filterStatus = true
                                   }: BriefListProps) {

    // Применяем фильтрацию по статусу
    const filteredItems = applyStatusFilter(entityItems, filterStatus);

    // Сортируем элементы по заголовку
    const sortedList = sortListByTitle(filteredItems);

    // Если список пуст, не рендерим компонент
    if (sortedList.length === 0) {
        return null;
    }

    // Рендерим UI-компонент с подготовленными данными
    return (
        <BriefListUi
            sortedList={sortedList}
            categoryNames={categoryNames}
            label={label}
        />
    );
}