# Confectioners Web
**Appleton Sweets** je web, kde cukráři, kteří se zabývají výrobou cukrovinek doma, mohli najít svého zákazníka tím, že vytvořili na webu nabídku se svým telefonním číslem.   

![Confectioners Web Logo](/resources/main-page-screenshot.png?raw=true "Main Page")
----------
![Confectioners Sign-in Page](/resources/signin-page.png?raw=true "Sign-In Page")
----------
![Confectioners Cakes Page](/resources/cakes-page.png?raw=true "Cakes Page")

## USE CASES

**Nepřihlášení uživatelé:**
 * Prohlédnout si nabídky
 * Zaregistrovat se
 * Přihlásit se
 * Změnit styl webové stránky    

**Přihlášení uživatelé:**
 * Prohlédnout si nabídky
 * Přidat nové nabídky
 * Odhlásit se
 * Změnit styl webové stránky

## POPIS INPLEMENTACE

### Frameworks

**Bootstrap** - sada nástrojů a šablon pro tvorbu webu a webových aplikaci. Obsahuje návrhářské šablony založené na HTML a CSS, sloužící pro úpravu typografie, formulářů, tlačítek, navigace a dalších komponent rozhraní. Pomohl mi při vytvářeni stránek, protože bylo mnohem jednodušší a rychlejší vytvářet elementy stránek a jejich styly.     
**FontAwesome** - sada krásných ikonek.     
**RedBeanPHP** - bylo to pro práci s databázi. Je to ORM pro PHP, které automaticky vytváří databázové tabulky.     
**Hartija CSS Print Framework 1.0** - pro konfiguraci stylu pro tisk.     

### Databáze 

Databázi používám pro zapisovaní dat zaregistrovaných uživatelů a dat cukrovinek, která se pak vypisuje na stránkách *Brownies(brownies.php)* a *Cakes(cakes.php)*.     
Takže celkově mám 3 tabulky a jsou
 * users – pro zaregistrované uživatele; 
 * cakes – pro cakes;
 * brownies – pro brownies.

### Formuláře

Formuláře jsem obsluhoval pomoci PHP, JavaScript a atributů «pattern» a «required» na všech elementech v HTML.     
Nejdůležitější kontroly se provádějí v PHP, proto stránka funguje i bez Javascriptu. Chyby se zapisují do pole a pak první chyba z pole se vypisuje správou.     
Kontrola formuláře v Javascript se provádí pomocí *addEventListener()* a *preventDefault()*. Takže pokud jsou nějaké chyby, tak se též zapisují do pole a pak se vyhodí do obrazovky.    
Všechna políčka mají label.    

### Bezpečnost

Proti XSS byly využity metody *htmlspecialchars()* a *strip_tags()*.    
Pro ořezávaní mezer a jiné byla využita metoda *trim()*, takže byly provedeny kontroly na různé nesmyslné hodnoty.    
Proti dvojímu odeslání dat po registraci a po úspěšném přihlášení uživatele jsem využil přesměrovaní na hlavní stránku, po vyplnění formuláře nové cukrovinky - reload stránky s formulářem.    
Hesla jsou osoleny pomocí parametru *PASSWORD_DEFAULT*.    
