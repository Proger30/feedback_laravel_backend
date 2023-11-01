<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
		$data['name'] = 'Main manager';
		$data['email'] = 'admin@admin.com';
		$data['role'] = 'ROLE_MANAGER';
		$data['password'] = bcrypt('qwerty123');
        User::create($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
