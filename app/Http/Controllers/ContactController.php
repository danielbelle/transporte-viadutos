<?php

namespace App\Http\Controllers;

use App\Mail\ContactUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;

class ContactController extends Controller
{
    public function show()
    {
        return view('contact');
    }

    public function send()
    {


        $data = Crypt::encrypt(request()->validate([
            'name' => 'required|min:3',
            'email' => 'required|email',
            'docRG' => 'required|min:4',
            'docCPF' => 'required|cpf|formato_cpf',
            'period' => 'required|min:3', // primeiro ao décimo
            'institution' => 'required|min:3',
            'course' => 'required|min:3',
            'month' => 'required|min:3',
            'timesInMonth' => 'required|integer',
            'city' => 'required|min:3',
            'phone' => 'required|Celular|celular_com_codigo|celular_com_ddd',
        ]));
        /*Mail::to('henrique.danielb@gmail.com')->send(new ContactUs($data));*/
        return redirect()->back()->with('success', 'Email sent successfully!');
    }
}
