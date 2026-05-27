Bankomat applikation i php. 

det är min Bankomat applikation somär byggd i en ren php utan ramverk

frö starta upp projktet
1- öppna tirmenal och navigera till rotmapp
2- generara databasen med testanvändare genom 'php seed.php', och 
starta din inbyggda php-server genom att köra php '-S localhost:8000 -t public' 
3- öpnna http://localhost:8000 i webbläsare.

**Admin-konto:**
-Kortnummer: `11112222`
-PIN: `1234`

**Vanliga användare:**
1-Sven Svensson - Kortnummer: `33334444` (PIN: `1234`)
2-Anna Andersson - Kortnummer: `55556666` (PIN: `1234`)


**Admin-panelen**

* Se en lista över alla användare.
* Se en lista över alla konton och deras saldon.
* Se en historik över alla transaktioner som gjorts i systemet.


**Säkerhet & Struktur**

**Lösenord:** PIN-koder hashas säkert med `bcrypt` (`password_hash`).

**CSRF-skydd:** Alla formulär (inloggning, insättning, uttag, överföring) använder unika CSRF-tokens som valideras innan datan bearbetas.

**XSS-skydd:** Utdata tvättas konsekvent med `htmlspecialchars()` via hjälpfunktionen `e()`.

**Sessioner:** Förhindrar "session fixation" genom att anropa `session_regenerate_id(true)` vid inloggning.

**Transaktioner:** Använder PDO-transaktioner (`beginTransaction`, `commit`, `rollBack`) för att garantera att inga pengar går förlorade om ett fel uppstår. Uttag nekas server-side om saldot inte täcker beloppet.