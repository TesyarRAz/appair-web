<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSetting extends Settings
{
    public ?string $start_date = '';
    public ?string $app_name = 'App Air';
    public ?string $mobile_rekening_info = '';

    public static function group(): string
    {
        return 'general';
    }
}