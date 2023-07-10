<?php

class MockedDatabase
{
    function saveTokenToOrder($orderId, $token)
    {
        // todo przypisz token do zlecenia
    }

    // Lista identyfikatorów badań, które obsługuje LabTest Checker
    // Lista będzie stale rozbudowywana, powinna być prosta do rozbudowy w systemie Partnera
    // Aktualną listę badań Labplus dostarczy na etapie integracji
    // Poniższa lista jest jedynie przykładem bazującym na fikcyjnych identyfikatorach
    function getProcessableExaminationsIds()
    {
        return array("ID_OB", "ID_TSH");
    }

    // Lista wyników badań dla zlecenia
    function getOrderDetails($orderId)
    {
        return $this->getOrdersList()[$orderId];
    }

    // Lista zleceń danego pacjenta
    function getOrdersList()
    {
        return array(
            '001' => array(
                "id" => "001",
                "completed" => false, // czy wszystkie wyniki ze zlecenia są już w systemie
                "ltcToken" => null, // wygenerowany token do uruchomienia LabTestChecker
                "orderDate" => "2026-06-13", // data zlecenia
                "comment" => "To jest przykład zlecenia, w którym jeszcze nie ma dostępnych wszystkich wyników badań pacjenta. W takim przypadku interpretacja nie będzie możliwa.", // komentarz tylko na potrzeby przykładu integracji
                "examinations" => array( // Tablica badań i ich wyników
                    array(
                        'examinationName' => 'OB', // Nazwa badania, string
                        'examinationId' => 'ID_OB', // ID badania, string lub number
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
            ),
            '002' => array(
                "id" => "002",
                "completed" => true,
                "ltcToken" => null,
                "orderDate" => "2026-06-13",
                "comment" => "To jest przykład zlecenia, w którym interpretacja jest możliwa do wykonania",
                "examinations" => array(
                    array(
                        'examinationName' => 'TSH',
                        'examinationId' => 'ID_TSH',
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
                        'examinationId' => 'ID_Testosteron',
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
            ),
            '003' => array(
                "id" => "003",
                "completed" => true,
                "ltcToken" => "03579594-d1db-4621-b4c5-8b5e88024e18",
                "orderDate" => "2026-06-13",
                "comment" => "To jest przykład zlecenia, w którym interpretacja była już przeprowadzona przez użytkownika.",
                "examinations" => array(
                    array(
                        'examinationName' => 'TSH',
                        'examinationId' => 'ID_TSH',
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
                        'examinationId' => 'ID_Testosteron',
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
            ),
            '004' => array(
                "id" => "004",
                "completed" => true,
                "ltcToken" => null,
                "orderDate" => "2026-06-13",
                "comment" => "To jest przykład zlecenia, w którym interpretacja nie jest możliwa, ponieważ w zleceniu nie ma żadnego badania które jest interpretowane przez LabTest Checker.",
                "examinations" => array(
                    array(
                        'examinationName' => 'Testosteron',
                        'examinationId' => 'ID_Testosteron',
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
            ),
            '005' => array(
                "id" => "005",
                "completed" => true,
                "ltcToken" => null,
                "orderDate" => "2021-06-13",
                "comment" => "To jest przykład zlecenia, w którym interpretacja nie jest możliwa, ponieważ zlecenie jest zbyt stare (ponad 30 dni)",
                "examinations" => array(
                    array(
                        'examinationName' => 'TSH',
                        'examinationId' => 'ID_TSH',
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
            ),
        );
    }
}

?>
