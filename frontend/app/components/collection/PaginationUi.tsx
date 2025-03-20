// app/components/collection/ui/PaginationUi.tsx

import React from 'react';
import Link from 'next/link';
import { BG_DARK_BLUE } from "@/app/ui/theme/colors";

interface PaginationUIProps {
    page: number;
    pages: number;
    pageNumbers: number[];
    totalItems: number;
    limit: number;
    createPageUrl: (page: number) => string;
}

export function PaginationUI({
                                 page,
                                 pages,
                                 pageNumbers,
                                 totalItems,
                                 limit,
                                 createPageUrl
                             }: PaginationUIProps) {
    return (
        <div className="flex justify-center mt-6">
            <nav className="inline-flex">
                {/* Кнопка Предыдущая */}
                {page > 1 ? (
                    <Link
                        href={createPageUrl(page - 1)}
                        className="px-3 py-2 bg-white text-gray-700 hover:bg-gray-50"
                    >
                        &laquo; Prev
                    </Link>
                ) : (
                    <span className="px-3 py-2 text-gray-400 cursor-not-allowed">
                        &laquo; Prev
                    </span>
                )}

                {/* Номера страниц */}
                {pageNumbers.map(num => (
                    num === page ? (
                        <span
                            key={num}
                            className={`px-3 py-2 ${BG_DARK_BLUE} text-white font-bold`}
                        >
                            {num}
                        </span>
                    ) : (
                        <Link
                            key={num}
                            href={createPageUrl(num)}
                            className="px-3 py-2 text-gray-700 hover:bg-gray-50"
                        >
                            {num}
                        </Link>
                    )
                ))}

                {/* Кнопка Следующая */}
                {page < pages ? (
                    <Link
                        href={createPageUrl(page + 1)}
                        className="px-3 py-2 text-gray-700 hover:bg-gray-50"
                    >
                        Next &raquo;
                    </Link>
                ) : (
                    <span className="px-3 py-2 text-gray-400 cursor-not-allowed">
                        Next &raquo;
                    </span>
                )}
            </nav>

            <div className="text-sm text-gray-500 ml-4 self-center">
                Showing {totalItems > 0 ? (page - 1) * limit + 1 : 0} to {Math.min(page * limit, totalItems)} of {totalItems} results
            </div>
        </div>
    );
}