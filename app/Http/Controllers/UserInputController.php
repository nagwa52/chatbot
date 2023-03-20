<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Mail\Registration;
use App\Models\UserInput;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use TheSeer\Tokenizer\Exception;

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

            $emailRes = $this->sendEmail($email);
            $selecuser=UserInput::where('email', $email);
            $selecuser->update([
                "sent"=>'true'
            ]);

            return new JsonResponse(
                [
                    'usersuccess' => true,
                    'message' => "User created successfully and email was sent",
                    'user' => $user,
                    'emailRes' => $emailRes
                ],
                200
            );
        } else {
            return new JsonResponse(
                [

                    'usersuccess' => false,
                    'message' => "User does not created ",
                    'user' => new UserResource($user)
                ],
                400
            );
        }
    }

    public function sendEmail($email)
    {

        Mail::to($email)->send(new Registration($email));

            return new JsonResponse(
                [
                    // 'emailsuccess' => false,
                    'message' => "No errors, all sent successfully"
                    // 'error' => Mail::failures()
                ]
            );

    }
}
