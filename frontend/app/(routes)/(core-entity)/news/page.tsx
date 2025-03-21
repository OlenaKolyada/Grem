import type { Metadata } from 'next';
import { CoreCollectionContainer } from "@/app/components/collection";
import { generateCollectionMetadata } from '@/app/lib/utils';
import {Suspense} from "react";

export async function generateMetadata(): Promise<Metadata> {
    return generateCollectionMetadata("news");
}

export default function Page() {
    return (
        <Suspense fallback={<div></div>}>
        <CoreCollectionContainer categoryName="news" />
        </Suspense>
    );
}
