
## Book Day
Il sito ha un frontend e un backoffice.
Nel frontend c'è una lista di libri.
Gli utenti possono aggiungere o rimuovere un libro alla lista dei libri preferiti.

## Area Backoffice:
- [CRUD Utenti]
    Un utente può essere un utente normale oppure un admin
    Gli admin possono aggiungere, modificare ed eliminare utenti normali e admin
    Gli admin possono vedere quali sono i libri preferiti di ciascun utente normale
    Ogni utente ha un'email e una password.
- [CRUD Libri]
    Gli admin possono aggiungere, rimuovere o modificare i libri
    Ogni libro contiene: nome libro, descrizione libro, foto del libro, prezzo
- [Area Frontend]
    In home page ho la lista dei libri.
    Ogni libro mostra la foto, il nome e un pulsante
    "scopri di più"
    L'area frontend è accessibile da tutti, anche ai non loggati.
    Cliccando sul pulsante scopri di più vado nella pagina di dettaglio del libro e viene mostrata la foto, il nome del libro, la descrizione e il prezzo.
    In questa pagina posso aggiungere o rimuovere il libro alla "lista dei miei libri preferiti". Questa pagina è accessibile solo agli utenti loggati.
    Nel frontend, in home page, posso cercare un libro sia per nome sia nella descrizione.
    Un utente cliccando nella pagina "libri preferiti"
    può visualizzare la lista di tutti i suoi libri preferiti e può rimuoverli singolarmente. Solo
    loggati
    Un utente tramite la pagina "mio profilo" può modificare i suoi dati, compresa la password di accesso.