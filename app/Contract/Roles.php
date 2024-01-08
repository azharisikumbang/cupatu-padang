<?php

namespace App\Contract;

use App\Providers\RouteServiceProvider;

enum Roles: string
{
    case ADMINISTRATOR = "administrator";

    case CUSTOMER = "customer";

    case MANAGER = "manager";

    public static function getAllValues(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function getRedirectRoute(): string
    {
        return match($this) {
            self::ADMINISTRATOR => '/administrator/dashboard',
            self::CUSTOMER => RouteServiceProvider::HOME,
            self::MANAGER => '/manager/dashboard',
            default => RouteServiceProvider::HOME,
        };
    }
}