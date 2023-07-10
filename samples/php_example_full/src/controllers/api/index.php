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

session_start();
require_once('../../services/db.php');
require_once('../../services/labplus.php');

if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
    header('Location: login');
    exit();
}

$db = new MockedDatabase();
$labplusService = new LabplusService();

$orderId = getOrderNumber();
$orderDetails = $db->getOrderDetails($orderId);
$token = $orderDetails['ltcToken'];

// Wygeneruj nowy token, tylko jeśli dla zlecenia nie został jeszcze wygenerowany
if ($token === null) {
    // Odczytaj wyniki pacjenta dla danego zlecenia
    $examinations = $db->getOrderDetails($orderId)['examinations'];

    // Uzyskaj token z API Labplus
    $token = $labplusService->generateToken($examinations, getenv('LTC_APP_KEY'), getenv('LTC_API_URL'));

    // Przypisz token do zlecenia
    $db->saveTokenToOrder($orderId, $token);
}

$frameURL = getenv('LTC_API_URL') . "/interview/" . getenv('LTC_CLIENT_HASH') . "?token=" . $token;

// Zwróć wygenerowany adres do uruchomienia LabTest Checker
echo json_encode(array("url" => $frameURL));

/**
 * TODO
 * Należy upewnić się, że numer zlecenia istnieje w adresie, a użytkownik sesyjny ma prawo do jego odczytu, aby uniknąć możliwości odczytania cudzego numeru zlecenia
 */
function getOrderNumber()
{
    return $_GET['orderNumber'];
}

?>
