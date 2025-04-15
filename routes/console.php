<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// أمر لتوليد خريطة الموقع sitemap
Artisan::command('sitemap:generate-cron', function () {
    $this->info('جاري تنفيذ أمر توليد خريطة الموقع...');
    Artisan::call('sitemap:generate');
    $this->info('تم تنفيذ أمر توليد خريطة الموقع بنجاح!');
})->purpose('توليد خريطة الموقع عبر الـ Cron Job');
