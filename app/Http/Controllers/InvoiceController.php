<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function show()
    {    
        $userId = Auth::id();
        $invoices = User::find($userId)->invoices()->paginate(10);
        //dd($invoices);
        return view('invoice',['invoices'=>$invoices]);
    }
}