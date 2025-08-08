# Connaître le Gabon

Une application web interactive pour découvrir le Gabon, son histoire, sa culture et ses ressources.

## Description
Cette application web permet aux utilisateurs d'explorer différents aspects du Gabon :
- Histoire et personnalités importantes
- Ressources naturelles (manganèse, okoumé, etc.)
- Symboles nationaux
- Culture et patrimoine
- Parcs nationaux

## Fonctionnalités
- Navigation interactive dans les différentes sections
- Galerie de photos et médias
- Base de données MySQL pour le stockage des informations
- Formulaire de contact avec PHPMailer
- Section suggestions pour les contributeurs
- Lecture de l'hymne national

## Technologies utilisées
- PHP
- MySQL
- HTML/CSS
- JavaScript
- PHPMailer pour la gestion des emails
- Tailwind CSS pour le style

## Installation
1. Cloner le repository
2. Importer le fichier `base_gabon.sql` dans votre base de données MySQL
3. Configurer les paramètres de connexion dans `connect.php`
4. Configurer le serveur mail dans les fichiers concernés
5. Démarrer votre serveur web local

## Structure du projet
- `assets/` : Contient tous les fichiers médias (images, audio, vidéo)
- `PHPMailer/` : Librairie pour l'envoi d'emails
- `*.php` : Fichiers PHP principaux de l'application
- `base_gabon.sql` : Structure de la base de données
