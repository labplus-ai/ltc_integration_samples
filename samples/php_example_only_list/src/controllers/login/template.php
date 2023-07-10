<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Logowanie - LAB+</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link href="global.css" rel="stylesheet">
    <link href="login.css" rel="stylesheet">
</head>
<body>
<div class="login-container">
    <div class="d-flex justify-content-center mb-4">
        <img class="logo" src="/assets/logo.svg" alt="LAB+">
    </div>
    <h2 class="mb-4">Logowanie do systemu LAB+</h2>
    <form action="" method="POST">
        <div class="mb-3">
            <label for="username" class="form-label">Nazwa użytkownika</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Hasło</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Zaloguj</button>
    </form>
</div>
</body>
</html>
