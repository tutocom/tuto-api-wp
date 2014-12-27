# Tuto PHP Wrapper

## Introduction

Fournis une libairie PHP pour la derniere version de l'[API Tuto.com](https://api.tuto.com/docs).
Le but étant de simplifier l'utilisation de l'api Tuto.com aux développeurs PHP.
Pour le moment, l'API Tuto.com est uniquement disponible pour les auteurs.

### Prerequis

Afin d'utiliser l'API Tuto.com correctement, il vous faut:
* PHP5
* Composer
* une API Key
* une API Secret
* un peu d'imagination


## Installation

Installation avec Composer. Installer Composer pour votre projet : 

```
$ curl -s http://getcomposer.org/installer | php
```

Créer/Editer votre fichier composer.json
```
{
    "require": {
        "tutocom/tuto-api-php" : "0.2.0"
    }
}
```

Installer la librairie

```
$ composer install
```

Ajouter l'autoloader Composer à votre fichier index.php
```php
require_once './vendor/autoload.php';
```

## Utilisation

```php
$client = new Tuto\Client(API_KEY);
$client->setCredentials(API_LOGIN, API_SECRET);
```

## Exemples

Récupération des statistiques relatives au compte
```php
$stats = $client->contributor->statistics();
```

Récupération de la note moyenne sur le catalogue
```php
$stats = $client->contributor->statistics('rating');
```

Récupération du nombre de tuto
```php
$stats = $client->contributor->statistics('tutorials');
```

Récupération du nombre de clients
```php
$stats = $client->contributor->statistics('customers');
```

Récupération du nombre de ventes
```php
$stats = $client->contributor->statistics('sales');
```

## Support

Contacter le support sur http://aide.tuto.com
