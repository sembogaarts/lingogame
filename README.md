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

## Tests
Ik maak gebruik van 2 verschillende soorten tests in dit project. Ik maak gebruik van UnitTests om alle helpers te testen en Laravel Dust voor browser tests. Travis test beide bij elke wijziging, om de tests handmatig uit te voeren voer je de volgende commando's uit.

```$xslt
php artisan dusk
php vendor/phpunit/phpunit/phpunit
```

## Continous Integration (CI)
Voor CI maak ik gebruik van [TravisCI](https://travis-ci.org/). Travis is gratis voor opensource projecten en geeft ook in deze repo weer of een branch goedgekeurd is.

## Continous Deployment (CD)
Voor CD maak ik gebruik van [Runcloud](https://runcloud.io/r/ayg5VqrgYX01). Hier kan ik eenvoudig met een Github Webhook alles automatisch laten deployen naar mijn eigen website. Runcloud is bedoeld voor PHP applicaties en neemt het beheer van je server verder over.
