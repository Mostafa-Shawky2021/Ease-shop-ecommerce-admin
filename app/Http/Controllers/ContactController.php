<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Http\Requests\ContactForm;
class ContactController extends Controller
{
    //
    public function index(ContactForm $request){
    
        if( $request->validated() ) {
            Contact::create($request->all());
            return response('email send success');

        }
    }
}