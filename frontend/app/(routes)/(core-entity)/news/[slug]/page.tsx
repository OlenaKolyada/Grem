import { notFound } from "next/navigation";
import { CoreEntityContainer } from "@/app/components/entity";
import type { Metadata } from 'next';
import { generateItemMetadata } from '@/app/lib/utils';
import { fetchEntityBySlug } from "@/app/lib/fetch";
import { Entity } from "@/app/lib/types";
import { API_URL} from "@/app/lib/config";

export async function generateMetadata(props: {
  params: Promise<{ slug: string }>;
}): Promise<Metadata> {
  const { slug } = await props.params;

  const entity = await fetchEntityBySlug<Entity>("news", slug);
  if (!entity) {
    return { title: "First Fuck Next1.js" };
  }

  return generateItemMetadata({
    categoryName: "news",
    itemTitle: entity.title || "",
  });
}

export default async function Page(props: {
  params: Promise<{ slug: string }>;
}) {
  const { slug } = await props.params;

  const response = await fetch(`${API_URL}/api/news/resolve/${slug}`);

  if (!response) {
    notFound();
    return null;
  }
  
  return (
        <CoreEntityContainer
            categoryName={"news"}
            relatedMetaCategories={['tag']}
            relatedCoreCategories={['game']}
        />
      // </div>
  );
}