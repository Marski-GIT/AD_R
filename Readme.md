# Zadanie rekrutacyjne adRespect

## Opis zadania

Twoim zadaniem jest napisanie aplikacji w czystym PHP (bez użycia frameworków), która będzie korzystać z API NBP (
Narodowy Bank Polski) do pobierania kursów walut. Aplikacja powinna umożliwić zapisywanie pobranych kursów walut. do
bazy danych oraz wyświetlanie ich w formie tabeli. Dodatkowo, aplikacja powinna umożliwić przewalutowanie danej kwoty z
wybranej waluty ba inną i zapisanie wyników przewalutowania do bazy danych.

## API NBP

http://api.nbp.pl

## Wymagania

1. Utwórz wymaganą bazę danych MySQL i skonfiguruj połączenia z bazą.
2. Napisz odpowiednie klasy lub metody, które będą odpowiedzialne za komunikację z API NBP i pobieranie kursów walut.
3. Zapisz pobrane kursy walut do bazy danych.
4. Utwórz klasę lub funkcje, która będzie generować tabelę z kursami walut na podstawie danych z bazy danych.
5. Stwórz formularz, który umożliwi użytkownikowi wpisanie kwoty oraz wybranie dwóch walut: waluty źródłowej i waluty
   docelowej.
6. Napisz odpowiednie klasy lub metody, które będą przewalutowywać podaną kwotę z jednej waluty na drugą, korzystając z
   danych z bazy danych.
7. Zapisz wyniki przewalutowań do bazy danych wraz z informacjami o walutach źródłowej, docelowej i przewalutowanej
   kwocie.
8. Wyświetl listę ostatnich wyników przewalutowań wraz z informacjami o walutach źródłowej, docelowej i przewalutowanej
   kwocie. Wykorzystaj dane z bazy danych.
9. Wykorzystaj podejście obiektowe w kodzie, stosując dobre praktyki związane z programowaniem obiektowym w czystym PHP.
10. Zadbaj o odpowiednie zabezpieczenie aplikacji, takie jak walidacja danych wejściowych, obsługa błędów itp.
11. Zwróć uwagę na estetykę pracy i kodu. Staraj się zachować czytelność, odpowiednie formatowanie i nazewnictwo
    zmiennych.

### Podczas oceny rozwiązania będziemy brać pod uwagę:

1. Poprawność działania aplikacji.
2. Jakość kodu (czytelność organizacja, nazewnictwo zmiennych, komentarze itp.).
3. Wykorzystanie obiektowego podejścia w czystym PHP.
4. Estetykę pracy i kodu.
5. Poprawność integracji z API NBP i bazą danych.
6. Zgodność z wymaganiami.

# Dokumentacja

## Informacje początkowe

- aplikacja napisana w PHP 8.2
- w .htaccess należy skonfigurować domenę, pod którą została umieszczona aplikacja.
- w pliku .env należy wpisać domenę, pod którą została umieszczona aplikacja.

## Baza danych

- W folderze SQL znajdują się struktury bazy danych.
- W pliku .env należy podać konfigurację połączenia z bazą danych.

## Opis (brak informacji w treści zadania)

- pobieram tylko tabele A i B (brak informacji o celu przeliczeń, zakup czy sprzedaż).
- aktualizacja bazy kursów walut odbędzie się tylko w przypadku, gdy w bazie nie ma już numeru tabeli z API NBP.
- wyświetlam ostatnie 10 wyników przeliczeń z kalkulatora.
- metoda do generowania tabeli (Models/CurrencyModel->read()), brak informacji o jej użyciu (4 punkt zadania).