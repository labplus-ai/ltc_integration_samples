<!DOCTYPE html>
<html>
<head>
    <title>Interpretacja wyników</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="global.css">
    <link rel="stylesheet" type="text/css" href="order_details.css">
</head>
<body>
<header class="main-header d-flex align-items-center">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <img src="/assets/logo_full.svg" alt="LAB+" class="header-logo">
            <div>
                <a href="/logout" class="header-nav-item">Wyloguj się</a>
            </div>
        </div>
    </div>
</header>
<div class="container">
    <script type="text/javascript" src="https://cdn.labplus.pl/libs/v1/adapter/1.2.0/adapter.min.js"></script>
    <div class="card" id="labTestCheckerFrameWrapper">
        <a href="/orders" class="mb-2">< Powrót do listy zleceń</a>
        <iframe id="labTestCheckerFrame" width="100%" style="display: none"></iframe>
    </div>
</div>
<footer class="main-footer">
    <div class="container">
        System odbioru wyników LAB+ stworzony do celów prezentacji technologii LabTest Checker. Żadne dane prezentowane
        w systemie nie są prawdziwymi danymi pacjentów.
    </div>
</footer>

<script>
    /**
     * Otwórz LabTest Checker w <iframe>
     */
    const labTestCheckerFrame = document.getElementById('labTestCheckerFrame');

    labTestCheckerFrame.src = "<?php echo $frameURL; ?>";
    labTestCheckerFrame.style.display = "block";

    labplus.adapter(
        labTestCheckerFrame,
        {
            debug: true,
            handleScrolling: true,
        }
    );
</script>
</body>
</html>
