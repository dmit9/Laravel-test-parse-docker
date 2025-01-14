@extends('layouts.main')

@section('title','Home')
@section('content')
    <h2>Home</h2>
    <a href="{{route('show')}}" class="btn btn-primary">Get Price</a>

    <div id="usersData">
        @if(isset($users) && $users->count() > 0)
            @foreach($users as $user)
                <div>
                    <strong>User Email:</strong> {{ $user->email }}
                </div>
                <div>
                    <ul>
                        <li>Link: {{ $user->link }}</li>
                        <li>Last change at: {{ $user->parsetime }}</li>
                        <li>Price:
                            @foreach ($user->parsedata as $item)
                                {{ $item }}
                            @endforeach
                        </li>
                    </ul>
                </div>
            @endforeach
        @else
            <p>No data available.</p>
        @endif
    </div>

@endsection
@section('scripts')
    <script>
        document.getElementById('getPriceButton').addEventListener('click', function () {
            fetch('{{ route('show') }}', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                }
            })
                .then(response => response.text())
                .then(data => {
                    document.getElementById('usersData').innerHTML = data;
                })
                .catch(error => console.error('Error:', error));
        });
    </script>
@endsection
