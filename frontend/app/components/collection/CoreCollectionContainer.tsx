// app/components/collection/containers/CoreCollectionContainer.tsx
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
import {PaginationContainer} from "@/app/components/collection";

interface CoreCollectionPageProps {
    categoryName: string;
    defaultStatus?: StatusEnum;
}

export function CoreCollectionContainer({
                                            categoryName,
                                            defaultStatus = StatusEnum.Published
                                        }: CoreCollectionPageProps) {
    // Используем хук для получения параметров списка
    const { status, page, limit, getBaseQueryParams } = useListParams(defaultStatus);

    // Получаем данные коллекции
    const { data, pagination, loading, error } = useCoreCollection<Entity>(
        categoryName,
        page,
        limit,
        status
    );

    // Обработка состояний
    if (error) return <ListError error={error} />;
    if (!loading && !data.length) return <ListEmpty />;
    if (loading) return <ListLoading />;

    return (
        <div className="my-9">
            <DetailedListContainer
                entityItems={data}
                categoryNames={[categoryName]}
            />

            {pagination && (
                <PaginationContainer
                    pagination={pagination}
                    baseQueryParams={getBaseQueryParams()}
                />
            )}
        </div>
    );
}