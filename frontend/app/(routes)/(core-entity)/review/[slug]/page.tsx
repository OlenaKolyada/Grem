import { notFound } from "next/navigation";
import { fetchBySlug } from "@/app/lib/fetch/fetchBySlug";
import { CoreEntityContainer } from "@/app/components/entity";
import type { Metadata } from 'next';
import { generateItemMetadata } from '@/app/lib/utils';
import { fetchEntityBySlug } from "@/app/lib/fetch";

export async function generateMetadata({ params }: { params: { slug: string } }): Promise<Metadata> {
  const entity = await fetchEntityBySlug("review", params.slug);
  if (!entity) {
    return {
      title: 'Not Found'
    };
  }

  return generateItemMetadata({
    categoryName: "review",
    itemTitle: entity.title
  });
}

export default async function Page({ params }: { params: { slug: string } }) {
  if (!params) return null;

  const entityId = await fetchBySlug("review", params.slug);

  if (!entityId) {
    notFound();
    return null;
  }

  const fields = [
    { label: "Game Rating", value: "gameRating" }
  ];

  return (
      <CoreEntityContainer
          categoryName={"review"}
          relatedMetaCategories={['tag']}
          relatedCoreCategories={['game']}
          entityFields={fields}
      />
  );
}
