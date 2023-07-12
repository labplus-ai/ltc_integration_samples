<?php
session_start();
require_once('../../services/db.php');

if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
    header('Location: login');
    exit();
}

// Fikcyjna baza danych na potrzeby przykładu
$db = new MockedDatabase();

$orderId = getOrderNumber();
$orderDetails = $db->getOrderDetails($orderId);

$LTCBannerUrl = getLTCBannerURL($orderDetails);

// Pokaż ramkę z LabTest Checker dla zleceń które miały już wygenerowany token
if ($orderDetails['ltcToken'] !== null) {
    $frameURL = getenv('LTC_API_URL') . "/interview/" . getenv('LTC_CLIENT_HASH') . "?token=" . $orderDetails['ltcToken'];
}

/**
 * TODO
 * Należy upewnić się, że numer zlecenia istnieje w adresie, a użytkownik sesyjny ma prawo do jego odczytu, aby uniknąć możliwości odczytania cudzego numeru zlecenia
 */
function getOrderNumber()
{
    return $_GET['id'];
}

/**
 * Funkcja pobierająca adres URL do uruchomienia banera LabTest Chacker
 *
 * Zwrócony adres należy osadzić jako atrybut src w elemencie <iframe> na stronie.
 * Zobacz przykład wykorzystania w pliku template.php
 *
 * Warunki wyświetlenia banera (mogą być dostosowane do wymagań biznesowych):
 * - dla zleceń, w których była już przeprowadzana analiza, nie pokazujemy banera. W zamian ładujemy ramkę z uruchomionym LabTest Checkerem.
 * - dla starych (>30 dni) zleceń baner nie jest prezentowany, ponieważ analiza starych wyników jest obarczona dużą niepewnością.
 * - dla zleceń, w których nie interpretujemy żadnego z badań baner nie jest pokazywany ze względów UXowych.
 * - dla zleceń oczekujących na komplet wyników jest wyświetlany inny baner (informujący o usłudze, ale bez CTA)
 *
 * @param $orderDetails - obiekt zawierający szczegóły zlecenia. Należy dostosować strukturę obiektu do systemu Partnera
 */
function getLTCBannerURL($orderDetails)
{
    // Fikcyjna baza danych na potrzeby przykładu
    $db = new MockedDatabase();

    // Nie wyświetlaj banera dla zleceń, dla których jest już wygenerowany token (w zamian pokaż uruchomioną ramkę z LabTest Checkerem)
    if ($orderDetails['ltcToken'] !== null) return null;

    // Nie wyświetlaj banera dla zleceń starszych niż 30 dni
    $orderDate = new DateTime($orderDetails['orderDate']);
    $currentDate = new DateTime();
    if ($currentDate->diff($orderDate)->days > 30 && $orderDate < $currentDate) return null;

    // Sprawdź, czy w zleceniu jest przynajmniej jedno badanie możliwe do interpretacji
    $processableIds = $db->getProcessableExaminationsIds(); // lista badań dostarczona przez Labplus
    $hasProcessableExamination = false;
    foreach ($processableIds as $processableId) {
        foreach ($orderDetails['examinations'] as $examination) {
            if ($examination['examinationId'] === $processableId) $hasProcessableExamination = true;
        }
    }

    // Nie wyświetlaj opcji interpretacji dla zleceń, w których nie ma żadnych badań możliwych do interpretacji
    if (!$hasProcessableExamination) return null;

    // Wyświetl różny baner w zależności od tego, czy w zleceniu sa już wszystkie wyniki badań
    $bannerUrl = $orderDetails['completed'] ? getenv('LTC_BANNER_URL') : getenv('LTC_BANNER_URL') . '/incomplete';

    // Dołącz do adresu hash pozwalający na unikalne zliczanie wyświetleń.
    // Hash nie zawiera danych osobowych pacjenta, nie jest wykorzystywany w innych miejscach więc nie umożliwia na śledzenie aktywności pacjenta
    return $bannerUrl . "?hash=" . hash('sha256', $orderDetails['orderId']);
}

include "template.php"
?>
