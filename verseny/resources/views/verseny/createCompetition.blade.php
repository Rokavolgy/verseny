<div class="card">
    <div class="card-header">{{ __('Verseny hozzáadása') }}</div>
    <div class="card-body">
        <form method="POST" id="addCompetitionForm" action="{{ route('verseny.store') }}">
            @csrf
            <div class="mb-3">
                <label for="verseny_nev" class="form-label">Verseny neve</label>
                <input type="text" class="form-control" id="verseny_nev" name="verseny_nev" required>
            </div>
            <div class="mb-3">
                <label for="verseny_ev" class="form-label">Verseny éve</label>
                <input type="number" class="form-control" id="verseny_ev" name="verseny_ev" required>
            </div>
            <div class="mb-3">
                <label for="verseny_terulet" class="form-label">Verseny helyszín</label>
                <input type="text" class="form-control" id="verseny_terulet" name="verseny_terulet" required>
            </div>
            <div class="mb-3">
                <label for="verseny_leiras" class="form-label">Leírás</label>
                <textarea class="form-control" id="verseny_leiras" name="verseny_leiras" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Verseny hozzáadása</button>
        </form>
    </div>
</div>
