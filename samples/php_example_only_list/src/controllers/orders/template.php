<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Panel odbioru wyników badań laboratoryjnych</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
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
            <?php foreach ($ordersList as $order) : ?>
                <li class="order-item">
                    <div class="order-details">
                        <div class="order-title">Zlecenie #<?php echo $order['id'] ?></div>
                        <div class="order-details">
                            Data zlecenia: <?php echo $order['orderDate'] ?><br>
                            Badanie: <?php foreach ($order['examinations'] as $examination) {
                                echo $examination['examinationName'] . ', ';
                            } ?><br>
                            Status: <?php echo($order['completed'] ? 'Zakończone' : 'Oczekujące') ?><br><br>
                            Komentarz: <br> <?php echo $order['comment'] ?>
                        </div>
                    </div>
                    <?php if (isInterpretationPossible($order)): ?>
                        <a class="btn btn-primary btn-block" href="/labtestchecker?id=<?php echo $order['id'] ?>">
                            <?php echo ($order['ltcToken'] === null ? 'Rozpocznij e-analizę' : 'Zobacz swoją e-nalizę'); ?>
                        </a>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
<footer class="main-footer">
    <div class="container">
        System odbioru wyników LAB+ stworzony do celów prezentacji technologii LabTest Checker. Żadne dane prezentowane
        w systemie nie są prawdziwymi danymi pacjentów.
    </div>
</footer>
</body>
</html>
