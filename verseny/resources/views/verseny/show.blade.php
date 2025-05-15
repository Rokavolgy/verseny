<div class="container" id="app">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div id="competitionDetails" class="mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">{{ $competition->verseny_nev }}</h4>
                        <span class="badge bg-light text-dark">{{ __('Fordulók:') }} {{ count($rounds) }}</span>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-4"><strong>{{ __('Év:') }}</strong> {{ $competition->verseny_ev }}</div>
                            <div class="col-md-8"><strong>{{ __('Helyszín:') }}</strong> {{ $competition->verseny_terulet }}</div>
                        </div>
                        <div class="mb-3">
                            <strong>{{ __('Leírás:') }}</strong>
                            <p>{{ $competition->verseny_leiras }}</p>
                        </div>
                        <div class="d-flex justify-content-between mt-3">
                            <form method="POST" id="addRound" action="{{ route('verseny.addRound') }}" data-competition="{{ $competition->id }}">
                                @csrf
                                <button type="submit" class="btn btn-success">
                                    {{ __('Új forduló létrehozása') }}
                                </button>
                            </form>
                            <form method="POST" id="removeCompetition" action="{{ route('verseny.delete', $competition->id) }}" data-competition="{{ $competition->id }}">
                                @csrf
                                <button type="submit" class="btn btn-danger">
                                    {{ __('Verseny törlése') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div id="roundDetails">
                @if($rounds->isNotEmpty())
                <div class="accordion" id="roundsAccordion">
                    @foreach($rounds as $round)
                    <div class="accordion-item mb-3 shadow-sm">
                        <div class="accordion-header" id="heading{{ $round->id }}">
                            <div class="accordion-button">
                                <div class="d-flex justify-content-between w-100 align-items-center">
                                    <span><strong>{{ $loop->index + 1 }}. {{ __('forduló') }}</strong></span>
                                    <span class="badge bg-info text-white ms-2 me-4">{{ count($round->users) }} {{ __('résztvevő') }}</span>
                                </div>
                            </div>
                        </div>
                        <div id="collapse{{ $round->id }}" class="show" aria-labelledby="heading{{ $round->id }}">
                            <div class="accordion-body">
                                <div class="card mb-3">
                                    <div class="card-header d-flex justify-content-between align-items-center bg-light">
                                        <h5 class="mb-0">{{ __('Résztvevők') }}</h5>
                                        <form method="POST" id="removeRound" action="{{ route('verseny.removeRound') }}" data-round="{{ $round->id }}" class="m-0">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                {{ __('Forduló törlése') }}
                                            </button>
                                        </form>
                                    </div>
                                    <div class="card-body">
                                        @if($round->users->isNotEmpty())
                                        <div class="d-flex flex-wrap gap-2">
                                            @foreach($round->users as $user)
                                            <a class="binduser btn badge bg-secondary text-white p-2" data-route="{{route('users.showDetails',$user->id)}}">{{ $user->name }}</a>
                                            @endforeach
                                        </div>
                                        @else
                                        <div class="alert alert-info mb-0">{{ __('Nincs résztvevő a fordulóban.') }}</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">{{ __('Résztvevők kezelése') }}</h5>
                                    </div>
                                    <div class="card-body">
                                        <form method="POST" id="addParticipantForm" data-competition="{{ $round->id }}" action="{{ route('verseny.addRemoveParticipant') }}" class="row g-3 align-items-end">
                                            @csrf
                                            <div class="col-md-8">
                                                <label for="participant" class="form-label">{{ __('Válasszon felhasználót:') }}</label>
                                                <select id="participant" name="user_id" class="form-select" required>
                                                    <option value="" disabled selected>-</option>
                                                    @foreach($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="d-flex gap-2">
                                                    <button type="submit" name="input" value="add" class="btn btn-success flex-grow-1">
                                                        {{ __('Hozzáadás') }}
                                                    </button>
                                                    <button type="submit" name="input" value="remove" class="btn btn-danger flex-grow-1">
                                                        {{ __('Eltávolítás') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="alert alert-warning">
                    {{ __('Nincs hozzárendelve egy forduló sem a versenyhez.') }}
                </div>
                @endif
            </div>


        </div>

    </div>
</div>

