<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class general extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.start_date', now()->startOfMonth());
    }
}
