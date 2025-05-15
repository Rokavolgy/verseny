<div class="card">
    <div class="card-header bg-primary text-white" >Nyelvek kezelése a {{$competition->verseny_nev}} versenyhez</div>
    <div class="card-body">
        @if(isset($languagesPair) && $languagesPair->isNotEmpty())
            <p>Jelenleg szereplő nyelvek:
            <span>{{$languagesPair->pluck('name')->implode(', ') }}</span>
            </p>
        @else
            <p>Nincs nyelv hozzárendelve a versenyhez</p>
        @endif


        <form id="addLanguageForm">
            @csrf
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="language" class="form-label">Válasszon nyelvet:</label>
                    <input type="hidden" name="verseny_id" value="{{$competition->id}}">
                    <select id="language" name="language_id" class="form-select" required>
                        <option value="" disabled selected>-</option>
                        @if(isset($languages) && $languages->isNotEmpty())
                            @foreach($languages as $language)
                                <option value="{{ $language->id }}">{{ $language->name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="col-md-6 d-flex align-items-end gap-2">
                    <button value="add" class="btn btn-primary" id="addLanguage">Hozzáadás</button>
                    <button value="remove" class="btn btn-danger" id="removeLanguage">Eltávolítás</button>
                </div>
            </div>

        </form>
    </div>
</div>
