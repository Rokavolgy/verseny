<div id="competitionsList"
     class="container d-flex flex-column justify-content-center align-content-center col-md-10 row-gap-3">
    <div class="card">
        <div class="card-header">{{ __('Versenyek') }}</div>

        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            @if($competitions->count() > 0)
                <div class="list-group">
                    @foreach($competitions as $competition)
                        <a href="{{ route('verseny.show', $competition->id) }}"
                           class="list-group-item list-group-item-action"
                           data-id="{{ route('verseny.show', $competition->id)}}">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">{{ $competition->verseny_nev }}</h5>
                                <small>{{ $competition->verseny_ev}}</small>
                            </div>
                            <p class="mb-1">{{ $competition->description }}</p>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="alert alert-info">
                    {{ __('Jelenleg nincs verseny.') }}
                </div>
            @endif

        </div>
    </div>
    @include('verseny.createCompetition')
    @include('verseny.createUser')
</div>
