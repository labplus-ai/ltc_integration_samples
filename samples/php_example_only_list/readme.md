# Integracja LabTest Checker
## Przykład integracji dla systemów bez podglądu wyników badań

**Uwaga! To repozytorium prezentuje przykład integracji z LabTest Checkerem. Dla uproszczenia i czytelności kod nie zawiera takich elementów jak autoryzacja użytkownika, obsługa błędów itp.**

Repozytorium zawiera przykład integracji dla systemu, w którym nie ma ekranu z podglądem wyników. W takim przypadku na liście zleceń prezentowana jest opcja interpretacji przy wybranych zleceniach.

Dane logowania:
- login: `labplus`
- hasło: `veryStrongPassword'

Przykład jest bezstanowy, tj. nie posiada prawdziwej bazy danych - żadne akcje wykonane podczas korzystania z przykładu nie są zapisywane ani utrwalane.

### Uruchomienie kodu (Docker)
Aby uruchomić projekt korzystając z Dockera należy:
- Skopiować plik `.env.dist` jako plik `.env` i uzupełnić go danymi otrzymanymi od Labplus
- Uruchomić kontener korzystając z komendy `docker compose up`
- W przeglądarce wejść na adres `localhost:8000`

### Uruchomienie kodu (PHP server, Apache, NGINX)
Uruchamiając projekt korzystając z serwera PHP należy upewnić się, że:
- W PHP są poprawnie ustawione zmienne środowiskowe zgodnie z plikiem `.env.dist` lub zmienić w kodzie wszystkie wywołania funkcji `getenv()` na konkretne wartości zmiennych
- Dostosować plik `src/.htaccess` do wymagań serwera lokalnego
