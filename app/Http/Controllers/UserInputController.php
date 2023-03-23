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
        $fname=$request->fname;
        $lname=$request->lname;
        $phone=$request->phone;
        if ($user) {
            //$selecuser = UserInput::findOrFail($user->id);
            $emailRes = $this->sendEmail($email,$phone,$lname,$fname);

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

    public function sendEmail($email,$phone,$lname,$fname)
    {$selectedUser = UserInput::where('email', '=', $email)->firstOrFail();
            Mail::to("chatbot416@gmail.com")->send(new Registration($email,$phone,$lname,$fname));

            $selectedUser->update([
                "sent" => true
            ]);

            return new JsonResponse(
                [
                    'emailsuccess' => true,
                    'message' => "email send succsseflly",
                ]
            );


    }

}
