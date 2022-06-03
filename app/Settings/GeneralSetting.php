<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSetting extends Settings
{
    public $start_date;

    public static function group(): string
    {
        return 'general';
    }
}