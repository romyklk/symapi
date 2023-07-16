# Creation API avec Symfony 6

## Description
Dans ce projet, nous avons créé une API avec Symfony 6. L'API permet de créer, modifier, supprimer et afficher des contacts. Les contacts sont stockés dans une base de données MySQL.Nous allons utiliser le framework Symfony pour créer cette API.

## Installation

1. Créer une application microservice Symfony nommée api-app
    * `symfony new api-app`
    
2. Déplacer vous dans le dossier de l'application
    * `cd api-app`
3. Installer twig
    * `composer require twig`
4. Ajouter bootstrap avec le cdn ou en local
5. Créer un dossier `partials` dans le dossier `templates`
6. Créer un fichier `navbar.html.twig` dans le dossier `partials`
7. Include le fichier `navbar.html.twig` dans le fichier `base.html.twig`
8. Lancer le serveur symfony en arrirère plan
    * `symfony server:start -d`
9. Ouvrir le projet dans le navigateur
    * `symfony open:local`

10. Installer le maker bundle pour créer des controllers
    * `composer require maker --dev`
  
11. Créer un controller `ApiController`
    * `symfony console make:controller`

12. Installer le serializer pack qui va nous permettre de sérialiser les données.C'est à dire de les transformer en JSON ou XML par exemple pour les envoyer au client.
    * `composer require symfony/serializer-pack`

13. Installer le pack ORM qui va nous permettre de créer des entités 
    * `composer require symfony/orm-pack`


14. Créer une en entité `Region`
    
    * `symfony console make:entity`
 Ayant les propriétés suivantes:
    * nom (string)
    * code (string)
    * createdAt (datetimeImmutable)
Cette entité ne sera pas liée à une table dans la base de données. Elle va nous permettre de créer des objets de type `Region` qui seront utilisés dans d'autres entités.Donc on va utiliser l'annotation `@ORM\Transient`  au dessus de la classe `Region` pour dire à Doctrine de ne pas créer de table dans la base de données pour cette entité.
