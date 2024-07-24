<?php

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
        Schema::create('credit_cards', function (Blueprint $table) {
            $table->id();
            $table->string('account_number');
            $table->string('cvc');
            $table->timestamp('expiry_date');
            $table->string('holder');
            $table->boolean('is_active')->default(true);
            $table->string('issuer'); // uba | orabank | BGFI
            $table->string('network'); // visa | mastercard
            $table->string('number');
            $table->tinyInteger('type'); // prepaid | debit | unsecured ...
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credit_cards');
    }
};
