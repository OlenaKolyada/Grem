import { notFound } from "next/navigation";
import { fetchBySlug } from "@/app/lib/fetch/fetchBySlug";
import { CoreEntityContainer } from "@/app/components/entity";
import type { Metadata } from 'next';
import { generateItemMetadata } from '@/app/lib/utils';
import { fetchEntityBySlug } from "@/app/lib/fetch";

export async function generateMetadata({ params }: { params: { slug: string } }): Promise<Metadata> {
  const entity = await fetchEntityBySlug("news", params.slug);
  if (!entity) {
    return {
      title: 'Not Found'
    };
  }

  return generateItemMetadata({
    categoryName: "news",
    itemTitle: entity.title
  });
}

export default async function Page({ params }: { params: { slug: string } }) {
  if (!params) return null;

  const entityId = await fetchBySlug("news", params.slug);

  if (!entityId) {
    notFound();
    return null;
  }

  return (
      <CoreEntityContainer
          categoryName={"news"}
          relatedMetaCategories={['tag']}
          relatedCoreCategories={['game']}
      />
  );
}