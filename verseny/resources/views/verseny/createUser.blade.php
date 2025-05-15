<div class="card">
        <div class="card-header">{{ __('Új résztvevő hozzáadása') }}</div>
<div class="card-body">
    <form method="POST" id="addParticipantForm" action="{{ "o" }}">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Név</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email cím</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="birthdate" class="form-label">Születési dátum</label>
            <input type="date" class="form-control" id="birthdate" name="birthdate" required>
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Cím</label>
            <input type="text" class="form-control" id="address" name="address" required>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Telefonszám</label>
            <input type="tel" class="form-control" id="phone" name="phone" required>
        </div>
        <button type="submit" class="btn btn-primary">Résztvevő hozzáadása</button>
    </form>
</div>
</div>
