// import { notFound } from "next/navigation";
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

  // // // Базовая отладочная информация
  // const debugInfo = {
  //   slug: slug,
  //   encodedSlug: encodeURIComponent(slug),
  //   apiUrl: API_URL,
  //   fullApiPath: `${API_URL}/api/news/resolve/${slug}`,

  // };

  // Пробуем получить данные напрямую
  let entityResult = null;
  let fetchError = null;

  try {
    const response = await fetch(`${API_URL}/api/news/resolve/${slug}`, {
      cache: 'no-store' // Отключаем кэш для проверки
    });

    if (response.ok) {
      entityResult = await response.json();
    } else {
      fetchError = `Status: ${response.status}, StatusText: ${response.statusText}`;
    }
  } catch (error) {
    fetchError = String(error);
  }

  return (
      // <div style={{ padding: '20px', fontFamily: 'monospace' }}>
      //   <h1>Debug Page</h1>

      //   <h2>Request Info:</h2>
      //   <pre>{JSON.stringify(debugInfo, null, 2)}</pre>

      //   <h2>Fetch Result:</h2>
      //   {entityResult ? (
      //       <pre>{JSON.stringify(entityResult, null, 2)}</pre>
      //   ) : (
      //       <p>No entity found. Error: {fetchError || 'Unknown'}</p>
      //   )}

      //   <hr />

        <CoreEntityContainer
            categoryName={"news"}
            relatedMetaCategories={['tag']}
            relatedCoreCategories={['game']}
        />
      // </div>
  );
}