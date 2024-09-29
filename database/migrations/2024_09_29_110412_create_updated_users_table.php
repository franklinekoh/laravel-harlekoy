<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\UpdatedUser;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('updated_users', function (Blueprint $table) {
            $table->id();
            $table->string(UpdatedUser::EMAIL)->unique();
            $table->string(UpdatedUser::FIRSTNAME);
            $table->string(UpdatedUser::LASTNAME);
            $table->string(UpdatedUser::TIMEZONE);
            $table->longText(UpdatedUser::API_RESPONSE);
            $table->boolean(UpdatedUser::IS_API_POST_SUCCESS);
            $table->unsignedInteger(UpdatedUser::RETRY);
            $table->timestamps();
            $table->foreign('email')->references('email')->on(
                'users'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('updated_users');
    }
};
