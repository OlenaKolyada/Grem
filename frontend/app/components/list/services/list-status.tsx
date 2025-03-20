// app/components/list/services/list-status.tsx
'use client'

import React from 'react';

export function ListError({ error }: { error: string }) {
    return <p className="text-red-500">Error: {error}</p>;
}

export function ListLoading({ className = "p-9" }: { className?: string }) {
    return <div className={className}></div>;
}

export function ListEmpty() {
    return <p className="text-gray-500">No data available.</p>;
}