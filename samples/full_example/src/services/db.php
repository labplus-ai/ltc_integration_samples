<?php

class MockedDatabase
{
    function saveTokenToOrder($orderId, $token)
    {
        // todo przypisz token do zlecenia
    }

    // Lista identyfikatorów parametrów, które obsługuje LabTest Checker
    // Lista będzie rozbudowywana, tak że powinna być prosta do rozbudowy w systemie Partnera
    // Poniższa lista jest aktualna na dzień 30 czerwca 2023
    // Poniższa lista zawiera identyfikatory Labplus, możliwe jest wykorzystanie identyfikatorów z bazy partnera
    function getProcessableParamsIds()
    {
        return array(1, 2, 3, 4, 5, 6, 8, 9, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59);
    }

    // Lista wyników badań dla zlecenia
    function getOrderDetails($orderId)
    {
        switch ($orderId) {
            case "001":
                return array(
                    "completed" => false,
                    "ltcToken" => null,
                    "orderDate" => "2026-06-13",
                    "comment" => "To jest przykład zlecenia, w którym jeszcze nie ma dostępnych wszystkich wyników badań pacjenta. W takim przypadku interpretacja nie będzie możliwa.",
                    "examinations" => array( // Tablica wyników badań
                        array(
                            'examinationName' => 'OB', // Nazwa badania, string
                            'examinationId' => 'OB', // ID badania, string lub number
                            'examinationParams' => array( // tablica parametrów badania
                                array(
                                    'paramId' => 18, // ID parametru badania, string lub number
                                    'paramName' => 'OB (oczekiwanie na wynik)', // wartość wyniku dla parametru, string lub number
                                    'paramValue' => '-', // jednostka parametru, string
                                    'paramUnit' => '-', // norma górna parametru, number lub null
                                    'paramNormHigh' => '-', // norma górna parametru, number lub null
                                    'paramNormLow' => '-', // norma górna parametru, number lub null
                                    'paramNormValue' => null, // pole nieużywane, null
                                    'paramDate' => '2025-08-25 00:00:00' // data wykonania oznaczenia, string w odpowiendim formacie
                                )
                            )
                        )
                    )
                );
            case "002":
                return array(
                    "completed" => true,
                    "ltcToken" => null,
                    "orderDate" => "2026-06-13",
                    "comment" => "To jest przykład zlecenia, w którym interpretacja jest możliwa do wykonania",
                    "examinations" => array(
                        array(
                            'examinationName' => 'TSH',
                            'examinationId' => 'TSH',
                            'examinationParams' => array(
                                array(
                                    'paramId' => 1,
                                    'paramName' => 'TSH',
                                    'paramValue' => 6.22,
                                    'paramUnit' => 'µIU/ml',
                                    'paramNormHigh' => 5,
                                    'paramNormLow' => 0,
                                    'paramNormValue' => null,
                                    'paramDate' => '2025-08-25 00:00:00'
                                )
                            )
                        ),
                        array(
                            'examinationName' => 'Testosteron',
                            'examinationId' => 'Testosteron',
                            'examinationParams' => array(
                                array(
                                    'paramId' => 9999,
                                    'paramName' => 'Testosteron',
                                    'paramValue' => 123,
                                    'paramUnit' => 'µIU/ml',
                                    'paramNormHigh' => 1,
                                    'paramNormLow' => 42,
                                    'paramNormValue' => null,
                                    'paramDate' => '2025-08-25 00:00:00'
                                )
                            )
                        )
                    )
                );
            case "003":
                return array(
                    "completed" => true,
                    "ltcToken" => "03579594-d1db-4621-b4c5-8b5e88024e18",
                    "orderDate" => "2026-06-13",
                    "comment" => "To jest przykład zlecenia, w którym interpretacja była już przeprowadzona przez użytkownika.",
                    "examinations" => array(
                        array(
                            'examinationName' => 'TSH',
                            'examinationId' => 'TSH',
                            'examinationParams' => array(
                                array(
                                    'paramId' => 1,
                                    'paramName' => 'TSH',
                                    'paramValue' => 6.22,
                                    'paramUnit' => 'µIU/ml',
                                    'paramNormHigh' => 5,
                                    'paramNormLow' => 0,
                                    'paramNormValue' => null,
                                    'paramDate' => '2025-08-25 00:00:00'
                                )
                            )
                        ),
                        array(
                            'examinationName' => 'Testosteron',
                            'examinationId' => 'Testosteron',
                            'examinationParams' => array(
                                array(
                                    'paramId' => 9999,
                                    'paramName' => 'Testosteron',
                                    'paramValue' => 123,
                                    'paramUnit' => 'µIU/ml',
                                    'paramNormHigh' => 1,
                                    'paramNormLow' => 42,
                                    'paramNormValue' => null,
                                    'paramDate' => '2025-08-25 00:00:00'
                                )
                            )
                        )
                    )
                );
            case "004":
                return array(
                    "completed" => true,
                    "ltcToken" => null,
                    "orderDate" => "2026-06-13",
                    "comment" => "To jest przykład zlecenia, w którym interpretacja nie jest możliwa, ponieważ w zleceniu nie ma żadnego badania które jest interpretowane przez LabTest Checker.",
                    "examinations" => array(
                        array(
                            'examinationName' => 'Testosteron',
                            'examinationId' => 'Testosteron',
                            'examinationParams' => array(
                                array(
                                    'paramId' => 9999,
                                    'paramName' => 'Testosteron',
                                    'paramValue' => 123,
                                    'paramUnit' => 'µIU/ml',
                                    'paramNormHigh' => 1,
                                    'paramNormLow' => 42,
                                    'paramNormValue' => null,
                                    'paramDate' => '2025-08-25 00:00:00'
                                )
                            )
                        )
                    )
                );
            case "005":
                return array(
                    "completed" => true,
                    "ltcToken" => null,
                    "orderDate" => "2021-06-13",
                    "comment" => "To jest przykład zlecenia, w którym interpretacja nie jest możliwa, ponieważ zlecenie jest zbyt stare (ponad 30 dni)",
                    "examinations" => array(
                        array(
                            'examinationName' => 'TSH',
                            'examinationId' => 'TSH',
                            'examinationParams' => array(
                                array(
                                    'paramId' => 1,
                                    'paramName' => 'TSH',
                                    'paramValue' => 6.22,
                                    'paramUnit' => 'µIU/ml',
                                    'paramNormHigh' => 5,
                                    'paramNormLow' => 0,
                                    'paramNormValue' => null,
                                    'paramDate' => '2021-08-25 00:00:00'
                                )
                            )
                        )
                    )
                );
            default:
                die('Szczegóły zamówienia nie znalezione');
        }
    }
}

?>
