import { notFound } from "next/navigation";
import { MetaEntityContainer } from "@/app/components/entity";
import type { Metadata } from 'next';
import { generateItemMetadata } from '@/app/lib/utils';
import { fetchEntityBySlug } from "@/app/lib/fetch";
import { Entity } from "@/app/lib/types";

export async function generateMetadata(props: {
  params: Promise<{ slug: string }>;
}): Promise<Metadata> {
  const { slug } = await props.params;
  const entity = await fetchEntityBySlug<Entity>("publisher", slug);

  if (!entity) {
    return { title: "Not Found" };
  }

  return generateItemMetadata({
    categoryName: "publisher",
    itemTitle: entity.title || ""
  });
}

export default async function Page(props: {
  params: Promise<{ slug: string }>;
}) {
  const { slug } = await props.params;

  // Проверяем существование сущности на серверной стороне
  const entity = await fetchEntityBySlug<Entity>("publisher", slug);

  if (!entity) {
    notFound();
    return null;
  }

  const fields: { label: string; value: keyof Entity }[] = [
    { label: 'Country', value: 'country' }
  ];

  return (
      <MetaEntityContainer
          categoryName={"publisher"}
          relatedCategoryNames={['game']}
          entityFields={fields}
      />
  );
}