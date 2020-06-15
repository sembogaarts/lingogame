@extends('layouts.main')

@include('partials.header')

@section('body')

    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <h1>Top 5 letters</h1>
                <ul>
                    @foreach($easy as $row)
                        <li>{{ $row->user->username ? $row->user->username : 'Gast' }} - {{ $row->score }} punten</li>
                    @endforeach
                </ul>
            </div>
            <div class="col-sm-4">
                <h1>Top 6 letters</h1>
                <ul>
                    @foreach($medium as $row)
                        <li>{{ $row->user->username ? $row->user->username : 'Gast' }} - {{ $row->score }} punten</li>
                    @endforeach
                </ul>
            </div>
            <div class="col-sm-4">
                <h1>Top 7 letters</h1>
                <ul>
                    @foreach($hard as $row)
                        <li>{{ $row->user->username ? $row->user->username : 'Gast' }} - {{ $row->score }} punten</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

@endsection
