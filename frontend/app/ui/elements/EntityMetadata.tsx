// app/ui/elements/EntityMetadata.tsx

import React from 'react';
import Link from "next/link";
import { User, StatusEnum } from '@/app/lib/types';
import { capitalizeFirstLetter } from '@/app/lib/utils';

interface EntityMetadataProps {
    className?: string;
}

export function EntityTitle({
                                       title,
                                       className = "font-semibold text-gray-900 mr-3 mb-2 text-3xl"
                                   }: EntityMetadataProps & { title?: string }) {
    if (!title) return null;

    return (
        <h1 className={className}>
            {title}
        </h1>
    );
}

export function EntityCategory({
                                          category,
                                          className = "text-xs text-gray-400 italic mb-1"
                                      }: EntityMetadataProps & { category?: string }) {
    if (!category) return null;

    return (
        <p className={className}>
            <Link href={`/${category}?status=Published`}>
                {capitalizeFirstLetter(category)}
            </Link>
        </p>
    );
}

export function EntityAuthor({
                                        author,
                                        className = "text-xs text-gray-400 italic mb-1 pr-2"
                                    }: EntityMetadataProps & { author?: User }) {
    if (!author) return null;

    return (
        <p className={className}>
            By {author.nickname}
        </p>
    );
}

export function EntityDate({
                                      date,
                                      format = 'en-GB',
                                      className = "text-xs text-gray-400 italic mb-1 pr-2"
                                  }: EntityMetadataProps & { date?: Date, format?: string }) {
    if (!date) return null;

    return (
        <p className={className}>
            {new Date(date).toLocaleDateString(format)}
        </p>
    );
}

export function EntityStatus({
                                        status,
                                        className = "text-xs text-gray-400 italic mb-1 pr-2"
                                    }: EntityMetadataProps & { status?: StatusEnum }) {
    if (!status) return null;

    return (
        <p className={className}>
            {status}
        </p>
    );
}

export function EntitySummary({
                                         summary,
                                         className = "text-gray-700 mb-2 pt-3"
                                     }: EntityMetadataProps & { summary?: string }) {
    if (!summary) return null;

    return (
        <p className={className}>
            {summary}
        </p>
    );
}