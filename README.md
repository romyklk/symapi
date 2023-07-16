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

15. Dans le controller `ApiController`, la méthode `index` doit pointer vers la page d'accueil de l'application. Cette page doit afficher un message de bienvenue. et 3 boutons qui pointent vers les pages suivantes:
    * `regions` : affiche la liste des régions
    * `departements` : affiche la liste des départements
    * `communues` : affiche la liste des communes`

16. Créer une méthode `regions` qui prend en argument un objet de type `SerializerInterface` et qui retourne un objet de type `Response` qui contient la liste des régions sous forme de JSON. Pour cela, on va utiliser le serializer pour sérialiser les données. Cette route doit être accessible à l'adresse `/regions` en méthode `GET` uniquement. Récupérer la liste des régions depuis l'api de `geo.gouv.fr` en utilisant l'url suivante: `https://geo.api.gouv.fr/regions`. `file_get_contents` et `deserialize` sont les fonctions à utiliser pour récupérer et sérialiser les données. `deserialize`  permet de convertir un json en objet. il faut lui passer le json et le type d'objet . Ici ce sera un tableau d'objets de type Region

17. Créer une méthode `departement` qui prend le serializer en argument et qui retourne un objet de type `Response` qui contient la liste des départements sous forme de JSON. Cette route doit être accessible à l'adresse `/departements` en méthode `GET` uniquement. Récupérer la liste des départements depuis l'api de `geo.gouv.fr` en utilisant l'url suivante: `https://geo.api.gouv.fr/departements`. `file_get_contents` et `deserialize` sont les fonctions à utiliser pour récupérer et sérialiser les données. `deserialize`  permet de convertir un json en objet. il faut lui passer le json et le type d'objet . Ici ce sera un tableau d'objets de type Departement. Dans la vue, afficher la liste des régions dans une balise select. Lorsqu'on sélectionne une région, la liste des départements de cette région doit s'afficher dans une autre balise select.

18. Créer une méthode `commune` qui prend en argument le serializer et qui retourne un objet de type `Response` qui contient la liste des communes sous forme de JSON. Cette route doit être accessible à l'adresse `/communes` en méthode `GET` uniquement. Récupérer la liste des communes depuis l'api de `geo.gouv.fr` en utilisant l'url suivante: `https://geo.api.gouv.fr/communes`. `file_get_contents` et `deserialize` sont les fonctions à utiliser pour récupérer et sérialiser les données. `deserialize`  permet de convertir un json en objet. il faut lui passer le json et le type d'objet . Ici ce sera un tableau d'objets de type Commune. Dans la vue, afficher la liste des régions dans une balise select. Lorsqu'on sélectionne une région, la liste des départements de cette région doit s'afficher dans une autre balise select. Lorsqu'on sélectionne un département, la liste des communes de ce département doit s'afficher dans une autre balise select.

19. Ajoute de la pagination. Pour cela, on va utiliser le bundle `KnpPaginatorBundle`. Pour l'installer, on va utiliser la commande suivante:
    * `composer require knplabs/knp-paginator-bundle`
  
20. Pour faire la pagination sur une entité, il faut créer les entités  `Departement` et `Commune`. Pour cela, on va utiliser la commande suivante:
    * `symfony console make:entity`
  
  Departement aura les propriétés suivantes:
    * `nom` (string)
    * `code` (string)
    * `codeRegion` (string)
  
  Commune aura les propriétés suivantes:
    * `nom` (string)
    * `code` (string)
    * `codeDepartement` (string)
    * `codeRegion` (string)
    * `population` (integer)
    * `codesPostaux` (array)
  
