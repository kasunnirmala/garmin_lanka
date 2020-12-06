<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(){
        DB::insert('insert into users (name,email,password) values (?,?,?)',['kasun','kasun@gmail.com','123456']);
        return view('welcome');
    }
}
