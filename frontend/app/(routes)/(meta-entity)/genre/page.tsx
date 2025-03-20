import type { Metadata } from 'next';
import { MetaCollectionContainer } from "@/app/components/collection";
import { generateCollectionMetadata } from '@/app/lib/utils';

export async function generateMetadata(): Promise<Metadata> {
    return generateCollectionMetadata("genre");
}

export default function Page() {
    return (
        <MetaCollectionContainer
            categoryName="genre"
        />
    );
}