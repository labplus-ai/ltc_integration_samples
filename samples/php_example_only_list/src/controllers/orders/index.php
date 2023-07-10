<?php
session_start();
require_once('../../services/db.php');

if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
    header('Location: login');
    exit();
}

$db = new MockedDatabase();
$ordersList = $db->getOrdersList();

/**
 * Interpretacja z wykorzystaniem LabTest Checkera jest możliwa tylko dla zleceń, które spełniają poniższe warunki:
 * - zawierają wyniki przynajmniej jednego obsługiwanego przez Labplus badania,
 * - wyniki nie są starsze niż 30 dni,
 * - wszystkie wyniki badań są już dostępne (zlecenie jest kompletne)
 */
function isInterpretationPossible($orderDetails)
{
    $db = new MockedDatabase();

    // Nie wyświetlaj opcji interpretacji dla zleceń starszych niż 30 dni
    $orderDate = new DateTime($orderDetails['orderDate']);
    $currentDate = new DateTime();
    if ($currentDate->diff($orderDate)->days > 30 && $orderDate < $currentDate) return false;

    // Sprawdź, czy w zleceniu jest przynajmniej jedno badanie możliwe do interpretacji
    $processableIds = $db->getProcessableExaminationsIds();
    $hasProcessableExamination = false;
    foreach ($processableIds as $processableId) {
        foreach ($orderDetails['examinations'] as $examination) {
            if ($examination['examinationId'] === $processableId) $hasProcessableExamination = true;
        }
    }

    // Nie wyświetlaj opcji interpretacji dla zleceń, w których nie ma żadnych badań możliwych do interpretacji
    if (!$hasProcessableExamination) return false;

    // Nie wyświetlaj opcji interpretacji dla zleceń bez kompletu wyników
    if(!$orderDetails['completed']) return false;

    return true;
}

include "template.php";
?>
