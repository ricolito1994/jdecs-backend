<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\User;

class UserController extends Controller
{
    //
    public function index(Request $request): JsonResponse
    {
        try {
            $results = User::filter($request->all())->paginate(10);
            return response()->json([
                'data' => $results,
                'success' => true
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'reason' => $e->getMessage(),
                'success' => false
            ], 500);  
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $user = User::findOrFail($id);
            if (!$user) {
                return response()->json(['message' => 'User not found'], 404);
            }
            return response()->json([
                'data' => $user,
                'success' => true
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'reason' => $e->getMessage(),
                'success' => false
            ], 500);  
        }
    }

    public function post (Request $request): JSonResponse
    {
        try {
            $user = User::create($request->all());
            return response()->json([
                'data' => $user,
                'success' => true
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'reason' => $e->getMessage(),
                'success' => false
            ], 500);  
        }
    }

    public function patch(int $id, Request $request) : JSonResponse
    {
        try {
            $user = User::findOrFail($id)->update($request->all());
            if (!$user) {
                return response()->json(['message' => 'User not found'], 404);
            }
            return response()->json([
                'data' => $user,
                'success' => true
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'reason' => $e->getMessage(),
                'success' => false
            ], 500);  
        }
    }

    public function delete(int $id) : JSonResponse
    {
        try {
            $user = User::findOrFail($id);
            if (!$user) {
                return response()->json(['message' => 'User not found'], 404);
            }
            $user->delete();
            return response()->json([
                'message' => 'User deleted successfully',
                'success' => true
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'reason' => $e->getMessage(),
                'success' => false
            ], 500);  
        }
    }
}
