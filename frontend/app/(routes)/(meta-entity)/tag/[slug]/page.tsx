import { notFound } from "next/navigation";
import {fetchBySlug, fetchEntityBySlug} from "@/app/lib/fetch";
import { MetaEntityContainer } from "@/app/components/entity";
import type { Metadata } from 'next';
import { generateItemMetadata } from '@/app/lib/utils';

export async function generateMetadata({ params }: { params: { slug: string } }): Promise<Metadata> {
  const entity = await fetchEntityBySlug("tag", params.slug);
  if (!entity) {
    return {
      title: 'Not Found'
    };
  }

  return generateItemMetadata({
    categoryName: "tag",
    itemTitle: entity.title
  });
}

export default async function Page({ params }: { params: { slug: string } }) {
  const entityId = await fetchBySlug("tag", params.slug);

  if (!entityId) {
    notFound();
    return null;
  }

  return (
      <MetaEntityContainer
          categoryName="tag"
          relatedCategoryNames={["news", "review"]}
      />
  );
}
