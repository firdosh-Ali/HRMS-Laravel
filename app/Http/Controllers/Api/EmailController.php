<?php

namespace App\Http\Controllers\Api;

use App\Mail\SendEmail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function sendEmail(Request $request)
    {
        $details = [
            'title' => $request->input('title'),
            'body' => $request->input('body'),
        ];

        Mail::to($request->input('email'))->send(new SendEmail($details));

        return response()->json(['message' => 'Email sent successfully!']);
    }

}
