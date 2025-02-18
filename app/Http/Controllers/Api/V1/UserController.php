<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;


class UserController extends Controller
{
    public function index()
    {
        return response()->json(User::all(), 200);
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email',
                'password' => 'required|string|min:8',
            ]);

            $data['password'] = bcrypt($data['password']);

            $user = User::create($data);

            Mail::to($user->email)->send(new WelcomeMail($user));

            return response()->json([
                'message' => 'Tạo người dùng thành công!',
                'user' => $user
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Dữ liệu không hợp lệ.',
                'errors' => $e->errors(),
            ], 422);
        }
    }


    public function show($id)
    {
        try {
            $user = User::findOrFail($id);
            return response()->json($user, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'User not found!'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $user = User::findorFail($id);
            $user->update($request->all());

            return response()->json($user, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Can not find user with id: ' . $id,
                'error' => $e->getMessage(),
            ], 404);
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return response()->json(['message' => 'User deleted successfully!'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Can not find user with id: ' . $id,
                'error' => $e->getMessage(),
            ], 404);
        }
    }
}
