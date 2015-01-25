# Tuto WP Wrapper

## Introduction

Plugin WP pour la derniere version de l'[API Tuto.com](https://api.tuto.com/docs).
Pour le moment, l'API Tuto.com est uniquement disponible pour les auteurs.

## Pré-requis

* Etre contributeur sur tuto.com
* Récupérer la clé API, la clé login et la clé secrète sur [votre interface de gestion](http://fr.tuto.com/compte/vendeur/informations/api/) puis paramétrer le widget.

## Attention

Si vous choisissez l'option custom code (<=> non à l'option widget par défaut) vous êtes responsable du HTML ajouté dans la page. Il y a un sanitize mais le HTML peut être cassé si vous oubliez de fermer une div par exemple.
A utiliser avec précautions mais voici les raccourcis :

* %CUSTOMERS_COUNT% pour le nombre de clients,
* %SALES_COUNT% le nombre de ventes,
* %TUTORIALS_COUNT% le nombre de tutos publiés,
* %AVERAGE_RATING% la note moyenne,
* %AVATAR% l'avatar du compte contributeur,
* %PROFILE_LINK% le lien vers le profil contributeur


Pour flusher le cache il faut mettre à jour les réglages du widget

## Styler le widget par défaut

Le widget (affiché sur la partie visible par les visiteurs) par défaut n'est pas stylisé, vous pouvez le personnaliser directement dans votre CSS principale :

    /* classes générales */
     .big-number-statistics{}
     .sentence-under-number-statistics {}
     .taw-container{}
     .taw-link{}

    /* classes pour chaque stat et info */
    .taw-avatar{}
    .taw-tutorials{}
    .taw-customers{}
    .taw-sales{}
    .taw-rating{}