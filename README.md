# Tuto WP Wrapper

## Introduction

Plugin WP basé sur la libairie PHP utilisée pour la derniere version de l'[API Tuto.com](https://api.tuto.com/docs).
Pour le moment, l'API Tuto.com est uniquement disponible pour les auteurs.

## Pré-requis

* Etre contributeur sur tuto.com
* Récupérer la clé API, la clé login et la clé secrète sur [votre interface de gestion](http://fr.tuto.com/compte/vendeur/informations/api/) puis paramétrer le widget.

## Attention

Si vous choisissez l'option custom code (<=> non à l'option widget par défaut) vous êtes responsable du HTML ajouté dans la page. Il y a un sanitize mais le HTML peut être cassé si vous oubliez de fermer une div par exemple.
A utiliser avec précautions.