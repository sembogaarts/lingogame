# Lingo [![Build Status](https://travis-ci.org/sembogaarts/lingogame.svg?branch=master)](https://travis-ci.org/sembogaarts/lingogame)
Ontwikkeld voor VKBEP dit is deelopdracht 2, het daadwerkelijke Lingo spel. Deze repo staat live op [sembogaarts.nl](lingo.sembogaarts.nl).

## Installatie
Vereist is composer en PHP 7.3 of hoger. Installeer eerst alle composer dependencies.

```$xslt
composer install
```

Nadat dit process klaar is maak je je eigen enviroment bestand aan door het onderstaande commando. Pas hier ook vervolgens de variables in aan zodat ze kloppen voor jouw systeem.

```$xslt
cp .env.example .env
```

Voer tot slot het volgende commando uit om een geheime sleutel voor je installatie te genereren en om de database voor je klaar te laten zetten.


```$xslt
php artisan key:generate
php artisan migrate
```

**Belangrijk!** Om woorden te importeren draai je de lingowords applicatie in de andere repository, zorg ervoor dat de database als eerst wordt ingesteld!

## Tests
Ik maak gebruik van 2 verschillende soorten tests in dit project. Ik maak gebruik van UnitTests om alle helpers te testen en Laravel Dust voor browser tests. Travis test beide bij elke wijziging, om de tests handmatig uit te voeren voer je de volgende commando's uit.

Mocht het lokaal runnen van de tests niet werken met Laravel dusk:

1. Controller of de APP_URL in de .env goed staat.
2. Lees [dit](https://ohseemedia.com/posts/laravel-dusk-error-chrome-version-must-be-between-70-and-73/) artikel even door voor problemen met Chrome versies. 

```$xslt
php artisan dusk
php vendor/phpunit/phpunit/phpunit
```

## Static analysis tools
Op de achtergrond van het systeem draait [Sentry](https://sentry.io/). Op het moment dat er een Exception opduikt die niet is afgehandeld wordt dit gerapporteerd en kan hier direct mee aan de slag worden gegaan.

Alle persoonlijke informatie wordt uit het verzoek gehaald en wordt ook niet opgeslagen, zo is het platform ook nog is enorm veilig. Op de productie omgeving is dit ingeregeld, dit kan eenvoudig worden getest door een eigen account te registereren en de sleutel hiervoor te plakken bij `SENTRY_LARAVEL_DSN` in het  .env bestand.

## Security Audits
Omdat het om een prototype gaat is er gebruik gemaakt van tokens die gegenereert worden en als cookie worden toegevoegd. Dit zou geen veilige manier zijn op het moment dat dit in productie gaat. Mensen kunnen namelijk token stelen om zo voor te doen als iemand anders. Omdat er geen persoonlijke informatie wordt opgeslagen maakt het inprincipe voor nu niets uit.

Als de applicatie in productie zou gaan zou ik wel aanraden om over te gaan naar account i.p.v. het opvullen van tokens.

## Code Coverage
In de repo zit een afbeelding van de code coverage met XDebug. In PHPStorm dit eenvoudig worden nageboots, indien gewenst.

## Continous Integration (CI)
Voor CI maak ik gebruik van [TravisCI](https://travis-ci.org/). Travis is gratis voor opensource projecten en geeft ook in deze repo weer of een branch goedgekeurd is.

## Continous Deployment (CD)
Voor CD maak ik gebruik van [Runcloud](https://runcloud.io/r/ayg5VqrgYX01). Hier kan ik eenvoudig met een Github Webhook alles automatisch laten deployen naar mijn eigen website. Runcloud is bedoeld voor PHP applicaties en neemt het beheer van je server verder over.
