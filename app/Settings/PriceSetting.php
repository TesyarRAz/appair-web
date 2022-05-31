<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class PriceSetting extends Settings
{
    public $per_kubik;

    public static function group(): string
    {
        return 'price';
    }
}