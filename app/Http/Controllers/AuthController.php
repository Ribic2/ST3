<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Http\Resources\UserResource;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * @param Request $request
     * @return Response|JsonResponse
     */
    public function login(Request $request): Response|JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6'
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors()], 422);
        }

        if (!Auth::attempt($request->all())) {
            return response(['error' => [
                'error' => 'User does not exist.'
            ]], 422);
        }

        $token = Auth::user()->createToken('API Token')->accessToken;

        return response()->json(['token' => $token]);

    }

    /**
     * @param Request $request
     * @return JsonResponse|Response
     */
    public function register(Request $request): Response|JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required|same:password_confirmation',
            'password_confirmation' => 'required',
            'name' => 'required',
            'surname' => 'required',
            'dateOfBirth' => 'required',
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors()], 422);
        }

        $user = (new User)->create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'name' => $request->name,
            'surname' => $request->surname,
            'dateOfBirth' => $request->dateOfBirth
        ]);

        $token = $user->createToken('API Token')->accessToken;

        return response()->json(['token' => $token]);
    }

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        Auth::logout();
        return \response()->json([
            'response' => 'User logged out!'
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function getUser(): JsonResponse
    {
        return response()->json(
            [
                'user' => UserResource::make(
                    User::with('friendRequests')
                        ->where('id', Auth::id())->first()
                ),
                'posts' => PostResource::collection(
                    Post::where('user_id', '=', Auth::id())->get()
                )
            ]);
    }
}
