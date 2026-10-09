<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('issue_files', function (Blueprint $table) {
            $table->string('author_ka')->nullable()->after('label_en');
            $table->string('author_en')->nullable()->after('author_ka');
            $table->string('pages', 50)->nullable()->after('author_en');
        });
    }

    public function down()
    {
        Schema::table('issue_files', function (Blueprint $table) {
            $table->dropColumn(['author_ka', 'author_en', 'pages']);
        });
    }
};
