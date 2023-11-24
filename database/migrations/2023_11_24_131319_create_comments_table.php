<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Traits\CUTimestampsTrait;
use App\Models\Article;
use App\Models\User;

return new class extends Migration {
    use CUTimestampsTrait;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->text('text');
            $table->foreignIdFor(Article::class)->constrained();
            $table->foreignIdFor(User::class)->constrained();
            $this->addTimestamps($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
