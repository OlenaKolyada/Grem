// app/lib/types/entity/core-entity.ts

import * as t from "@/app/lib/types";

export type News = {
    id: number;
    title: string;
    status: t.StatusEnum;
    content: string;
    summary: string;
    cover: string | null;
    createdAt: Date;
    updatedAt: Date;
    tag: t.Tag[];
    game: t.Game[];
    author: t.User;
}

export type Review = {
    id: number;
    title: string;
    status: t.StatusEnum;
    author: t.User;
    content: string;
    summary: string;
    cover: string | null;
    gameRating: number;
    createdAt: Date;
    updatedAt: Date;
    tag: t.Tag[];
    comment: t.Comment[];
    game: t.Game[];
}

export type Game = {
    id: number;
    title: string;
    status:  t.StatusEnum;
    slug: string;
    content: string;
    summary: string;
    releaseDateWorld: Date | null;
    releaseDateFrance: Date | null;
    platformRequirementsLevelEnum: t.PlatformRequirementsLevelEnum;
    ageRating: t.AgeRatingEnum;
    cover: string | null;
    language: string[] | null;
    screenshot: string[] | null;
    trailer: string | null;
    website: string | null;
    createdAt: Date;
    updatedAt: Date;
    news: t.News[];
    review: t.Review[];
    developer: t.Developer[];
    publisher: t.Publisher[];
    genre: t.Genre[];
    platform: t.Platform[];
}