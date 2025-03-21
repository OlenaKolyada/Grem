import React from 'react';
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

export interface EntityField<T extends object> {
    label: string;
    value: keyof T;
    formatter?: (value: unknown) => string | React.ReactNode;
}

export interface EntityFieldsProps<T extends object> {
    entityItem: T;
    entityFields: EntityField<T>[];
    className?: string;
    contentClassName?: string;
}

export function EntityFields<T extends object>({
                                                   entityItem,
                                                   entityFields,
                                                   className = "mb-2",
                                                   contentClassName = "mb-4"
                                               }: EntityFieldsProps<T>) {
    const content = (entityItem as Record<string, unknown>)["content"];
    const website = (entityItem as Record<string, unknown>)["website"];

    return (
        <>
            {typeof content === 'string' && (
                <p className={contentClassName}>{content}</p>
            )}

            {entityFields.map(({ label, value, formatter }) => {
                const rawValue = entityItem[value];

                if (rawValue === undefined || rawValue === null) return null;

                const displayValue = formatter
                    ? formatter(rawValue)
                    : formatFieldValue(rawValue, String(value));

                return (
                    <p key={label} className={className}>
                        <strong>{label}: </strong>{displayValue}
                    </p>
                );
            })}

            {typeof website === 'string' && (
                <EntityWebsite website={website} />
            )}
        </>
    );
}
