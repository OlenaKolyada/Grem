<?php

namespace App\Enum;

enum CommentStatusEnum: string
{
    case Published = 'Published';
    case Edited = 'Edited';
    case Deleted = 'Deleted';
}
