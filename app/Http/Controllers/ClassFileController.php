<?php

namespace App\Http\Controllers;

use App\Models\ClassFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClassFileController extends Controller
{
    public function create(Request $request)
    {
        $id = $request->id;
        // يمكنك استخدام المعرف (id) هنا في العمليات اللاحقة
        return view('class_files.create', ['id' => $id]);
    }

    public function store(Request $request)
    {
        // التحقق من البيانات المطلوبة
        $request->validate([
            'class_id' => 'required|exists:school_classes,id',
            'file' => 'required|file',
            'name' => 'required|string',
        ]);

        // حفظ الملف
        $file = $request->file('file');
        $filePath = $file->store('files'); // يمكنك تخصيص المسار حسب الحاجة
        $name = $request->name;
        $class_id = $request->class_id;

        // إنشاء سجل في قاعدة البيانات
        ClassFile::store($class_id, $filePath, $name);

        return redirect()->back()->with('success', 'تم حفظ الملف بنجاح.');
    }

    public function index($id)
    {
        // استرجاع الملفات المرتبطة بالصف المحدد
        $files = ClassFile::where('class_id', $id)->get();

        return view('class_files.index', compact('files'));
    }
    public function destroy($id)
    {
        // البحث عن الملف باستخدام المعرف المعطى
        $file = ClassFile::find($id);

        // التحقق مما إذا كان الملف موجودًا أم لا
        if (!$file) {
            return redirect()->back()->with('error', 'الملف غير موجود.');
        }

        // حذف الملف من قاعدة البيانات
        $file->delete();

        // حذف الملف من النظام الملفاتي
        Storage::delete($file->filePath);

        // إعادة التوجيه إلى الصفحة السابقة مع رسالة نجاح بعد الحذف
        return redirect()->back()->with('success', 'تم حذف الملف بنجاح.');
    }

    // api
    public function store_api(Request $request)
    {
        // التحقق من البيانات المطلوبة
        $validator = Validator::make($request->all(), [
            'class_id' => 'required|exists:school_classes,id',
            'file' => 'required|file',
            'name' => 'required|string',
        ]);

        // إذا كان هناك أي أخطاء في التحقق من الصحة، عدل الاستجابة بناءً على ذلك
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // حفظ الملف
        $file = $request->file('file');
        $filePath = $file->store('files'); // يمكنك تخصيص المسار حسب الحاجة
        $name = $request->name;
        $class_id = $request->class_id;

        // إنشاء سجل في قاعدة البيانات
        ClassFile::create([
            'class_id' => $class_id,
            'filePath' => $filePath,
            'name' => $name,
        ]);

        return response()->json(['message' => 'تم حفظ الملف بنجاح.'], 201);
    }

    // يعرض كل الملفات المرتبطة في الصف
    public function show_api($id)
    {

        $files = ClassFile::where('class_id', $id)->get();

        // البحث عن الملف باستخدام المعرف المعطى

        // التحقق مما إذا كان الملف موجودًا أم لا
        if (!$files) {
            return response()->json(['error' => 'الملف غير موجود.'], 404);
        }

        // إرجاع الملف كجزء من الاستجابة
        return response()->json($files, 200);
    }

    //

    public function destroy_api($id)
    {
        // البحث عن الملف باستخدام المعرف المعطى
        $file = ClassFile::find($id);

        // التحقق مما إذا كان الملف موجودًا أم لا
        if (!$file) {
            return response()->json(['error' => 'الملف غير موجود.'], 404);
        }

        // حذف الملف من قاعدة البيانات
        $file->delete();

        // حذف الملف من النظام الملفاتي
        Storage::delete($file->filePath);

        // إرجاع رسالة نجاح بعد الحذف
        return response()->json(['message' => 'تم حذف الملف بنجاح.'],  200);
    }

}
