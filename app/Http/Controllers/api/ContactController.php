<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Contact;
use App\Http\Requests\ContactForm;

class ContactController extends Controller
{
    //
    public function index(ContactForm $request)
    {

        if ($request->validated()) {
            Contact::create($request->all());
            return response('email send success');

        }
    }
}