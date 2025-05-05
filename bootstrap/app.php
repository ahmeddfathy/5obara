<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // تسجيل ميدلويرز صلاحيات Spatie - المسارات الصحيحة
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
            'basic.auth' => \App\Http\Middleware\BasicAuthMiddleware::class,
            'security.headers' => \App\Http\Middleware\SecurityHeaders::class,
            'brute.force' => \App\Http\Middleware\BruteForceProtection::class,
            'sql.injection' => \App\Http\Middleware\SqlInjectionProtection::class,
            'account.takeover' => \App\Http\Middleware\AccountTakeoverProtection::class,
            'suspicious.behavior' => \App\Http\Middleware\SuspiciousBehaviorDetection::class,
            'credential.protection' => \App\Http\Middleware\CredentialLeakProtection::class,
        ]);

        // إضافة ميدلويرز عامة تنفذ على جميع الطلبات
        $middleware->append(\App\Http\Middleware\SecurityHeaders::class);
        $middleware->append(\App\Http\Middleware\SqlInjectionProtection::class);
        // تعطيل مؤقتًا وسيط كشف السلوك المشبوه لحل مشكلة الحظر
        // $middleware->append(\App\Http\Middleware\SuspiciousBehaviorDetection::class);
        $middleware->append(\App\Http\Middleware\CredentialLeakProtection::class);

        // إضافة الحماية ضد هجمات Brute Force إلى مجموعة الويب
        $middleware->prependToGroup('web', \App\Http\Middleware\BruteForceProtection::class);

        // إضافة الحماية ضد محاولات اختطاف الحسابات إلى مجموعة الويب
        $middleware->prependToGroup('web', \App\Http\Middleware\AccountTakeoverProtection::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
