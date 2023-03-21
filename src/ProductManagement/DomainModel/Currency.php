<?php

declare(strict_types=1);

namespace App\ProductManagement\DomainModel;

enum Currency: string
{
    case PLN = 'PLN';
    case EUR = 'EUR';
}
