@extends('layouts.user')

@section('title', 'Give Feedback')

@section('contents')
    <div class="container">
        <h4>Give Feedback</h4>

        <form action="{{ route('feedback.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="order_item_id" value="{{ $orderItemId }}">
            <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Images:</strong>
                <input type="file" name="images[]" class="form-control" multiple accept="image/*">
            </div>
            <div class="form-group">
                <label for="comment">Comment</label>
                <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit Feedback</button>
        </form>
    </div>
@endsection
