import React from 'react';
import { Entity } from '@/app/lib/types';
import { formatFieldValue } from '@/app/lib/utils';

interface WebsiteProps {
    website?: string;
    className?: string;
}

export function EntityWebsite({
                                  website,
                                  className = "mb-3"
                              }: WebsiteProps) {
    if (!website) return null;

    return (
        <p className={className}>
            <span className="font-bold">Website: </span>
            <a
                href={website}
                target="_blank"
                rel="noopener noreferrer"
                className="text-blue-500 hover:underline"
            >
                {new URL(website).hostname}
            </a>
        </p>
    );
}

interface EntityField {
    label: string;
    value: string;
    formatter?: (value: any) => string | React.ReactNode;
}

interface EntityFieldsProps {
    entityItem: Entity;
    entityFields: EntityField[];
    className?: string;
    contentClassName?: string;
}

export function EntityFields({
                                 entityItem,
                                 entityFields,
                                 className = "mb-2",
                                 contentClassName = "mb-4"
                             }: EntityFieldsProps) {
    return (
        <>
            {entityItem.content && (
                <p className={contentClassName}>{entityItem.content}</p>
            )}

            {entityFields?.map(({ label, value, formatter }) => {
                const fieldValue = entityItem[value];

                if (fieldValue === undefined || fieldValue === null) return null;

                // Используем пользовательский форматтер если он есть, иначе стандартный
                const displayValue = formatter
                    ? formatter(fieldValue)
                    : formatFieldValue(fieldValue, value);

                return (
                    <p key={label} className={className}>
                        <strong>{label}: </strong>{displayValue}
                    </p>
                );
            })}

            {entityItem.website && (
                <EntityWebsite website={entityItem.website} />
            )}
        </>
    );
}