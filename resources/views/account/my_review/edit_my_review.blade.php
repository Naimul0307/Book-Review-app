@extends('layouts.app')

@section('main')
<div class="container">
    <div class="row my-5">
        <div class="col-md-3">
            @include('layouts.sidebar')
        </div>
        <div class="col-md-9">

            <div class="card border-0 shadow">
                <div class="card-header  text-white">
                   Edit My Review
                </div>
                <div class="card-body pb-0">
                    <div class="card-body">
                        <form action="{{ route('account.update_my_review',$review->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label  for="review" class="form-label"> Book </label>
                                <div>
                                   <strong>
                                   {{ $review->book->title}}
                                   </strong>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label  for="review" class="form-label"> Review </label>
                                <textarea name="review" id="review" placeholder="review" class="form-control @error('review') is-invalid @enderror"> {{ old('review',$review->review) }}</textarea>
                                @error('review')
                                    <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="rating" class="form-label @error('rating') is-invalid @enderror">Status</label>
                                <select class="form-control" name="rating" id="rating">
                                    <option value="1" {{ ($review->rating == 1) ? 'selected' : '' }}>1</option>
                                    <option value="2" {{ ($review->rating == 2) ? 'selected' : '' }}>2</option>
                                    <option value="3" {{ ($review->rating == 3) ? 'selected' : '' }}>3</option>
                                    <option value="4" {{ ($review->rating == 4) ? 'selected' : '' }}>4</option>
                                    <option value="5" {{ ($review->rating == 5) ? 'selected' : '' }}>5</option>
                                </select>
                                @error('rating')
                                    <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                            <button class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection