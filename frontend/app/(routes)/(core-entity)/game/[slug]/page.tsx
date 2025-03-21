import { notFound } from "next/navigation";
import { fetchBySlug } from "@/app/lib/fetch/fetchBySlug";
import { CoreEntityContainer } from "@/app/components/entity";
import type { Metadata } from 'next';
import { generateItemMetadata } from '@/app/lib/utils';
import { fetchEntityBySlug } from "@/app/lib/fetch";
import { META_ENTITIES } from "@/app/lib/config";

export async function generateMetadata({ params }: { params: { slug: string } }): Promise<Metadata> {
  const entity = await fetchEntityBySlug("game", params.slug);
  if (!entity) {
    return {
      title: 'Not Found'
    };
  }

  return generateItemMetadata({
    categoryName: "game",
    itemTitle: entity.title
  });
}

// Обновляем тип интерфейса в соответствии с Next.js 15
interface PageProps {
  params: { slug: string }
  searchParams?: Record<string, string | string[] | undefined>
}

// Используем новый интерфейс
export default async function Page({ params }: PageProps) {
  if (!params || !params.slug) {
    notFound();
    return null;
  }

  const entityId = await fetchBySlug("game", params.slug);

  if (!entityId) {
    notFound();
    return null;
  }

  const fields = [
    { label: "Age Rating", value: "ageRating" },
    { label: "Release Date World", value: "releaseDateWorld" },
    { label: "Release Date France", value: "releaseDateFrance" },
    { label: "Platform Requirements Level", value: "platformRequirementsLevel" },
    { label: "Languages", value: "language" }
  ];

  return (
      <CoreEntityContainer
          categoryName="game"
          relatedMetaCategories={META_ENTITIES}
          relatedCoreCategories={["news", "review"]}
          entityFields={fields}
      />
  );
}