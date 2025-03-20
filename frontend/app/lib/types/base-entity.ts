// app/lib/types/base-entity.ts

import * as t from "@/app/lib/types";

export type Entity = {
  id?: number;
  title?: string;
  slug?: string;
  status?: t.StatusEnum;
  content?: string;
  summary?: string;
  country?: string;
  website?: string;
  ageRating?: t.AgeRatingEnum;
  releaseDateWorld?: string;
  releaseDateFrance?: string;
  platformRequirementsLevel?: t.PlatformRequirementsLevelEnum;
  language?: string[];
  createdAt?: Date;
  updatedAt?: Date;
  cover?: string;
  coverUrl?: string;
  relatedItems?: {
    [key: string]: Entity[]
  };
  author?: t.User;
  _categoryName?: string;
}

export type EntityListProps = {
  entityItems?: Entity[];
  entityItem?: Entity;
  relatedEntityItems?: Entity[];
  categoryNames?: string[];
  categoryName?: string;
  relatedCategoryNames?: string[];
  relatedCoreCategories?: string[];
  relatedMetaCategories?: string[];
  entityFields?: {
    label: string;
    value: string;
  }[];
  label?: string;
  status?: t.StatusEnum;
}
