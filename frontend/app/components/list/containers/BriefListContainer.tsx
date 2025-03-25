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


    const filteredItems = applyStatusFilter(entityItems, filterStatus);
    const sortedList = sortListByTitle(filteredItems);

    if (sortedList.length === 0) {
        return null;
    }

    return (
        <BriefListUi
            sortedList={sortedList}
            categoryNames={categoryNames}
            label={label}
        />
    );
}