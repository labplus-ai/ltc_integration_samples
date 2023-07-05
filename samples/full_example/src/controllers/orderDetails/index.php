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

$showLTCBanner = getLTCBannerVisibility($orderDetails);

// Pokaż ramkę z LabTest Checker dla zleceń które miały już wygenerowany token
if ($orderDetails['ltcToken'] !== null) {
    $frameURL = getenv('LTC_API_URL') . "/interview/" . getenv('LTC_CLIENT_HASH') . "?token=" . $orderDetails['ltcToken'];
}


function getLTCBannerVisibility($orderDetails)
{
    $db = new MockedDatabase();

    // Nie wyświetlaj banera dla zleceń, w których nie ma jeszcze wszystkich wyników
    if (!$orderDetails['completed']) return false;

    // Nie wyświetlaj banera dla zleceń, dla których jest już wygenerowany token
    if ($orderDetails['ltcToken'] !== null) return false;

    // Nie wyświetlaj banera dla zleceń starszych niż 30 dni
    $orderDate = new DateTime($orderDetails['orderDate']);
    $currentDate = new DateTime();
    if ($currentDate->diff($orderDate)->days > 30 && $orderDate < $currentDate) return false;

    // Nie wyświetlaj banera dla zleceń, w których nie ma żadnych badań możliwych do interpretacji
    $processableIds = $db->getProcessableParamsIds();
    $hasProcessableParams = false;
    foreach ($processableIds as $processableParamId) {
        foreach ($orderDetails['examinations'] as $examination) {
            foreach ($examination['examinationParams'] as $param) {
                if ($param['paramId'] === $processableParamId) $hasProcessableParams = true;
            }
        }
    }
    return $hasProcessableParams;
}

include "template.php"
?>
