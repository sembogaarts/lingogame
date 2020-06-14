@extends('layouts.main')

@include('partials.header')

@section('body')

    <div class="container">

        <form action="{{ route('createGame') }}" method="POST">
            @csrf
            <label for="">Welk niveau wil je spelen?</label>
            <input type="radio" name="word_length" value="5">
            <input type="radio" name="word_length" value="6">
            <input type="radio" name="word_length" value="7">
            <button type="submit">Spelen</button>
        </form>

    </div>

@endsection
