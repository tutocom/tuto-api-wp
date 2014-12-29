# Tuto WP Wrapper

## Introduction

Plugin WP basé sur la libairie PHP utilisée pour la derniere version de l'[API Tuto.com](https://api.tuto.com/docs).
Pour le moment, l'API Tuto.com est uniquement disponible pour les auteurs.

## Pré-requis

* Etre contributeur sur tuto.com
* Récupérer la clé API, la clé login et la clé secrète sur [votre interface de gestion](http://fr.tuto.com/compte/vendeur/informations/api/) puis paramétrer le widget.

Pour tester vos identifiants :

    curl -H "X-API-KEY: APIKEY" --digest -u username:secret https://api.tuto.com/0.2/contributor/statistics/common