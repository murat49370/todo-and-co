# Comment contribuer au projet

## Créer une copie locale
Utilisez [README.md] (https://github.com/murat49370/todo-and-co/blob/main/README.md) et suivre les instructions pour installer un clone du projet en local.

## Issues
Veuillez créer un nouvelle "issue", si nécessaire lié à un nouveau jalon, pour décrire ce qui sera développé et la date d'échéance.

## Nouvelle branche
Avant de commencer à développer, veuillez créer une nouvelle branche:

```
git checkout [newBranch]
```


## Bonne pratique pour le développement
Veuillez respecter le modèle MVC et développer les tests associer à votre nouveau code.

## Tests
Veuillez lancer la couverture des tests avec:

```
vendor\bin\phpunit --coverage-html public\test-coverage
```

et vérifiez si la couverture totale atteint au minimum 70% du code de l'application.

## Faite des commits et pousser votre code
Ajoutez et validez votre code avec un message clair en relation avec le contenu. Par exemple :

```
git add .
git commit -m "Feature(issue1)Added new functionnality"
```

et faite un Push:
```
git push origin [branch name]
```

## Pull Request
Ouvrez une nouvelle demande de "Pull Request".

Normes et bonne pratique
Veuillez respecter la règle PSR, en particulier celles-ci:
*   [PSR-1 : Basic Coding Standard](https://gist.github.com/npotier/d5a13245ad9cd2e92fa9dec19baf0e9a)
*   [PSR-2 : Coding Style Guide](https://gist.github.com/npotier/593b645025173ef8bbb5c59d3fd455fa)
*   [PSR-4 : Autoloader](https://www.php-fig.org/psr/psr-4/)
*   [Symfony best pratices](https://symfony.com/doc/4.4/best_practices/index.html) for 4.4 version 