<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration {
    use \App\Traits\CUTimestampsTrait;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title', 512);
            $table->longText('content');
            $table->enum('status', \App\Enums\ArticleStatusEnum::values());
            $table->foreignIdFor(User::class,'user_id')->constrained();
            $table->foreignIdFor(User::class, 'reviewed_by')->constrained('users');
            $table->foreignIdFor(User::class, 'approved_by')->constrained('users');
            $this->addTimestamps($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
