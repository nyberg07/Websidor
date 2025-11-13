readme: |
  # Röstningssida med PHP och JavaScript

  ## Projektbeskrivning
  Detta projekt är en enkel röstningssida där användare kan rösta på bilder. Sidan visar ett galleri med 31 bilder, och varje bild har en knapp som skickar en röst till servern med PHP. Röster sparas i en textfil.

  ---

  ## Filstruktur
/Röstningssida
│
├── index.html # Huvudsida med bildgalleri och röstningsknappar
├── vote.php # PHP-skript som tar emot och sparar röster
├── pics/ # Mapp med alla bilder (option1.jpg - option31.jpg)
└── votes.txt # Textfil där röster sparas (skapas automatiskt)


---

## index.html
- Visar alla bilder i ett tabellformat, 3 bilder per rad.
- Varje bild är en knapp som skickar en POST-begäran via JavaScript (fetch) till `vote.php`.
- Visar meddelanden till användaren om rösten gick igenom eller om det blev fel.

---

## vote.php
- Tar emot POST-förfrågningar med bildens namn (`image`).
- Validerar att bilden är en av de tillåtna (option1.jpg till option31.jpg).
- Sparar rösten i filen `votes.txt`.
- Returnerar JSON-svar med status och meddelande.

---

## Så kör du projektet lokalt (Linux Mint)
1. Placera alla filer enligt filstrukturen ovan.
2. Starta PHP:s inbyggda server i projektmappen:
   ```bash
   php -S localhost:8080
   ```
3. Öppna webbläsaren och gå till:
   ```
   http://localhost:8080/index.html
   ```
4. Klicka på bilder för att rösta.

---

## Vanliga problem och felsökning
- **"Adress redan i bruk" vid start av server**  
  Kontrollera om någon annan process lyssnar på porten:  
  ```bash
  sudo lsof -i :8080
  ```
  Avsluta processen med:  
  ```bash
  kill PID
  ```
- **"Ogiltigt val" vid röstning**  
  Kontrollera att `data-img`-attributet i knapparna exakt matchar filnamnen i PHP-koden.
- **"Kunde inte spara rösten"**  
  Kontrollera filrättigheter för `votes.txt`.  
  Om filen inte finns, skapa den manuellt och ge rättigheter:  
  ```bash
  touch votes.txt
  chmod 666 votes.txt
  ```

---

## Utvecklingsidéer
- Visa röstresultat direkt på sidan.
- Begränsa antal röster per användare med hjälp av sessions eller cookies.
- Byt ut alert mot mer stilren UI-feedback.
- Lägg till säkerhet för att förhindra spammröstning.

---

## Kontakt
Vid frågor, kontakta: Kenny
