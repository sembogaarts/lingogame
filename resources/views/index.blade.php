@extends('layouts.main')

@include('partials.header')

@section('body')

    <div class="container">

        @if($active_game)
            <div class="game active">
                <h1>Je hebt nog een actief spel!</h1>
                <a href="/play"><button>Verder spelen</button></a>
            </div>
        @else
            <div class="game active">
                <h1>Geen actief spel</h1>
                <a href="/new-game" dusk="newGame"><button>Nieuw spel</button></a>
            </div>
        @endif

        @foreach($games as $game)
            <div class="game">
                <h1>{{ $game->score }} punten</h1>
                @foreach($game->rounds as $round)
                    @if($round->success)
                        <div class="round">
                            <div class="lingo-row">
                                @for($i = 0; $i < $game->word_length; $i++)
                                    <div class="lingo-block valid"><p>{{ $round->word[$i] }}</p></div>
                                @endfor
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @endforeach

    </div>

    </div>

@endsection
