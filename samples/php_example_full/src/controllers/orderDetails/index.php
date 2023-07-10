<?php
session_start();
require_once('../../services/db.php');

if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
    header('Location: login');
    exit();
}

$db = new MockedDatabase();
$orderId = isset($_GET['id']) ? $_GET['id'] : null;
$orderDetails = $db->getOrderDetails($orderId);

$LTCBannerUrl = getLTCBannerURL($orderDetails);

// Pokaż ramkę z LabTest Checker dla zleceń które miały już wygenerowany token
if ($orderDetails['ltcToken'] !== null) {
    $frameURL = getenv('LTC_API_URL') . "/interview/" . getenv('LTC_CLIENT_HASH') . "?token=" . $orderDetails['ltcToken'];
}


function getLTCBannerURL($orderDetails)
{
    $db = new MockedDatabase();

    // Nie wyświetlaj banera dla zleceń, dla których jest już wygenerowany token
    if ($orderDetails['ltcToken'] !== null) return null;

    // Nie wyświetlaj banera dla zleceń starszych niż 30 dni
    $orderDate = new DateTime($orderDetails['orderDate']);
    $currentDate = new DateTime();
    if ($currentDate->diff($orderDate)->days > 30 && $orderDate < $currentDate) return null;

    // Sprawdź, czy w zleceniu jest przynajmniej jedno badanie możliwe do interpretacji
    $processableIds = $db->getProcessableExaminationsIds();
    $hasProcessableExamination = false;
    foreach ($processableIds as $processableId) {
        foreach ($orderDetails['examinations'] as $examination) {
            if ($examination['examinationId'] === $processableId) $hasProcessableExamination = true;
        }
    }

    // Nie wyświetlaj opcji interpretacji dla zleceń, w których nie ma żadnych badań możliwych do interpretacji
    if (!$hasProcessableExamination) return null;

    // Wyświetl różny baner w zależności od tego, czy w zleceniu sa już wszystkie wyniki badań
    return $orderDetails['completed'] ? getenv('LTC_BANNER_URL') : getenv('LTC_BANNER_URL') . '/incomplete';
}

include "template.php"
?>
