<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
//        DB::insert('insert into users (name,email,password) values (?,?,?)',['kasun','kasun@gmail.com','123456']);
//        $users = DB::select('select * from users');
//        return $users;
//
//        $user = new User();
//        $user->name = 'aaaa';
//        $user->email = 'aaaa@gmail.com';
//        $user->password = bcrypt('abcdefg');
//        $user->save();


//        $data = ['name' => 'Elon', 'email' => 'elon@gmail.com', 'password' => 'abcdefg'];
//        User::create($data);

//        return User::all();

        return view('welcome');
    }
}
