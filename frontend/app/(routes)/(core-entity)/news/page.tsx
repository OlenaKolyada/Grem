import type { Metadata } from 'next';
import { CoreCollectionContainer } from "@/app/components/collection";
import { generateCollectionMetadata } from '@/app/lib/utils';

export async function generateMetadata(): Promise<Metadata> {
    return generateCollectionMetadata("news");
}

export default function Page() {
    return (
        <CoreCollectionContainer
            categoryName="news"
        />
    );
}
