<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use App\Models\Book;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $books = Book::orderBy('created_at','DESC');
        
        if(!empty($request->keyword)) {

            $books->where('title','like','%'.$request->keyword.'%');
        }

        $books = $books->paginate(10);

        return view('books.list',['books'=>$books]);
    }

    public function creata()
    {
        return view('books.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|min:5',
            'author' => 'required|min:4',
            'status' => 'required',
        ];

        if(!empty($request->image)){
            $rules['image'] = 'image';
        }

        $validator = Validator::make($request->all(),$rules);

        if($validator->fails()){
            return redirect()->route('books.create')->withInput()->withErrors($validator);
        }

        $book = new Book();
        $book->title = $request->title;
        $book->author = $request->author;
        $book->status = $request->status;
        $book->discription = $request->discription;
        $book->save();

               //Here we will uploade image
        if(!empty($request->image)) {

        //Delete old image here
        File::delete(public_path('uploads/books/'.$book->image));
        File::delete(public_path('uploads/books/thum/'.$book->image));

        
        $image = $request->image;
        $ext = $image->getClientOriginalExtension();
        $imageName = time().'.'.$ext;
        $image->move(public_path('uploads/books'),$imageName);
        
        $book->image = $imageName;
        $book->save();

        $manager = new ImageManager(Driver::class);
        $img = $manager->read(public_path('uploads/books/'.$imageName));

        $img->resize(990);
        $img->save(public_path('uploads/books/thum/'.$imageName));

        }

        return redirect()->route('books.index')->with('success','Book save successfully.');
    }

    public function edit()
    {

    }

    public function update()
    {

    }

    public function destroy()
    {

    }
}
