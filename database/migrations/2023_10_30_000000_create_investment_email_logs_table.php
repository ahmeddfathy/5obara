<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * تنفيذ الهجرة
     *
     * @return void
     */
    public function up()
    {
        Schema::create('investment_email_logs', function (Blueprint $table) {
            $table->id();
            $table->string('subject');
            $table->string('investment_type');
            $table->integer('recipients_count')->default(0);
            $table->integer('success_count')->default(0);
            $table->integer('failure_count')->default(0);
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * عكس الهجرة
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('investment_email_logs');
    }
};
