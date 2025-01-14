@extends('layouts.main')

@section('title','Home')
@section('content')
    <div class="alert alert-info">
        Thank you for registering!
    </div>
    <div>
        Didn't receive the link?
        <form method="post" action="{{route('verification.send')}}">
            @csrf
            <button type="submit" class="btn btn-link ps-0"> Send link</button>
        </form>
    </div>
@endsection
