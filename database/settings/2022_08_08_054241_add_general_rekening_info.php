<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class add_general_rekening_info extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.mobile_rekening_info', '');
    }
}
