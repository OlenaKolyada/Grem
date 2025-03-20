// app/components/list/ui/BriefListUi.tsx
'use client'

import {
    BriefListItemUi,
    BriefListLayoutProps,
    getCategoryName
} from '@/app/components/list';

export function BriefListUi({
                                sortedList,
                                categoryNames,
                                label = ''
                            }: BriefListLayoutProps) {
    return (
        <div className="mb-2 flex items-center gap-2">
            {label && <strong>{label}:</strong>}
            <div className="flex flex-wrap gap-1">
                {sortedList.map((entityItem, index) => (
                    <BriefListItemUi
                        key={entityItem.id}
                        entityItem={{
                            id: Number(entityItem.id || 0),
                            title: entityItem.title || '',
                            slug: entityItem.slug || ''
                        }}
                        categoryName={getCategoryName(categoryNames, index)}
                    />
                ))}
            </div>
        </div>
    );
}