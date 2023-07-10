<?php
/**
 * Przykład API służącego do wygenerowania adresu umożliwiającego uruchomienie LabTest Checkera
 *
 * Uwaga!
 * Poniższy kod skupia się na procesie komunikacji z API Labplus, należy go dostosować do systemu, w którym ma być osadzony.
 * W szczególności należy uzupełnić go o autoryzację, odpowiednie zabezpieczenia kodu, obsługę błędów itp.
 */
class LabplusService
{
    function generateToken($examinations, $appKey, $apiUrl)
    {
        $jsonData = json_encode(array("examinations" => $examinations));

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
}

?>
