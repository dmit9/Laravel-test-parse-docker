@extends('layouts.main')

@section('title','Home')
@section('content')
    <h2>register</h2>

    <form action="{{route('user.store')}}" method="post">
        @csrf
        <div class="d-flex flex-column mb-3">
            <label for="email" class="form-label">Email</label>
            <input name="email" type="email" class="form-label @error('email') is-invalid @enderror" id="email" placeholder="enter email" value="{{old('email')}}">
            @error('email')
            <div class="invalid-feedback">{{$message}}</div>
            @enderror
            <label for="link" class="form-label">Url</label>
            <input name="link" type="url" class="form-label @error('email') is-invalid @enderror" id="link"
                   placeholder="enter url like this: https://www.olx.ua/d/obyavlenie/dovgotrivala-orenda-IDVR8mh.html " value="{{old('link')}}">
            @error('link')
            <div class="invalid-feedback">{{$message}}</div>
            @enderror
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="{{route('login')}}" class="ms-3">Already registered?</a>
        </div>
    </form>
@endsection
