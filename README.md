# Harmonogramy
Ogólnie:
Aplikacja służy do tworzenia harmonogramów dla swoich pracowników/współpracowników. Na podstawie podanego roku, miesiąca, liczby godzin wymaganych do pełnego etatu oraz listy pracowników generuje się harmonogram w formie tabeli. Do każdego harmonogramu w czasie tworzenia przypisujemy jeden ze schematów godzin, które wcześniej utworzyliśmy w osobnej zakładce. Komórki tabeli zawierają listę rozwijaną na którą składają się wcześniej zdefiniowane możliwość oraz przypisane do niej wagi(np. 7-17->10h 8-16->8h Urlop->8h Wolne->0h Urlop bezpłatny->0h). W tabeli pomarańczowym kolorem oznaczone są weekendy. Wszystkie utworzone harmonogramy są przechowywane w bazie danych i można do nich wrócić w dowolnyum momencie. Zmiany są zapisywane automatycznie podczas edycji.

Aktualnie aplikacja jest dostępna pod adresem http://mateuszpek.cba.pl 

Jak utworzyć swój pierwszy harmonogram:
1.Zaloguj się na swoje konto pod adresem http://mateuszpek.cba.pl (można przetestować bez logowania za pomocą przycisku "Wypróbuj bez logowania" :D)
2.Wybierz opcję "Dodaj nowy schemat godzin", aby utworzyć listę dostępnych do wybrania opcji godzinowych. W polu "Nazwa schematu" wprowadzamy nazwę pod którą będzie dostępny dany schemat. W kolejnych polach #1,#2,#3... wprowadzamy nazwę pod którą opcja bedzie dostępna w harmonogramie, a w następujących po nich polach "Wartość" wprowadzamy wartość godzinową dla odpowiedniego pola. Aby dodać kolejną opcję użyj przycisku "Dodaj pozycję". Minimalna ilość wprowadzonych opcji to 2. Aby zapisać schemat użyj przycisku "Gotowe". Po zapisaniu zostaniesz przeniesiony na stronę główną.
3.Wybierz opcję "Dodaj nowy harmonogram", wprowadź w kolejnych polach miesiąc oraz rok dla którego chcesz stworzyć harmonogram. W pole "Godziny do wyrobienia" wpisz ilość godzin jaką powinien wyrobić każdy z pracowników w danym miesiącu. W polu pracownicy wprowadź kolejno nazwy/pseudonimy pod którymi będą znajdować się kolejni pracownicy dla których tworzysz harmonogram. Aby zapisać naciśnij przycisk "Gotowe".
4.Aby przejść do nowo utworzonego harmonogramu wybierz "Edytuj istniejące wersje", a następnie odszukaj go na liście.

Potencjalne kierunki rozwoju.
-stworzyć możliwość udostępniania harmonogramów za pomocą linku
-popracować nad stroną wizualną strony 
-zaoranie całości i napisać w formie REST API ^.^