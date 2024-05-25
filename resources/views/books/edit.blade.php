@extends('layouts.app')

@section('main')
<section class="p-3 p-md-4 p-xl-5">
    <div class="container">
        <div class="row my-5">
            <div class="col-md-3">
                @include('layouts.sidebar')
            </div>
            <div class="col-md-9">
                @include('layouts.message')
                    <div class="card border-0 shadow">
                        <div class="card-header  text-white">
                            Edit Book
                        </div>
                        <div class="card-body">
                            <form action="{{ route('books.update',$book->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="title" class="form-label">Title</label>
                                    <input type="text" class="form-control @error('title') is-invalid
                                    @enderror" placeholder="Title" name="title" id="title" value="{{ old('title',$book->title) }}" />
                                    @error('title')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="author" class="form-label">Author</label>
                                    <input type="text" class="form-control @error('author') is-invalid

                                    @enderror" placeholder="Author" value="{{ old('author',$book->author) }}" name="author" id="author"/>
                                    @error('author')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="author" class="form-label">Description</label>
                                    <textarea name="description" id="description" class="form-control" placeholder="Description" cols="30" rows="5">{{  old('author',$book->description) }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="image" class="form-label">Image</label>
                                    <input type="file" name="image" id="image" class="form-control @error('image') is-invalid
                                    @enderror">
                                    @error('image')
                                    <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                    @if (!empty($book->image))
                                     <img src="{{ asset('uploads/books/thum/'.$book->image) }}" class="w-25 my-3" alt="{{ $book->title }}">
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="author" class="form-label">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="1" {{ ($book->status == 1) ? 'selected' : ''}}>Active</option>
                                        <option value="0" {{ ($book->status == 0) ? 'selected' : '' }}>Block</option>
                                    </select>
                                </div>
                                <button class="btn btn-primary mt-2">Update</button>
                            </form>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</section>
@endsection
