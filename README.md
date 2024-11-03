# Mutation Testing Demo

Ce projet accompagne la conférence **"Débusquez les failles cachées : Maîtrisez vos tests PHP avec PHPInfection & Pest"**,
présentée par Vincent Amstoutz.

L'objectif de cette conférence est de montrer comment les tests de mutations peuvent renforcer la robustesse
des tests PHP, en utilisant des outils tels qu'[Infection PHP](https://infection.github.io/) et [Pest](https://pestphp.com/).

## Prérequis

> [!IMPORTANT]
> Les commandes décrites ci-dessous nécessitent l'utilisation de [Castor](https://castor.jolicode.com/) ! Assurez-vous que Castor est bien installé et configuré sur votre machine.

## Installation

Pour installer les dépendances du projet, utilisez la commande suivante :

```bash
castor install
```

## Exécution des outils de qualité de code (PHP-CS-Fixer, PHPStan & Rector)
```bash
castor lint
```

> [!NOTE]
> Ce projet est destiné à des fins de démonstration et d'apprentissage. Pour une mise en œuvre en production,
> veuillez consulter la documentation de chaque outil et adapter la configuration en fonction de vos besoins.
>

## Licence

Ce projet est sous licence MIT. Voir le fichier [LICENSE](LICENSE) pour plus de détails.