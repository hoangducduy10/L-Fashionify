<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function getAllUsers()
    {
        return response()->json(User::all(), 200);
    }

    public function getUserById($id)
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
            if ($request->user()->id != $id) {
                return response()->json([
                    'message' => 'Unauthorized action.'
                ], Response::HTTP_FORBIDDEN);
            }

            $request->validate([
                'name' => 'string|max:255',
                'email' => 'string|email|unique:users,email,' . $id
            ]);

            $user = User::findOrFail($id);
            $user->update($request->only(['name', 'email']));

            return response()->json([
                'message' => 'User updated successfully!',
                'user' => $user
            ]);
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
