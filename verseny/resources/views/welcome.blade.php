<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regisztráció</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite('resources/css/style.css')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</head>
<body>
   <!--<div class="container mt-5 max600px">
        <h2 class="text-center mb-4">Regisztráció</h2>
        <form action="/register" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Teljes név</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Teljes név" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email cím</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Email cím" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Regisztráció</button>
        </form>
    </div> -->

    <div class="container mt-5 max600px">
        <h2 class="text-center mb-4">Belépés</h2>
        <form action="/login" method="POST">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email cím</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Email cím" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Jelszó</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Jelszó" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Belépés</button>
        </form>
    </div>


</body>
</html>
