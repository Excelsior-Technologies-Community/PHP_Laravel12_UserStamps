<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();

            // User who performed the action
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Related post
            // Nullable because a force-deleted post no longer exists.
            $table->foreignId('post_id')
                ->nullable()
                ->constrained('posts')
                ->nullOnDelete();

            // created, updated, deleted, restored, force_deleted
            $table->string('action');

            // Human-readable description
            $table->text('description');

            $table->timestamps();

            $table->index('action');
            $table->index('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('activity_logs');
    }
};