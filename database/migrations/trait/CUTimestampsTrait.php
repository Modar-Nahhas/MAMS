<?php

namespace trait;

use Illuminate\Database\Schema\Blueprint;

trait CUTimestampsTrait
{
    private function addTimestamps(Blueprint &$table): void
    {
        $table->timestamp('created_at')->useCurrent();
        $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
    }
}
