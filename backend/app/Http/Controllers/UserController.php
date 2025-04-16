<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Lấy danh sách người dùng
    public function index()
    {
        // Lấy danh sách người dùng đã xóa
        //$users = User::onlyTrashed()->get();

        // Lấy danh sách người dùng chưa xóa
        $users = User::all();

        // Lấy danh sách tất cả người dùng (bao gồm đã xóa)
        // $users = User::withTrashed()->get();

        // Lấy danh sách tất cả người dùng (bao gồm đã xóa) và phân trang
        // $users = User::withTrashed()->paginate(10);

        return response()->json($users);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    // Thêm người dùng mới
    public function store(Request $request)
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

        return response()->json($user, 201);
    }

    // Sửa thông tin người dùng
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return response()->json($user);
    }

    public function restoreUser($id)
    {
        $user = User::withTrashed()->findOrFail($id); // Lấy người dùng đã bị xóa mềm

        $user->restore(); // Khôi phục người dùng

        return response()->json(['message' => 'Người dùng đã được khôi phục.']);
    }


    // Xóa người dùng
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }
}
