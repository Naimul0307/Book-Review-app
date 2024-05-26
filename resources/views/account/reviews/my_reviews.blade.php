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
                        My Reviews
                    </div>
                    <div class="card-body pb-0">
                        <div class="d-flex justify-content-end">
                                <form action="" method="get">
                                    <div class="d-flex">
                                    <input type="text" class="form-control" value="{{ Request::get('keyword') }}" name="keyword" placeholder="Keyword">
                                    <button type="submit" class="btn btn-primary"> Search </button>
                                    <a href="{{ route('account.myReviews') }}" class="btn btn-secondary ms-2">Clear</a>
                                    </div>
                                </form>
                        </div>
                    <div class="card-body pb-0">
                        <table class="table  table-striped mt-3">
                            <thead class="table-dark">
                                <tr>
                                    <th>Book</th>
                                    <th>Review</th>
                                    <th>Rating</th>
                                    <th>Status</th>
                                    <th width="100">Action</th>
                                </tr>
                                <tbody>
                                    @if($reviews->isNotEmpty())
                                    @foreach ($reviews as  $review)
                                    <tr>
                                        <td>{{ $review->book->title }}</td>
                                        <td>{{ $review->review }}</td>
                                        <td>{{ $review->rating }}</td>
                                        <td>
                                            @if ($review->status == 1)
                                            <span class="text-success">Active</span>
                                            @else
                                            <span class="text-dainge">Block</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="edit-review.html" class="btn btn-primary btn-sm"><i class="fa-regular fa-pen-to-square"></i>
                                            </a>
                                            <a href="#" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="5" style="background-color: crimson; color: #f1f1f1;text-align:center;font-size:20px">
                                            <strong>
                                                Reviews Not Found
                                            </strong>
                                        </td>
                                    </tr>
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
</section>
@endsection
