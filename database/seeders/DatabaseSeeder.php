<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // إنشاء الأدوار الأساسية
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);

        // إنشاء بعض الصلاحيات الأساسية
        $permissions = [
            'access dashboard',
            'manage users',
            'manage content',
            'manage settings',
            'read content',  // صلاحية للمستخدمين العاديين
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // إعطاء جميع الصلاحيات للأدمن
        $adminRole->givePermissionTo($permissions);

        // إعطاء صلاحية قراءة المحتوى للمستخدمين العاديين
        $userRole->givePermissionTo('read content');

        // إنشاء مستخدم أدمن
        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);

        // إسناد دور أدمن للمستخدم
        $admin->assignRole('admin');

        // إنشاء مستخدم عادي للاختبار
        $user = User::factory()->create([
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
        ]);

        // إسناد دور مستخدم عادي
        $user->assignRole('user');
    }
}
