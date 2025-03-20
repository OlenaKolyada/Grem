import React from 'react';

export function formatRole(role: string): string {
    const roleMap: Record<string, string> = {
        "ROLE_ADMIN": "Admin",
        "ROLE_USER": "User"
    };
    return roleMap[role] || role;
}

export const formatFieldValue = (fieldValue: any, fieldName?: string): React.ReactNode => {

    if (fieldValue instanceof Date) {
        return fieldValue.toLocaleDateString('en-GB');
    }

    if (fieldName && (fieldName === 'createdAt' || fieldName === 'updatedAt' || fieldName.includes('Date'))
        && typeof fieldValue === 'string') {
        try {
            return new Date(fieldValue).toLocaleDateString('en-GB');
        } catch (e) {
        }
    }

    if (fieldName === 'roles' && Array.isArray(fieldValue)) {
        return fieldValue.map(formatRole).join(', ');
    }

    if (Array.isArray(fieldValue)) {
        return fieldValue.join(', ');
    }

    if (fieldValue !== null && typeof fieldValue === 'object') {
        return JSON.stringify(fieldValue);
    }

    return fieldValue;
};

export function capitalizeFirstLetter(str: string): string {
    if (!str) return '';
    return str.charAt(0).toUpperCase() + str.slice(1);
}