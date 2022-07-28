<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class StyleSetting extends Settings
{
    public ?string $app_image = 'empty-image.png';
    public ?string $bg_type = 'color';
    public ?string $bg_color = '#ffffff';
    public ?string $bg_image = 'empty-image.png';

    public static function group(): string
    {
        return 'style';
    }

    public function activeBgValue()
    {
        return $this->bg_type == 'color' ? $this->bg_color : $this->bg_image;
    }
}