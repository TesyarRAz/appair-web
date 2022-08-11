<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class PriceSetting extends Settings
{
    public ?int $per_kubik = 0;
    public ?int $abudemen = 0;

    public static function group(): string
    {
        return 'price';
    }
}