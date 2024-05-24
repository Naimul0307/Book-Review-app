<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
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

        $books = $books->paginate(5);

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
        $book->description = $request->description;
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

        $img->resize(860);
        $img->save(public_path('uploads/books/thum/'.$imageName));

        }

        return redirect()->route('books.index')->with('success','Book save successfully.');
    }

    public function edit($id)
    {
        $book = Book::findOrFail($id);
        return view('books.edit',['book' => $book]);
    }

    public function update($id,Request $request)
    {
        $book = Book::findOrFail($id);
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
            return redirect()->route('books.edit',$book->id)->withInput()->withErrors($validator);
        }

        //update book database
        $book->title = $request->title;
        $book->author = $request->author;
        $book->status = $request->status;
        $book->description = $request->description;
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

        //generate image thumbnail here
        $manager = new ImageManager(Driver::class);
        $img = $manager->read(public_path('uploads/books/'.$imageName));
        $img->resize(990);
        $img->save(public_path('uploads/books/thum/'.$imageName));
        }

        return redirect()->route('books.index')->with('success','Book update successfully.');
    }

    public function destroy(Request $request)
    {
        $book = Book::find($request->id);

        if($book == null)
        {
            session()->flash('érror','Book not find');
            return response()->json([
                'status' => false,
                'message' => 'Book not find'
            ]);
        } else {
            File::delete(public_path('uploads/books/'.$book->image));
            File::delete(public_path('uploads/books/thum/'.$book->image));
            $book->delete();

            session()->flash('success','Book deleted successfully!');
            return response()->json([
                'status' => true,
                'message' => 'Book deleted successfully!'
            ]);
        }
    }
}
