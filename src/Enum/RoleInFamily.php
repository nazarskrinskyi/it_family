<?php

declare(strict_types=1);

namespace App\Enum;

enum RoleInFamily: string
{
    case FATHER = 'Father';
    case MOTHER = 'Mother';
    case SON = 'Son';
    case DAUGHTER = 'Daughter';
    case BROTHER = 'Brother';
    case SISTER = 'Sister';
    case GRANDFATHER = 'Grandfather';
    case GRANDMOTHER = 'Grandmother';
    case GRANDSON = 'Grandson';
    case GRANDDAUGHTER = 'Granddaughter';
}