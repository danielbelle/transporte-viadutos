<?php

namespace App\Http\Controllers;

use App\Mail\ContactUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function show()
    {
        return view('contact');
    }
    public function send(){
        $data = request()->validate([
            'name' => 'required:min3',
            'email' => 'required|email',
            'message' => 'required|min:5'
        ]);

        Mail::to('henrique.danielb@gmail.com')->send(new ContactUs($data));
        return redirect()->back()->with('success', 'Email sent successfully!');
    }
}
