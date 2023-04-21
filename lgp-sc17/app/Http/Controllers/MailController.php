<?php

namespace App\Http\Controllers;

use App\Mail\AboutUsMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class MailController extends Controller
{
    public function sendEmail(Request $request)
    {
         $this->validate($request, [
            'name' => ['required', 'string', 'max:255' ],
            'email' => ['required', 'string', 'email', 'max:255' ],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string']
         ]);

        Mail::to('healthybyte.noreply@gmail.com')->send(new AboutUsMail($request->email, $request->name, $request->subject, $request->message));
        return back();
    }
}
