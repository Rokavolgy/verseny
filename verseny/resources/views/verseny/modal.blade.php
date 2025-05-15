<div class="modal" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Versenyzői adatok ({{$user->name}})</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="viewUserData">
                    <p>Név: {{$user->name}}</p>
                    <p>Email-cím: {{$user->email}}</p>
                    <p>Születési dátum: {{$user->birthdate}}</p>
                    <p>Lakcím: {{$user->address}}</p>
                    <p>Telefonszám: {{$user->phone}}</p>
                    <button type="button" class="btn btn-primary" onclick="toggleEditMode()">Szerkesztés</button>
                </div>

                <div id="editUserData" style="display:none;">
                    <form id="userEditForm">
                        @csrf
                        <input type="hidden" name="id" value="{{$user->id}}">
                        <div class="mb-3">
                            <label for="editName" class="form-label">Név</label>
                            <input type="text" class="form-control" id="editName" name="name" value="{{$user->name}}" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email-cím</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{$user->email}}" required>
                        </div>
                        <div class="mb-3">
                            <label for="birth" class="form-label">Születési dátum</label>
                            <input type="date" class="form-control" id="birth" name="birthdate" value="{{$user->birthdate}}">
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Lakcím</label>
                            <input type="text" class="form-control" id="address" name="address" value="{{$user->address}}">
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Telefonszám</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{$user->phone}}">
                        </div>
                        <button type="button" class="btn btn-success" onclick="saveUserData()">Mentés</button>
                        <button type="button" class="btn btn-primary" onclick="deleteUser()">Felhasználó törlése</button>
                        <button type="button" class="btn btn-secondary" onclick="toggleEditMode()">Mégse</button>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Bezárás</button>
            </div>
        </div>
    </div>
</div>

<script>
    function deleteUser()
    {
        confirm('Biztosan törli a felhasználót?');
        const formData = new FormData(document.getElementById('userEditForm'));
        $.ajax({
            url: `/felhasznalo/delete`,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#myModal').modal('hide')
                fetchCompetitionDetails(document.URL)
            },
            error: function(error) {
                //console.error('Hiba történt az adatok mentése során', error);
                alert('Hiba történt az adatok mentése során: ' + error.responseJSON?.message || 'Ismeretlen hiba');
            }
        });
    }


    function toggleEditMode() {
        const viewMode = document.getElementById('viewUserData');
        const editMode = document.getElementById('editUserData');

        if (viewMode.style.display === 'none') {
            viewMode.style.display = 'block';
            editMode.style.display = 'none';
        } else {
            viewMode.style.display = 'none';
            editMode.style.display = 'block';
        }
    }

    function saveUserData() {
        const formData = new FormData(document.getElementById('userEditForm'));

        $.ajax({
            url: `/felhasznalo/update`,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                loadUserModel('/felhasznalo/' + formData.get('id'));

            },
            error: function(error) {
                //console.error('Hiba történt az adatok mentése során', error);
                alert('Hiba történt az adatok mentése során: ' + error.responseJSON?.message || 'Ismeretlen hiba');
            }
        });
    }
</script>
