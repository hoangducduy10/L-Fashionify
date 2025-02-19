<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use App\Mail\WelcomeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|unique:users,email',
                'password' => 'required|string|min:8',
            ]);

            $data['password'] = bcrypt($data['password']);

            $user = User::create($data);

            $token = $user->createToken($user->id)->plainTextToken;

            try {
                Mail::to($user->email)->queue(new WelcomeMail($user));
            } catch (\Exception $e) {
                Log::error('Email sending failed: ' . $e->getMessage());
            }

            return response()->json([
                'message' => 'User registered successfully!',
                'user' => $user,
                'token' => $token,
            ], Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Throwable $th) {
            return response()->json([
                'errors' => $th->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
