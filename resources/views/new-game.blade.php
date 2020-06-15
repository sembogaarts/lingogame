@extends('layouts.main')

@include('partials.header')

@section('body')


    <div class="container">

        <form action="{{ route('createGame') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="exampleInputEmail1">Welk niveau wil je spelen?</label>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="length" id="easy" value="5" checked>
                    <label class="form-check-label" for="easy">
                        5 letters
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="length" id="medium" value="6">
                    <label class="form-check-label" for="medium">
                        6 letters
                    </label>
                </div>
                <div class="form-check disabled">
                    <input class="form-check-input" type="radio" name="length" id="hard" value="7">
                    <label class="form-check-label" for="hard">
                        7 letters
                    </label>
                </div>
            </div>
            <button type="submit">Spelen</button>
        </form>

    </div>

@endsection
