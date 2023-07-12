<!DOCTYPE html>
<html>
<head>
    <title>Szczegóły zamówienia</title>
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
    <div class="card">
        <a href="/orders" class="mb-2">< Powrót do listy zleceń</a>
        <div class="comment">
            <div class="fw-bold">Komentarz do zlecenia #<?php echo $orderId ?>:</div>
            <div class="mt-1"><?php echo $orderDetails['comment'] ?></div>
        </div>

        <?php if ($LTCBannerUrl !== null) : ?>
            <div class="banner-wrapper">
                <iframe src="<?php echo $LTCBannerUrl ?>"
                        id="ltc-banner-iframe" width="100%" height="170px"></iframe>
            </div>
        <?php endif; ?>

        <table class="mt-4">
            <thead>
            <tr>
                <th>Nazwa badania</th>
                <th>Wynik</th>
                <th class="d-none d-sm-table-cell">Jednostka</th>
                <th>Norma</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($orderDetails['examinations'] as $examination) : ?>
                <?php foreach ($examination['examinationParams'] as $param) : ?>
                    <tr>
                        <td><?php echo $param['paramName'] ?></td>
                        <td><?php echo $param['paramValue'] ?></td>
                        <td class="d-none d-sm-table-cell"><?php echo $param['paramUnit'] ?></td>
                        <td><?php echo $param['paramNormLow'] ?> - <?php echo $param['paramNormHigh'] ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>


    <script type="text/javascript" src="https://cdn.labplus.pl/libs/v1/adapter/1.2.0/adapter.min.js"></script>
    <script>
        /**
         * Otwórz LabTest Checker w <iframe>
         */
        function openLabTestChecker(url) {
            const labTestCheckerFrame = document.getElementById('labTestCheckerFrame');
            const labTestCheckerFrameWrapper = document.getElementById('labTestCheckerFrameWrapper');

            labTestCheckerFrameWrapper.style.display = "block";

            labTestCheckerFrame.src = url;

            labplus.adapter(
                document.getElementById("labTestCheckerFrame"),
                {
                    debug: true,
                    handleScrolling: true,
                }
            );

        }
    </script>
    <?php if (isset($frameURL)): ?>
        <script>
            /**
             * Otwórz LabTest Checker automatycznie, jeśli do zlecenia jest już przypisany token
             */
            window.onload = function () {
                openLabTestChecker("<?php echo $frameURL ?>");
            }
        </script>
    <?php endif; ?>
    <script>
        /**
         * Nasłuchuj na event kliknięcia w baner, następnie wygeneruj token (korzystając z AJAX API) i otwórz LabTest Checker
         */
        window.addEventListener('message', function (event) {
            let msg = {};

            try {
                msg = JSON.parse(event.data);
            } catch (e) {
                return;
            }

            if (msg.event === 'ltc_open') {
                /**
                 * Poniższy kod inicjuje LabTest Checker korzystając z ajax-api.
                 * Jeśli Twój system wymaga odświeżenia strony w celu załadowania LabTest Checkera, możesz pominąć poniższy kod i przeprowadzić przekierowanie na odpowiedni adres
                 */
                const labTestCheckerFrameWrapper = document.getElementById('labTestCheckerFrameWrapper');
                const ltcLoader = document.getElementById('ltcLoader');

                // Do not re-open frame twice
                if (labTestCheckerFrameWrapper.style.display === "block") return;

                labTestCheckerFrameWrapper.style.display = "block";
                ltcLoader.style.display = "flex";
                labTestCheckerFrameWrapper.scrollIntoView({behavior: 'smooth'});

                fetch('/api?orderNumber=<?php echo $orderId ?>')
                    .then(response => response.json())
                    .then(res => {
                        ltcLoader.style.display = "none";
                        openLabTestChecker(res.url);
                    })
            }
        }, false);
    </script>
    <div class="card" id="labTestCheckerFrameWrapper" style="display: none;">
        <div id="ltcLoader" style="display: none">
            <i class="fa-solid fa-fan fa-spin"></i>
            <div>Trwa ładowanie, proszę czekać</div>
        </div>
        <iframe id="labTestCheckerFrame" width="100%"></iframe>
    </div>
    <div class="card">
        <h1>Dane zlecenia</h1>
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div>
                    <h5 class="card-title">Dane pacjenta:</h5>
                    <p class="card-text">
                        Imię: <span id="patientFirstName">Kapibara</span><br>
                        Nazwisko: <span id="patientLastName">Testociara</span><br>
                        PESEL: <span id="patientPesel">12345678901</span><br>
                        Adres: <span id="patientAddress">ul. Testerska 1, 00-000 Mokronos Dolny</span>
                    </p>
                </div>
                <div>
                    <h5 class="card-title">Informacje o punkcie pobrań:</h5>
                    <p class="card-text">
                        <span id="collectionPointDetails">Punkt pobrań nr 1, przy ul. Przykładowej 2, 00-001 Warszawa</span>
                    </p>
                </div>
            </div>
        </div>
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
