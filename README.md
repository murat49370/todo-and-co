# ToDo & Co
Amélioration d'une application existante dans le cadre de ma formation développeur PHP / Symfony.

<a href="https://codeclimate.com/github/murat49370/todo-and-co/maintainability"><img src="https://api.codeclimate.com/v1/badges/395dad1acb5de7a3af7c/maintainability" /></a>


## Installation
1. Clonez ou téléchargez le repository GitHub sur votre machine :
```
    git clone https://github.com/murat49370/todo-and-co.git
```

2. Déplacer vous dans le dossier :
```
    cd todo-and-co
```

3. Configurez vos variables d'environnement tel que la connexion à la base de données dans le fichier `.env.local` qui devra être crée à la racine du projet en réalisant une copie du fichier `.env` ainsi que la connexion à la base de données de test dans le fichier `env.test`.

4. Téléchargez et installez les dépendances du projet avec [Composer](https://getcomposer.org/download/) :
```
    composer install
```
4. Créez la base de données si elle n'existe pas déjà, taper la commande ci-dessous en vous plaçant dans le répertoire du projet :
```
    php bin/console doctrine:database:create
```
5. Créez les différentes tables de la base de données :
```
    php bin/console doctrine:schema:update --force
```
6. (Optionnel) Installez les fixtures pour avoir une démo de données fictives en développement :
```
    php app/console doctrine:fixtures:load
```
- Admin test : 
login : admin | mot de passe : 123456
  
- User test :
login : user1 | mot de passe : 123456

7. Félicitations le projet est installé correctement, vous pouvez désormais commencer à l'utiliser.

