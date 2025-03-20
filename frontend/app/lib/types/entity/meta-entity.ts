// app/lib/types/entity/meta-entity.ts

import { Game, News, Review } from '@/app/lib/types';

export type Developer = {
    id: number;
    title: string;
    country: string | null;
    website: string | null;
    createdAt: Date;
    updatedAt: Date;
    game: Game[];
}

export type Genre = {
    id: number;
    title: string;
    createdAt: Date;
    updatedAt: Date;
    game: Game[];
}

export type Platform = {
    id: number;
    title: string;
    createdAt: Date;
    updatedAt: Date;
    game: Game[];
}

export type Publisher = {
    id: number;
    title: string;
    country: string | null;
    website: string | null;
    createdAt: Date;
    updatedAt: Date;
    game: Game[];
}

export type Tag = {
    id: number;
    title: string;
    createdAt: Date;
    updatedAt: Date;
    news: News[];
    review: Review[];
}