@extends('layouts.main')

@include('partials.header')

@section('body')

    @error('word')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <div class="container">
        <div class="lingo-board">
            <div class="lingo-rows">
                @foreach($rows as $row)
                    <div class="lingo-row">
                        @for($i = 0; $i < $wordLength; $i++)
                            <div class="lingo-block {{ $row['status'][$i] }}"><p>{{ $row['word'][$i] }}</p></div>
                        @endfor
                    </div>
                @endforeach
                @if(!$round->finished_at)
                    <div class="lingo-row">
                        @for($i = 0; $i < $wordLength; $i++)
                            @if(isset($input[$i]))
                                <div class="lingo-block valid"><p>{{ $input[$i] }}</p></div>
                            @else
                                <div class="lingo-block"></div>
                            @endif
                        @endfor
                    </div>
                @endif
            </div>
        </div>
        @if(!$round->finished_at)
            <div>
                <form action="{{ route('attempt') }}" method="POST">
                    @csrf
                    <input type="text" name="word">
                    <button type="submit">Raden</button>
                </form>
            </div>
        @else
            <div>
                <form action="{{ route('round') }}" method="POST">
                    @csrf
                    <button>Nieuwe ronde</button>
                </form>
            </div>
        @endif
    </div>
@endsection
