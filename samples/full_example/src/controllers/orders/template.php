<!DOCTYPE html>
<html>
<head>
    <title>Zamówienia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="global.css">
    <link rel="stylesheet" type="text/css" href="orders.css">
</head>
<body>
<header class="main-header d-flex align-items-center">
    <div class="container ">
        <div class="d-flex justify-content-between align-items-center">
            <img src="/assets/logo_full.svg" alt="LAB+" class="header-logo">
            <div>
                <a href="/logout" class="header-nav-item">Wyloguj się</a>
            </div>
        </div>
    </div>
</header>
<div class="container">
    <div class="card">
        <h1>Lista Twoich zleceń</h1>

        <ul class="order-list">
            <li class="order-item">
                <div class="order-details">
                    <div class="order-title">Zlecenie #001</div>
                    <div class="order-details">
                        Data zlecenia: 2025-06-13<br>
                        Badanie: OB (Odczyn Biernackiego)<br>
                        Status: Oczekujące<br><br>
                        Komentarz: <br>To jest przykład zlecenia, w którym jeszcze nie ma dostępnych wszystkich wyników badań pacjenta. W takim przypadku interpretacja nie będzie możliwa.
                    </div>
                </div>
                <a class="btn btn-primary btn-block" href="/orderDetails?id=001">Zobacz wyniki</a>
            </li>
            <li class="order-item">
                <div class="order-details">
                    <div class="order-title">Zlecenie #002</div>
                    <div class="order-details">
                        Data zlecenia: 2025-06-13<br>
                        Badanie: TSH (Tyreotropina), Testosteron<br>
                        Status: Zakończone<br><br>
                        Komentarz: <br>To jest przykład zlecenia, w którym interpretacja jest możliwa - przejdź do szczegółów zlecenia aby zobaczyć sposób integracji.
                    </div>
                </div>
                <a class="btn btn-primary btn-block" href="/orderDetails?id=002">Zobacz wyniki</a>
            </li>
            <li class="order-item">
                <div class="order-details">
                    <div class="order-title">Zlecenie #003</div>
                    <div class="order-details">
                        Data zlecenia: 2025-06-13<br>
                        Badanie: TSH (Tyreotropina), Testosteron<br>
                        Status: Zakończone<br><br>
                        Komentarz: <br>To jest przykład zlecenia, w którym interpretacja była już przeprowadzona przez użytkownika. Użytkownik ma możliwość powrotu do przeprowadzonej interpretacji.
                    </div>
                </div>
                <a class="btn btn-primary btn-block" href="/orderDetails?id=003">Zobacz wyniki</a>
            </li>
            <li class="order-item">
                <div class="order-details">
                    <div class="order-title">Zlecenie #004</div>
                    <div class="order-details">
                        Data zlecenia: 2025-06-13<br>
                        Badanie: Testosteron<br>
                        Status: Zakończone<br><br>
                        Komentarz: <br>To jest przykład zlecenia, w którym interpretacja nie jest możliwa, ponieważ w zleceniu nie ma żadnego badania które jest interpretowane przez LabTest Checker.
                    </div>
                </div>
                <a class="btn btn-primary btn-block" href="/orderDetails?id=004">Zobacz wyniki</a>
            </li>
            <li class="order-item">
                <div class="order-details">
                    <div class="order-title">Zlecenie #005</div>
                    <div class="order-details">
                        Data zlecenia: 2021-06-13<br>
                        Badanie: TSH<br>
                        Status: Zakończone<br><br>
                        Komentarz: <br>To jest przykład zlecenia, w którym interpretacja nie jest możliwa, ponieważ zlecenie jest zbyt stare (ponad 30 dni)
                    </div>
                </div>
                <a class="btn btn-primary btn-block" href="/orderDetails?id=005">Zobacz wyniki</a>
            </li>
        </ul>
    </div>
</div>
<footer class="main-footer">
    <div class="container">
        System odbioru wyników LAB+ stworzony do celów prezentacji technologii LabTest Checker. Żadne dane prezentowane w systemie nie są prawdziwymi danymi pacjentów.
    </div>
</footer>
</body>
</html>
