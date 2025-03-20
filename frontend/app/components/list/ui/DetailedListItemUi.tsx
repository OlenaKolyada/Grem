'use client'

import React from 'react';
import Link from 'next/link';
import * as em from '@/app/ui/elements/EntityMetadata';
import { ListItemProps } from '@/app/components/list';
import { EntityImage, ReadMore } from "@/app/ui/elements";

export function DetailedListItemUi({
                                       entityItem,
                                       categoryName
                                   }: ListItemProps) {
    return (
        <div
            className="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300"
        >
            <div className="flex mb-1">
                <em.EntityCategory category={entityItem._categoryName || categoryName} />
            </div>

            <div className="flex mb-1">
                <em.EntityStatus status={entityItem.status} />
                <em.EntityDate date={entityItem.updatedAt} />
                {entityItem.author && <em.EntityAuthor author={entityItem.author} />}
            </div>

            <Link href={`/${entityItem._categoryName || categoryName}/${entityItem.slug || entityItem.id}`} className="block">
                <em.EntityTitle title={entityItem.title} />
                <EntityImage
                    id={entityItem.id}
                    categoryName={entityItem._categoryName || categoryName}
                    title={entityItem.title}
                    coverUrl={entityItem?.coverUrl}
                />
            </Link>

            <em.EntitySummary summary={entityItem.summary || ''}/>
            <ReadMore
                id={entityItem.id}
                slug={entityItem.slug}
                categoryName={entityItem._categoryName || categoryName}
            />
        </div>
    );
}