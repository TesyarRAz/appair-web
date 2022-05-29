<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class price extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('price.per_kubik', 0);
    }
}
