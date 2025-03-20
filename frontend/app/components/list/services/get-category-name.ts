// app/components/list/services/get-category-name.ts
export function getCategoryName(categoryNames: string[], index: number): string {
    return categoryNames.length > 0
        ? categoryNames[index % categoryNames.length]
        : '';
}