<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Đăng ký
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);


        return response()->json([
            'message' => 'Đăng ký thành công!',
            'user' => $user,
        ]);
    }

    // Đăng nhập
    public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (!Auth::attempt($request->only('email', 'password'))) {
        return response()->json(['message' => 'Email hoặc mật khẩu không đúng!'], 401);
    }

    // Lấy user đang đăng nhập
    $user = Auth::user();

    // Tạo token mới
    $token = $user->createToken('YourAppName')->plainTextToken;

    return response()->json([
        'message' => 'Đăng nhập thành công!',
        'user' => $user,
        'token' => $token, // 👈 Trả về token
    ]);
}





    // Đăng xuất
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Đăng xuất thành công.'
        ]);
    }

    // Thông tin user
    public function me(Request $request)
    {
        return response()->json($request->user());
    }
}
