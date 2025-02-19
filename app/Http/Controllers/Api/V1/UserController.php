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
