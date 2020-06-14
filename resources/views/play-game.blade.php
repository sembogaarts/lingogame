@extends('layouts.main')

@include('partials.header')

@section('body')

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

                <div class="lingo-row">
                    @for($i = 0; $i < $wordLength; $i++)
                        @if(isset($input[$i]))
                            <div class="lingo-block valid"><p>{{ $input[$i] }}</p></div>
                        @else
                            <div class="lingo-block"></div>
                        @endif
                    @endfor
                </div>

            </div>
        </div>

    </div>

@endsection
