<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name')->after('id');
            $table->string('last_name')->after('first_name');
            $table->string('phone')->unique()->after('email');
            $table->timestamp('phone_verified_at')->nullable()->after('phone');
            $table->json('interests')->nullable()->after('phone_verified_at');
            $table->string('location')->nullable()->after('interests');
            $table->json('current_knowledge')->nullable()->after('location');
            $table->enum('registration_status', ['pending', 'approved', 'rejected', 'payment_pending', 'completed'])->default('pending')->after('current_knowledge');
            $table->decimal('amount_paid', 10, 2)->default(0)->after('registration_status');
            $table->string('payment_reference')->nullable()->after('amount_paid');
            $table->timestamp('registered_at')->nullable()->after('payment_reference');
            
            // Drop name column since we now have first_name and last_name
            $table->dropColumn('name');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name')->after('id');
            $table->dropColumn([
                'first_name',
                'last_name', 
                'phone',
                'phone_verified_at',
                'interests',
                'location',
                'current_knowledge',
                'registration_status',
                'amount_paid',
                'payment_reference',
                'registered_at'
            ]);
        });
    }
};