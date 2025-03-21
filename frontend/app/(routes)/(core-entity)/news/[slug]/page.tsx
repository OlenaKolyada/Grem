import { notFound } from "next/navigation";
import { fetchBySlug } from "@/app/lib/fetch/fetchBySlug";
import { CoreEntityContainer } from "@/app/components/entity";
import type { Metadata } from 'next';
import { generateItemMetadata } from '@/app/lib/utils';
import { fetchEntityBySlug } from "@/app/lib/fetch";

export async function generateMetadata(props: {
  params: Promise<{ slug: string }>;
}): Promise<Metadata> {
  const { slug } = await props.params;
  const entity = await fetchEntityBySlug("news", slug);

  if (!entity) {
    return { title: "Not Found" };
  }

  return generateItemMetadata({
    categoryName: "news",
    itemTitle: entity.title,
  });
}

export default async function Page(props: {
  params: Promise<{ slug: string }>;
}) {
  const { slug } = await props.params;

  const entityId = await fetchBySlug("news", slug);

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