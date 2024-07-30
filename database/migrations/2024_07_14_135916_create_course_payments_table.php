<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::create('course_payments', function (Blueprint $table) {
        $table->id();
        $table->foreignId('course_id')->constrained()->onDelete('cascade'); // ربط بالجدول courses
        
        $table->decimal('amount', 8, 2); // مبلغ الدفعة
        $table->date('payment_date'); // تاريخ الدفعة
        $table->string('payment_method'); // طريقة الدفع
        $table->string('notes')->nullable(); // ملاحظات إضافية

        $table->string('user')->nullable();

        $table->timestamps(); // سيضيف created_at و updated_at
    });
}

public function down()
{
    Schema::dropIfExists('course_payments');
}

};
