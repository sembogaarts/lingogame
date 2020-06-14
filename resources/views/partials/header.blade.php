<header class="main-header">
    <div class="container">
        <a href="/">
            <img src="/imgs/logo.png" alt="">
        </a>
        <a href="/">Mijn games</a>
        <a href="/highscores">Highscores</a>
    </div>
</header>

<div class="sub-header">
    <div class="container">
        @if(!\Illuminate\Support\Facades\Auth::user()->username)
            <div class="row">
                <div class="col-md-6">
                    <h1>Je speelt momenteel als gast</h1>
                    <p>Verander hier eenvoudig je naam zodat deze op het scorebord verschijnt.</p>
                </div>
                <div class="col-md-6">
                    <form action="{{ route('saveUsername') }}" method="POST">
                        @csrf
                        <input name="username" required type="text">
                        <button type="submit">Opslaan</button>
                    </form>
                </div>
            </div>
        @else
            <div class="text-center">
                <h1>Je speelt als {{ \Illuminate\Support\Facades\Auth::user()->username }}</h1>
            </div>
        @endif
    </div>
</div>
