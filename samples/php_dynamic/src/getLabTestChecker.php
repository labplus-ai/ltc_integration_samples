<?php
/**
 * Przykład API służącego do wygenerowania adresu umożliwiającego uruchomienie LabTest Checkera
 *
 * Poniższy przykład odczytuje numer zlecenia z adresu url, a następnie symuluje odczyt wyników badań dla tego zlecenia z bazy.
 * Odczytane wyniki są wysyłane do API Labplus, w celu uzyskania tokenu umożliwiającego uruchomienie LabTest Checkera
 * Po uzyskaniu tokena, zwracany jest adres umożliwiający uruchomienie LabTest Checkera w formie <iframe>
 *
 * Uwaga!
 * Poniższy kod skupia się na procesie komunikacji z API Labplus, należy go dostosować do systemu, w którym ma być osadzony.
 * W szczególności należy uzupełnić go o autoryzację, odpowiednie zabezpieczenia kodu, obsługę błędów itp.
 */

// Poniższe 3 zmienne będą dostarczone przez Labplus na etapie integracji
$LTC_APP_KEY = "aGwowH3TCQfL8GN3bnomvdZnKkB7cCUge2QNR5ynJ36XJ6m"; // secret umożliwiający dostęp do API Labplus - różny dla środowiska testowego i produkcyjnego
$LTC_API_URL = "https://adapter.abcdefgh.pl"; // adres API Labplus - różny dla środowiska testowego i produkcyjnego
$LTC_CLIENT_HASH = "dev"; // ID klienta w API Labplus - różny dla środowiska testowego i produkcyjnego

// Odczytaj numer zlecenia z adresu i sprawdź, czy został już do niego wygenerowany token
$orderNumber = getOrderNumber();
$token = getTokenForOrderNumerIfExist($orderNumber);

if ($token === null) {
    // Odczytaj wyniki pacjenta dla danego zlecenia
    $examinations = getExaminationsResultsForOrderNumer($orderNumber);

    // Uzyskaj token z API Labplus
    $token = generateToken($examinations, $LTC_APP_KEY, $LTC_API_URL);

    // todo - zapisz token w bazie i przypisz go do zlecenia
}

$iframeUrl = $LTC_API_URL . "/interview/" . $LTC_CLIENT_HASH . "?token=" . $token;

// Zwróć wygenerowany adres do uruchomienia LabTest Checker
echo json_encode(array("url" => $iframeUrl));

/**
 * TODO
 * Należy upewnić się, że numer zlecenia istnieje w adresie, a użytkownik sesyjny ma prawo do jego odczytu, aby uniknąć możliwości odczytania cudzego numeru zlecenia
 */
function getOrderNumber()
{
    return $_GET['numerZlecenia'];
}

/**
 * TODO
 * Należy sprawdzić w bazie danych, czy do danego numeru zlecenia został już wygenerowany token
 */
function getTokenForOrderNumerIfExist($orderNumber)
{
    return null; // zwrócić token, jeśli był już wygenerowany
}

/**
 * TODO
 * Należy odczytać wyniki badań dla numeru zlecenia i zwrócić je w
 */
function getExaminationsResultsForOrderNumer($orderNumber)
{
    return array(
        'examinations' => array( // Tablica wyników badań
            array(
                'examinationName' => 'TSH', // Nazwa badania, string
                'examinationId' => 'TSH', // ID badania, string lub number
                'examinationParams' => array( // tablica parametrów badania
                    array(
                        'paramId' => 1, // ID parametru badania, string lub number
                        'paramValue' => 6.22, // wartość wyniku dla parametru, string lub number
                        'paramUnit' => 'mIU/l', // jednostka parametru, string
                        'paramNormHigh' => 5, // norma górna parametru, number lub null
                        'paramNormLow' => 0.32, // norma górna parametru, number lub null
                        'paramNormValue' => null, // pole nieużywane, null
                        'paramDate' => '2023-08-25 00:00:00' // data wykonania oznaczenia, string w odpowiendim formacie
                    )
                )
            ),
            array(
                'examinationName' => 'Morfologia',
                'examinationId' => 'Morfo',
                'examinationParams' => array(
                    array(
                        'paramId' => 24,
                        'paramValue' => 9.34,
                        'paramUnit' => 'tys/µl',
                        'paramNormHigh' => 9.1,
                        'paramNormLow' => 4.2,
                        'paramNormValue' => null,
                        'paramDate' => '2023-08-25 00:00:00'
                    ),
                    array(
                        'paramId' => 25,
                        'paramValue' => 6.01,
                        'paramUnit' => 'g/dl',
                        'paramNormHigh' => 6.08,
                        'paramNormLow' => 4.63,
                        'paramNormValue' => null,
                        'paramDate' => '2023-08-25 00:00:00'
                    ),
                    array(
                        'paramId' => 26,
                        'paramValue' => 15.52,
                        'paramUnit' => 'g/dl',
                        'paramNormHigh' => 17.5,
                        'paramNormLow' => 13.7,
                        'paramNormValue' => null,
                        'paramDate' => '2023-08-25 00:00:00'
                    )
                )
            )
        )
    );
}

function generateToken($examinations, $appKey, $apiUrl)
{
    $jsonData = json_encode($examinations);

    // Można użyć dowolnego klienta HTTP
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $apiUrl . "/v1/generate-interview");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($jsonData),
        'app-key: ' . $appKey
    ));
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonData);
    $response = curl_exec($curl);
    $responseCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    if ($response === false) {
        throw new Exception('Do złapania i obsłużenia, brak odpowiedzi');
    } elseif ($responseCode !== 200) {
        throw new Exception('Do złapania i obsłużenia, kod HTTP: ' . $responseCode);
    } else {
        $responseData = json_decode($response, true);

        return $responseData['data']['interviewToken'];
    }
}

?>
