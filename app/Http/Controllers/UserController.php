<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;

class UserController extends Controller
{
    //
    public function index()
    {
        // lấy tất cả orders của user
        return response()->json(User::with('orders'))->get();
    }

    public function login(Request $request)
    {
        $status   = 401;
        $response = ['error', 'Truy cập bị từ chối'];
        if (Auth::attempt($request->only('email', 'password')))
        {
            $status   = 200;
            $response = [
                'user'  => Auth::user(),
                'token' => Auth::user()->createToken('bigStore')->accessToken
            ];
        }
        return response()->json($response, $status);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request,
            [
                'name'             => 'required|min:4|max:60|',
                'email'            => 'required|email',
                'password'         => 'required|min:6',
                'confirm_password' => 'required|same:password'
            ],
            [
                'name.required'             => 'Trường tên là bắt buộc',
                'password.required'         => 'Trường mật khẩu là bắt buộc',
                'confirm_password.required' => 'Trường nhập lại mật khẩu là bắt buộc',
                'email.required'            => 'Trường email là bắt buộc',
            ]);
        if ($validator->fails()){
            return response()->json(['error' => $validator->error()], 401);
        }

        $data = $request->only('name', 'email', 'password');
        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);
        $user->is_admin = 0;
        return response()->json([
            'user' => Auth::user(),
            'token' => Auth::user()->createToken('bigStore')->accessToken
        ]);
    }

    public function show(User $user)
    {
        return response()->json($user);
    }

    public function showOrders(User $user)
    {
        return response()->json($user->orders()->with('product')->get());
    }
}
