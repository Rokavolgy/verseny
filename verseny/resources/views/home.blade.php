@extends('layouts.app')

@section('content')
    <div class="container align-content-center " id="dashboard">
@include('verseny.list')
    </div>
<div class="container" style="min-height: 400px">
    <div class="container col-md-10">
<div id="languageManagement" >
</div>
</div>
</div>
<div id="modalview">

</div>
<script>
    var userId= null

        $(document).on('submit', '#addCompetitionForm', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: function(response) {
                    //alert('Verseny sikeresen hozzáadva!');
                    fetchCompetitions();
                },
                error: function(response) {
                    alert('Hiba történt a verseny hozzáadása során.' + response.responseJSON.message);
                }
            });
        });

        $(document).on('submit','#removeCompetition', function(e)
        {
            e.preventDefault();
            if(!confirm("Biztosan törölné ezt a versenyt? A fordulók adatai is törlésre kerülnek.")) return;
            $.ajax({
                type: 'GET',
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: function(response) {
                    alert('Verseny törölve.');
                    fetchCompetitions();
                },
                error: function(response) {
                    alert('Hiba történt a verseny törlése során.' + (response.responseJSON.message || ' Nincs információ.'));
                }
            });
        })

        $(document).on('click', '#competitionsList .list-group-item', function(e) {
            e.preventDefault();
            const route = $(this).data('id'); // id = route-data
            fetchCompetitionDetails(route);
            const competitionId = route.split('/').pop();
            fetchLanguageDetails(competitionId)
        });
        //user modal
        $(document).on('click', '.binduser', function(e)
        {
            loadUserModel($(this).data('route'))

        })

        $(document).on('submit','#removeRound', function(e)
        {
            e.preventDefault();
            const formData = new FormData(this);
            formData.append('round_id', $(this).data('round'));
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    //alert('Verseny sikeresen hozzáadva!');
                    fetchCompetitionDetails(document.URL)
                },
                error: function (response) {
                    alert('Hiba történt a forduló eltávolítása során.' + (response.responseJSON.message || ' Nincs információ.'));
                }
            });
        })

        $(document).on('submit', '#addParticipantForm', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            formData.append('round_id', $(this).data('competition'));
                formData.append('submit', e.originalEvent.submitter.value);
                for (entry of formData.entries())
                {
                    console.log(entry)
                }
                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'),
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        //alert('Verseny sikeresen hozzáadva!');
                        fetchCompetitionDetails(document.URL)
                    },
                    error: function (response) {
                        alert('Hiba történt a résztvevő hozzáadása során.' + response.responseJSON.message);
                    }
                });

        });

        $(document).on('submit','#addLanguageForm', function (e)
    {
        e.preventDefault()
        if(e.originalEvent.submitter.value === 'add')
        {
            $.ajax({
                type: 'POST',
                url: '/versenyek/languages/add',
                data: $(this).serialize(),
                success: function (response) {
                    //alert('Verseny sikeresen hozzáadva!');
                    const competitionId = document.URL.split('/').pop();
                    fetchLanguageDetails(competitionId)
                },
                error: function (response) {
                    alert(response.responseJSON.message);
                }
            });
        }
        else
        {
            $.ajax({
                type: 'POST',
                url: '/versenyek/languages/remove',
                data: $(this).serialize(),
                success: function (response) {
                    //alert('Verseny sikeresen hozzáadva!');

                    const competitionId = document.URL.split('/').pop();
                    fetchLanguageDetails(competitionId)
                },
                error: function (response) {
                    alert(response.responseJSON.message);
                }
            });
        }
    })

        //új forduló
        $(document).on('submit', '#addRound', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            formData.append('verseny_id', parseInt($(this).data('competition')))
            formData.append('kor_datum','2004-05-06') //test data
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data:  formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    //alert('Forduló sikeresen hozzáadva!');
                    fetchCompetitionDetails(document.URL)
                },
                error: function(response) {
                    alert('Hiba történt a forduló hozzáadása során.' + response.responseJSON.message);
                }
            });

        });

        function loadUserModel(route)
        {
            $.ajax({
                type: 'POST',
                url: route,
                data: null,
                processData: false,
                contentType: false,
                success: function(response) {
                    if($('#myModal'))
                    {
                        $('#myModal').modal('hide');
                    }
                    $('#modalview').html(response);
                    $('#myModal').modal('show');
                },
                error: function(response) {
                    alert('Hiba történt a verseny törlése során.' + (response.responseJSON.message || ' Nincs információ.'));
                }
            });
        }
    function fetchCompetitionDetails(route) {
        console.log(route)
        $.ajax({
            url: route,
            method: 'GET',
            success: function(data) {
                $('#dashboard').html(data);

                window.history.pushState({id: 100}, "", route);
            },
            error: function(response) {
                alert('Hiba történt a verseny részleteinek lekérdezése során: ' + response.responseJSON.message);
            }
        });
    }

    $(window).bind('beforeunload', function() {
        return '';
    });

    function fetchCompetitions() {
        $.ajax({
            url: `{{ route('verseny.list') }}`,
            method: 'GET',
            success: function(data) {
                $('#dashboard').html(data);
                $('#languageManagement').html("");
            },
            error: function(error) {
                console.error('Hiba történt a lekérdezés során.');
            }
        });
    }

    function fetchParticipants(competitionId) {
        $.ajax({
            url: `/verseny/listParticipants/${competitionId}`,
            method: 'GET',
            success: function(data) {
                $('#participantsList').html(data);

            },
            error: function(error) {
                console.error('Hiba történt a résztvevők lekérdezése során');
            }
        });
    }

    async function showUserDetails(userId){
        $.ajax({
            url: `/felhasznalo/${userId}`,
            method: 'GET',
            success: function(data) {
                return data;
            },
            error: function(error) {
                console.error('Hiba történt a résztvevők lekérdezése során');
            }
        });
    }

    async function fetchUsersJson() {
        $.ajax({
            url: `/verseny/users`,
            method: 'GET',
            success: function(data) {
                return data;
            },
            error: function(error) {
                console.error('Hiba történt a felhasználók lekérdezése során');
            }
        });
    }
    async function fetchLanguageDetails(competitionId)
    {
        $.ajax({
            url: `/versenyek/listLanguages/${competitionId}`,
            method: 'GET',
            success: function(data) {
                $('#languageManagement').html(data);
            },
            error: function(error) {
                alert('Hiba történt a nyelv részleteinek lekérdezése során. ');
            }
        });
    }
</script>
@endsection
