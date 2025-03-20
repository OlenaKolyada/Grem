import { notFound } from "next/navigation";
import { fetchBySlug } from "@/app/lib/fetch/fetchBySlug";
import { MetaEntityContainer } from "@/app/components/entity";
import type { Metadata } from 'next';
import { generateItemMetadata } from '@/app/lib/utils';
import { fetchEntityBySlug } from "@/app/lib/fetch";

export async function generateMetadata({ params }: { params: { slug: string } }): Promise<Metadata> {
  const entity = await fetchEntityBySlug("developer", params.slug);
  if (!entity) {
    return {
      title: 'Not Found'
    };
  }

  return generateItemMetadata({
    categoryName: "developer",
    itemTitle: entity.title
  });
}

export default async function Page({ params }: { params: { slug: string } }) {
  const entityId = await fetchBySlug("developer", params.slug);

  if (!entityId) {
    notFound();
    return null;
  }

  const fields = [
    { label: 'Country', value: 'country' }
  ];

  return (
      <MetaEntityContainer
          categoryName={"developer"}
          relatedCategoryNames={['game']}
          entityFields={fields}
      />
  );
}
