<?php

use App\Models\Grade;
use App\Models\School;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('grade_school', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Grade::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(School::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grade_school');
    }
};
