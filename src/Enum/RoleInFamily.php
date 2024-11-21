<?php

declare(strict_types=1);

namespace App\Enum;

enum RoleInFamily: string
{
    case MAIN_CHARACTER = 'Main Character';
    case HUSBAND = 'Husband';
    case WIFE = 'Wife';
    case SON = 'Son';
    case DAUGHTER = 'Daughter';
    case BROTHER = 'Brother';
    case SISTER = 'Sister';
    case MOTHER = 'Mother';
    case FATHER = 'Father';
    case GRANDFATHER = 'Grandfather';
    case GRANDMOTHER = 'Grandmother';
    case GRANDSON = 'Grandson';
    case GRANDDAUGHTER = 'Granddaughter';
}