// app/lib/types/entity/comment.ts

import { User, Review } from '@/app/lib/types/entity';
import {CommentStatusEnum} from "@/app/lib/types";

export type Comment = {
    id: number;
    content: string;
    status: CommentStatusEnum;
    author: User;
    createdAt: Date;
    updatedAt: Date;
    review: Review;
}