'use client'

import {
    DetailedListContainer,
    useListParams,
    ListError,
    ListLoading,
    ListEmpty
} from "@/app/components/list";
import { useCoreCollection } from "@/app/lib/hooks";
import { Entity, StatusEnum } from "@/app/lib/types";
import { PaginationContainer } from "@/app/components/collection";
import { useSearchParams } from 'next/navigation';
import { SortButtons } from '@/app/ui/elements/SortButtons';

interface CoreCollectionPageProps {
    categoryName: string;
    defaultStatus?: StatusEnum;
}

export function CoreCollectionContainer({
                                            categoryName,
                                            defaultStatus = StatusEnum.Published
                                        }: CoreCollectionPageProps) {
    const { status, page, limit, getBaseQueryParams } = useListParams(defaultStatus);
    const searchParams = useSearchParams();
    const sort = searchParams?.get('sort') || 'updatedAt:desc';

    const { data, pagination, loading, error } = useCoreCollection<Entity>(
        categoryName,
        page,
        limit,
        status,
        sort
    );

    const baseQueryParams = {
        ...getBaseQueryParams(),
        sort,
    };

    if (loading) return <ListLoading />;
    if (error) return <ListError error={error} />;
    if (!data || data.length === 0) return <ListEmpty />;

    return (
        <div className="my-9">
            <SortButtons />
            <DetailedListContainer
                entityItems={data}
                categoryNames={[categoryName]}
            />
            {pagination && (
                <PaginationContainer
                    pagination={pagination}
                    baseQueryParams={baseQueryParams}
                />
            )}
        </div>
    );
}