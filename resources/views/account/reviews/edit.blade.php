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
                   Edit Reviews
                </div>
                <div class="card-body pb-0">
                    <div class="card-body">
                        <form action="{{ route('account.review.update',$review->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label  for="review" class="form-label"> Review </label>
                                <textarea name="review" id="review" placeholder="review" class="form-control @error('review') is-invalid @enderror"> {{ old('review',$review->review) }}</textarea>
                                @error('review')
                                    <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label @error('status') is-invalid @enderror">Status</label>
                                <select class="form-control" name="status" id="status">
                                    <option value="1" {{ ($review->stauts == 1) ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ ($review->stauts == 0) ? 'selected' : '' }}>Block</option>
                                </select>
                                @error('stauts')
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
