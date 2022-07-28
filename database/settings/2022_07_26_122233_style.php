<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class style extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('style.app_image', asset('empty-image.png'));
        $this->migrator->add('style.bg_type', 'color');
        $this->migrator->add('style.bg_color', '#ffffff');
        $this->migrator->add('style.bg_image', asset('empty-image.png'));
    }
}
