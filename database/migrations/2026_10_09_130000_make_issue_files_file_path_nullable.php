<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * A file entry without a PDF is a subheading in the issue's contents,
 * so file_path becomes optional. Laravel 9 needs doctrine/dbal for
 * ->change(), so the column is altered per driver instead.
 */
return new class extends Migration
{
    public function up()
    {
        $this->setFilePathNullable(true);
    }

    public function down()
    {
        DB::table('issue_files')->whereNull('file_path')->delete();

        $this->setFilePathNullable(false);
    }

    private function setFilePathNullable(bool $nullable): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE issue_files MODIFY file_path VARCHAR(255) '.($nullable ? 'NULL' : 'NOT NULL'));

            return;
        }

        // SQLite cannot alter a column, so rebuild the table.
        Schema::rename('issue_files', 'issue_files_old');

        Schema::create('issue_files', function (Blueprint $table) use ($nullable) {
            $table->id();
            $table->foreignId('issue_id')->constrained()->cascadeOnDelete();
            $table->string('label_ka');
            $table->string('label_en');
            $table->string('author_ka')->nullable();
            $table->string('author_en')->nullable();
            $table->string('pages', 50)->nullable();
            $table->string('file_path')->nullable($nullable);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        DB::statement('INSERT INTO issue_files SELECT id, issue_id, label_ka, label_en, author_ka, author_en, pages, file_path, sort_order, created_at, updated_at FROM issue_files_old');

        Schema::drop('issue_files_old');
    }
};
