<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //This Metho Will Show Home Page
    public function index(Request $request)
    {
        $books = Book::orderBy('created_at','DESC');
        if(!empty($request->keyword)) {
            $books->where('title','like','%'.$request->keyword.'%');
        }

       $books = $books->where('status',1)->paginate(3);

        return view('home',[
            'books' => $books
        ]);
    }
}
