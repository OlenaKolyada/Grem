import { notFound } from "next/navigation";
import { MetaEntityContainer } from "@/app/components/entity";
import type { Metadata } from 'next';
import { generateItemMetadata } from '@/app/lib/utils';
import { fetchEntityBySlug } from "@/app/lib/fetch";
import {Entity} from "@/app/lib/types";

export async function generateMetadata(props: {
  params: Promise<{ slug: string }>;
}): Promise<Metadata> {
  const { slug } = await props.params;
  const entity = await fetchEntityBySlug<Entity>("genre", slug);

  if (!entity) {
    return { title: "Not Found" };
  }

  return generateItemMetadata({
    categoryName: "genre",
    itemTitle: entity.title || ""
  });
}

export default async function Page(props: {
  params: Promise<{ slug: string }>;
}) {
  const { slug } = await props.params;

  // Проверяем существование сущности на серверной стороне
  const entity = await fetchEntityBySlug<Entity>("genre", slug);

  if (!entity) {
    notFound();
    return null;
  }

  return (
      <MetaEntityContainer
          categoryName="genre"
          relatedCategoryNames={["game"]}
      />
  );
}