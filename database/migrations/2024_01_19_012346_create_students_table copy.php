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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');

            $table->string('email')->unique();
            $table->string('image')->unique();//صورة الطالب

            $table->string('password');
            $table->string('gender');

            $table->string('value_price')->nullable(); //في حال كان اقل من صف تاسع القسط السنوي

            // إضافة مفتاح خارجي لربط الطالب بالصف
            $table->unsignedBigInteger('class_id');
            $table->foreign('class_id')->references('id')->on('school_classes')->onDelete('cascade');

            $table->string('parent_phone1')->nullable(); // رقم ولي الأمر الأول
            $table->string('parent_phone2')->nullable(); // رقم ولي الأمر الثاني

            $table->date('birthdate')->nullable(); // تاريخ ميلاد الطالب
            $table->string('address')->nullable(); // عنوان الطالب

            // ... يمكنك إضافة المزيد من الأعمدة حسب احتياجاتك

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
