<?php

namespace App\Enum;

enum StatusEnum: string
{
    case Draft = 'Draft';
    case Published = 'Published';
    case Archived = 'Archived';
    case Deleted = 'Deleted';
}
