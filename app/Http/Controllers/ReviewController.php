<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    //This metho will show revies in admin panel
    public function index(Request $request){
        $reviews = Review::with('book','user')->orderBy('created_at','DESC');

        if (!empty($request->keyword)){
            $reviews = $reviews->where('review','like','%'.$request->keyword.'%');
        }

        $reviews = $reviews->paginate(10);

        return view('account.reviews.list',[
            'reviews' => $reviews
        ]);
    }

    //This methos will show edit review page
    public function edit($id){
        $review = Review::findOrFail($id);
        return view('account.reviews.edit',[
            'review' => $review
        ]);
    }

    //This method use update review
    public function updateReview($id,Request $request)
    {
        $review = Review::findOrFail($id);

        $validator = Validator::make($request->all(),[
            'review' => 'required',
            'status' => 'required'
        ]);

        if($validator->fails()) {
            return redirect()->route('account.review.edit',$id)->withInput()->withErrors($validator);
        }

        $review->review = $request->review;
        $review->status = $request->status;
        $review->save();

        session()->flash('success','Review update successfully.');
        return redirect()->route('account.reviews');
    }

}
