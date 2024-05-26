@extends('layouts.app')

@section('main')
<div class="container">
    <div class="row my-5">
        <div class="col-md-3">
            @include('layouts.sidebar')
        </div>
        <div class="col-md-9">
            @include('layouts.message')
            <div class="card border-0 shadow">
                <div class="card-header  text-white">
                    Reviews
                </div>
                <div class="card-body pb-0">
                    <div class="d-flex justify-content-end">
                            <form action="" method="get">
                                <div class="d-flex">
                                <input type="text" class="form-control" valu="{{ Request::get('keyword') }}" name="keyword" placeholder="Keyword">
                                <button type="submit" class="btn btn-primary"> Search </button>
                                <a href="{{ route('account.reviews') }}" class="btn btn-secondary ms-2">Clear</a>
                                </div>
                            </form>
                    </div>
                    <table class="table  table-striped mt-3">
                        <thead class="table-dark">
                            <tr>
                                <th>Review</th>
                                <th>User</th>
                                <th>Rating</th>
                                <th>Book</th>
                                <th>Created At</th>
                                <th>Status</th>
                                <th width="100">Action</th>
                            </tr>
                            <tbody>
                                @if($reviews->isNotEmpty())
                                @foreach ($reviews as $review)
                                <tr>
                                    <td>{{ $review->review }}</td>
                                    <td><Strong>{{ $review->user->name }}</Strong></td>
                                    <td>{{ $review->book->title }}</td>
                                    <td><i class="fa-regular fa-star"></i> {{ $review->rating }} </td>
                                    <td>{{ \Carbon\Carbon::parse($review->created_at)->format('d M y') }}</td>
                                    <td>
                                        @if($review->status == 1)
                                        <span class="text-success">Active</span>
                                        @else
                                        <span class="text-danger">Block</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('account.review.edit',$review->id) }}" class="btn btn-primary btn-sm"><i class="fa-regular fa-pen-to-square"></i>
                                        </a>
                                        <a href="#" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </thead>
                    </table>
                    @if ($reviews->isNotEmpty())
                    {{ $reviews->links() }}
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>
@endsection