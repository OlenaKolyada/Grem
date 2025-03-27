'use client'

import React from 'react';
import { Entity } from '@/app/lib/types';
import { capitalizeFirstLetter } from "@/app/lib/utils";
import * as em from "@/app/ui/elements/EntityMetadata";
import {
    BriefListContainer,
    DetailedListContainer
} from "@/app/components/list";
import { EntityImage, EntityFields } from "@/app/ui/elements";

// Функция для получения мета-сущностей
function getMetaEntities(entity: Entity, categoryName: string): Entity[] {
    if (!entity || !categoryName) return [];
    const value = (entity as Record<string, unknown>)[categoryName];
    if (Array.isArray(value)) {
        return value;
    }
    return [];
}

interface CoreEntityCardProps {
    entityItem: Entity;
    categoryName: string;
    entityFields?: { label: string; value: keyof Entity; }[];

    relatedCoreCategories?: string[];
    relatedMetaCategories?: string[];
}

export function CoreEntityUi({
                                 entityItem,
                                 categoryName,
                                 entityFields = [],
                                 relatedCoreCategories = [],
                                 relatedMetaCategories = []
                             }: CoreEntityCardProps) {

    return (
        <main className="p-9 w-11/12">
            <div className="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
                <div className="mx-9 flex flex-col md:flex-1">
                    <div className="flex mb-1">
                        <em.EntityCategory category={categoryName}/>
                    </div>

                    <em.EntityTitle title={entityItem.title}/>

                    <div className="flex mb-1">
                        <em.EntityStatus status={entityItem.status}/>
                        <em.EntityDate date={entityItem.updatedAt}/>
                        {entityItem.author && <em.EntityAuthor author={entityItem.author}/>}
                    </div>

                    <div className="flex flex-col md:flex-row my-9">
                        <div className="w-2/5 mr-6">
                            <EntityImage
                                id={entityItem.id}
                                categoryName={categoryName}
                                title={entityItem.title}
                                coverUrl={entityItem?.coverUrl}
                                width="w-full md:w-[400px] 2xl:w-[500px]"
                                height="h-[350px]"
                            />
                        </div>

                        <div className="flex flex-col w-3/6">
                            <EntityFields
                                entityItem={entityItem}
                                entityFields={entityFields}
                            />

                            {relatedMetaCategories.map(name => (
                                <BriefListContainer
                                    key={name}
                                    entityItems={getMetaEntities(entityItem, name)}
                                    categoryNames={[name]}
                                    label={capitalizeFirstLetter(name) + 's'}
                                />
                            ))}
                        </div>
                    </div>
                </div>

                <div className="ml-9 mb-9">
                    <DetailedListContainer
                        entityItem={entityItem}
                        categoryNames={[]}
                        relatedCategoryNames={relatedCoreCategories || []}
                    />
                </div>
            </div>
        </main>
    );
}