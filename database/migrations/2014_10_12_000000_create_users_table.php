<?php

use App\Enum\Status;
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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string(config('i18n.attribute', 'locale'), 5)->default(config('app.locale', 'fr'));
            $table->string('password');
            $table->unsignedTinyInteger('user_status')->default(Status::ENABLED->value);
            $table->string('provider_name', 100)->nullable();
            $table->string('provider_id')->nullable();
            $table->longText('fcm_token')->nullable();
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
