<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) { 
            $table->string('firstname');
            $table->string('lastname');
            $table->string('middlename')->nullable();
            $table->string('fullname')->nullable();
            $table->string('position')->nullable();
            $table->string('designation')->nullable();
            $table->string('username')->unique()->nullable();
            $table->string('email')->unique()->nullable();
            $table->boolean('is_active')->nullable()->default(true);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('users', function (Blueprint $table) { 
            $table->dropColumn('firstname');
            $table->dropColumn('middlename');
            $table->dropColumn('fullname');
            $table->dropColumn('position');
            $table->dropColumn('designation');
            $table->dropColumn('username');
            $table->dropColumn('email');
            $table->dropColumn('is_active');
            $table->dropColumn('deleted_at');
        });
    }
};
