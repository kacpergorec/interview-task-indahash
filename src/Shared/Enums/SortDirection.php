<?php
declare (strict_types=1);

namespace App\Shared\Enums;

enum SortDirection : string
{
    case ASC = 'asc';
    case DESC = 'desc';
}
