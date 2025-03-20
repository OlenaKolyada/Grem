// app/lib/types/entity/profile.ts

import { News, Review, Comment } from '@/app/lib/types';

export type User = {
    id: number;
    email: string;
    password: string;
    roles: string[];
    nickname: string;
    twitchAccount: string | null;
    avatar: string | null;
    avatarUrl?: string;
    news: News[];
    review: Review[];
    comment: Comment[];
    createdAt: Date;
    updatedAt: Date;
}