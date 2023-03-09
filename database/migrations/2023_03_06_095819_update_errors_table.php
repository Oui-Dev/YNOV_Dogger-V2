<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('errors', function (Blueprint $table) {
            $table->foreignId('assigned_to')
                ->nullable()
                ->after('status')
                ->constrained('users')
                ->nullOnDelete();
            $table->dropColumn('message');
        });

        Schema::table('errors', function (Blueprint $table) {
            $table->text('message')->nullable()->after('code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('errors', function (Blueprint $table) {
            $table->dropForeign(['assigned_to']);
            $table->dropColumn('assigned_to');
            $table->dropColumn('message');
        });

        Schema::table('errors', function (Blueprint $table) {
            $table->string('message')->nullable()->after('code');
        });
    }
};
