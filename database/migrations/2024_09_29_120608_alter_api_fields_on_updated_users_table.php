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
        Schema::table('updated_users', function (Blueprint $table) {
            $table->longText(UpdatedUser::API_RESPONSE)->nullable()->change();
            $table->boolean(UpdatedUser::IS_API_POST_SUCCESS)->default(false)->change();
            $table->unsignedInteger(UpdatedUser::RETRY)->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('updated_users', function (Blueprint $table) {
            $table->longText('api_response')->change();
            $table->unsignedInteger(UpdatedUser::RETRY)->change();
            $table->boolean(UpdatedUser::IS_API_POST_SUCCESS)->change();
        });
    }
};
