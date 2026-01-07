<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\Login as BaseLogin;

class Login extends BaseLogin
{

    public function getHeading(): string | null
    {
        return null;
    }

    public function getSubheading(): string | null
    {
        return null;
    }
}
