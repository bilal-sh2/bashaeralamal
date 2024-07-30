<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ItemController extends Controller
{
    public function index($classId)
    {
        $class = SchoolClass::findOrFail($classId);
        $items = $class->items()->get();

        return view('item.index', compact('items', 'class'));
    }

    public function create($classId)
    {
        $class = SchoolClass::findOrFail($classId);
        return view('item.create', compact('class'));
    }

    public function store(Request $request, $classId)
    {
        $class = SchoolClass::findOrFail($classId);

        // Validate request data
        $validator = Validator::make($request->all(), [
            'image' => 'required|file|mimes:jpeg,jpg,png,gif,svg|max:2048',
            'title' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Save the uploaded file
        $file = $request->file('image');
        $filePath = $file->store('images_item');

        // Create a new item record in the database
        $item = Item::create([
            'class_id' => $class->id,
            'image' => $filePath,
            'title' => $request->title,
        ]);

        return redirect()->route('items.index', $class->id)
            ->with('success', 'تم حفظ الملف بنجاح.');
    }

    public function show(Item $item)
    {
        return view('items.show', compact('item'));
    }

    public function edit(Item $item)
    {
        return view('items.edit', compact('item'));
    }

    public function update(Request $request, Item $item)
    {
        // Validate request data
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'image' => 'nullable|file|mimes:jpeg,jpg,png,gif,svg|max:2048',
            'title' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Handle updating the image if a new one is uploaded
        if ($request->hasFile('image')) {
            // Delete the old image from storage
            if (Storage::exists($item->image)) {
                Storage::delete($item->image);
            }

            // Save the new uploaded image
            $file = $request->file('image');
            $filePath = $file->store('images_item');
            $item->image = $filePath;
        }

        // Update the item's title
        $item->title = $request->title;
        $item->save();

        return redirect()->route('items.index', $item->class_id)
            ->with('success', 'تم تحديث الملف بنجاح.');
    }

    public function destroy(Item $item)
    {
        // Delete the image from storage
        if (Storage::exists($item->image)) {
            Storage::delete($item->image);
        }

        // Delete the item record from the database
        $item->delete();

        return redirect()->back()
            ->with('success', 'تم حذف الملف بنجاح.');
    }
    

    // API Methods

    public function store_api(Request $request)
    {
        // Validate request data
        $validator =  \Illuminate\Support\Facades\Validator::make($request->all(), [
            'class_id' => 'required|exists:school_classes,id',
            'image' => 'required|file|mimes:jpeg,jpg,png|max:2048',
            'title' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            // Save the uploaded file
            $file = $request->file('image');
            $filePath = $file->store('images_item');

            // Create a new item record in the database
            $item = Item::create([
                'class_id' => $request->class_id,
                'image' => $filePath,
                'title' => $request->title,
            ]);

            return response()->json(['message' => 'تم حفظ الملف بنجاح.', 'item' => $item], 201);
        } catch (\Exception $e) {
            Log::error('Error saving file: ' . $e->getMessage());
            return response()->json(['error' => 'حدث خطأ أثناء حفظ الملف.'], 500);
        }
    }
    

    // يعرض الملفات المرتبطة بالصف
    public function show_api($id)
    {
        try {
            $files = Item::where('class_id', $id)->get();

            if ($files->isEmpty()) {
                return response()->json(['error' => 'لا توجد ملفات.'], 404);
            }

            return response()->json($files, 200);
        } catch (\Exception $e) {
            Log::error('Error fetching files: ' . $e->getMessage());
            return response()->json(['error' => 'حدث خطأ أثناء جلب الملفات.'], 500);
        }
    }

    // حذف الملف عبر API
    public function destroy_api($id)
    {
        try {
            $file = Item::find($id);

            if (!$file) {
                return response()->json(['error' => 'الملف غير موجود.'], 404);
            }

            if (Storage::exists($file->image)) {
                Storage::delete($file->image);
            }

            $file->delete();

            return response()->json(['message' => 'تم حذف الملف بنجاح.'], 200);
        } catch (\Exception $e) {
            Log::error('Error deleting file: ' . $e->getMessage());
            return response()->json(['error' => 'حدث خطأ أثناء حذف الملف.'], 500);
        }
    }

    public function index_api($class_id)
    {
        try {
            $items = Item::where('class_id', $class_id)->get();

            if ($items->isEmpty()) {
                return response()->json(['error' => 'لا توجد ملفات.'], 404);
            }

            return response()->json($items, 200);
        } catch (\Exception $e) {
            Log::error('Error fetching items: ' . $e->getMessage());
            return response()->json(['error' => 'حدث خطأ أثناء جلب الملفات.'], 500);
        }
    }
}
