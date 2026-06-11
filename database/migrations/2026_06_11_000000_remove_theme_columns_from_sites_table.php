<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('sites', function (Blueprint $table) {
            $table->dropColumn(['theme', 'default_theme']);
        });
    }

    public function down()
    {
        Schema::table('sites', function (Blueprint $table) {
            $table->string('theme')->nullable();
            $table->string('default_theme')->nullable()->after('theme');
        });
    }
};
