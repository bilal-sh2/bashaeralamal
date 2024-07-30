<?php
// app/Http/Controllers/AuthController.php
namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        $teacher = Teacher::where('email', $validated['email'])->first();

        if (!$teacher || !Hash::check($validated['password'], $teacher->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // Load groups associated with the teacher
        $teacher->load('groups');

        return response()->json($teacher);
    }
}
