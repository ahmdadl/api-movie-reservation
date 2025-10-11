<?php

namespace Modules\Users\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\Users\Models\User;
use Schema;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createSuperAdminRule();

        User::factory()
            ->admin()
            ->create([
                'first_name' => 'System',
                'last_name' => 'Admin',
                'email' => 'system_admin@site.com',
                'password' => Hash::make(str()->random(10)),
            ]);

        User::factory()
            ->admin()
            ->create([
                'first_name' => 'Ahmed',
                'last_name' => 'Admin',
                'email' => 'ahmdadl.admin@gmail.com',
                'password' => Hash::make('123123123'),
            ]);

        User::factory()->create([
            'first_name' => 'Ahmed',
            'last_name' => 'User',
            'email' => 'ahmdadl.user@gmail.com',
            'password' => Hash::make('123123123'),
        ]);

        // add tokens
        $userId = User::user()->first()->id;

        DB::unprepared(
            "
        INSERT INTO personal_access_tokens (tokenable_type, tokenable_id, name, token, abilities) VALUES
('Modules\Users\Models\User',	'$userId',	'seed',	'a93d348104b4cea8867278a539746185ea41c6566a9a22262efb02f864f4bb2c',	'[*]')",
        );

        if (!Schema::hasTable('model_has_roles')) {
            return;
        }

        $admins = User::admin()->get();

        foreach ($admins as $admin) {
            DB::table('model_has_roles')->insert([
                'role_id' => DB::table('roles')
                    ->where('name', 'super_admin')
                    ->first()->id,
                'model_type' => User::class,
                'model_id' => $admin->id,
            ]);
        }
    }

    private function createSuperAdminRule(): void
    {
        DB::unprepared("
-- Drop tables if they exist (in reverse order due to foreign key dependencies)
-- MySQL uses 'IF EXISTS' but doesn't have 'CASCADE' directly on DROP TABLE.
-- To handle foreign keys, you may need to temporarily disable checks or drop
-- dependent tables first. Since the order is reversed, simple IF EXISTS is usually fine.
DROP TABLE IF EXISTS role_has_permissions;
DROP TABLE IF EXISTS roles;
DROP TABLE IF EXISTS permissions;

-- Create the permissions table
CREATE TABLE permissions (
    -- Replaced BIGSERIAL with BIGINT AUTO_INCREMENT
    id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    guard_name VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL, -- TIMESTAMP in MySQL often requires NULL or a default
    updated_at TIMESTAMP NULL, -- Added NULL for compatibility
    CONSTRAINT permissions_name_guard_name_unique UNIQUE (name, guard_name)
);

-- Insert data into permissions
-- Explicitly setting IDs is fine, but AUTO_INCREMENT will restart from the highest ID + 1.
INSERT INTO permissions (id, name, guard_name, created_at, updated_at) VALUES
(1, 'view_admin', 'web', '2025-06-27 17:04:35', '2025-06-27 17:04:35'),
(2, 'create_admin', 'web', '2025-06-27 17:04:35', '2025-06-27 17:04:35'),
(3, 'update_admin', 'web', '2025-06-27 17:04:35', '2025-06-27 17:04:35'),
(4, 'delete_admin', 'web', '2025-06-27 17:04:35', '2025-06-27 17:04:35');

-- Create the roles table
CREATE TABLE roles (
    -- Replaced BIGSERIAL with BIGINT AUTO_INCREMENT
    id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    guard_name VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL, -- Added NULL for compatibility
    updated_at TIMESTAMP NULL, -- Added NULL for compatibility
    CONSTRAINT roles_name_guard_name_unique UNIQUE (name, guard_name)
);

-- Insert data into roles
INSERT INTO roles (id, name, guard_name, created_at, updated_at) VALUES
(1, 'super_admin', 'web', '2025-06-27 17:04:35', '2025-06-27 17:04:35');

-- Create the role_has_permissions table
CREATE TABLE role_has_permissions (
    -- REFERENCES syntax is fine, but need to add explicit FOREIGN KEY constraints at the end
    permission_id BIGINT NOT NULL,
    role_id BIGINT NOT NULL,
    PRIMARY KEY (permission_id, role_id),
    -- Added explicit FOREIGN KEY definitions
    FOREIGN KEY (permission_id) REFERENCES permissions(id) ON DELETE CASCADE,
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE
);

-- Insert data into role_has_permissions
INSERT INTO role_has_permissions (permission_id, role_id) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1);

-- Set the next ID for the permissions table
-- Replaced PostgreSQL's setval with MySQL's ALTER TABLE AUTO_INCREMENT
ALTER TABLE permissions AUTO_INCREMENT = 9;

-- Set the next ID for the roles table
-- Replaced PostgreSQL's setval with MySQL's ALTER TABLE AUTO_INCREMENT
ALTER TABLE roles AUTO_INCREMENT = 9;
");
    }
}
