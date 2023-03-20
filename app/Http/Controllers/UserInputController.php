<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Mail\Registration;
use App\Models\UserInput;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;

class UserInputController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'email' => 'required|unique:user_inputs,email',
            'phone' => 'required|unique:user_inputs,phone',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $user = UserInput::create([
            'fname' => $request->fname,
            'lname' => $request->lname,
            'email' => $request->email,
            'phone' => $request->phone
        ]);
        $email = $request->email;

        if ($user) {
            $successEmail = Mail::to($email)->send(new Registration($email));

            return new JsonResponse(
                [

                    'email' => $successEmail,
                    'success' => true,
                    'message' => "User created successfully",
                    'user' => new UserResource($user)
                ],
                200
            );
        }
    }
}
