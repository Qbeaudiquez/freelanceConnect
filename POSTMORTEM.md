# Post-mortem — FreelanceConnect

## Contexte

Projet réalisé à deux sur une semaine, avec pour objectif un MVP de plateforme de mise en relation clients et freelances. Stack imposée : Symfony, MySQL, Doctrine, Twig.

## Ce qui a bien fonctionné

- Les commandes `make:` de Symfony nous ont fait gagner beaucoup de temps (entités, CRUD, auth).
- On a réussi à mettre en place l'auth avec des roles client et freelance en suivant les cours.
- La répartition à deux a plutôt bien marché, on avançait sur notre partie et on fusionnait sur Git.

## Ce qui a été difficile

- Au début, on n'était pas sur la même version de PHP (8.1 vs 8.4). J'ai (Lucas) du installer PHP 8.4, et ça a pris du temps (version TS, Apache qui plantait, le PATH Windows).
- Le travail à deux sur Git : au départ on ne savait pas trop qui devait générer les migrations. On a compris qu'il fallait qu'une seule personne le fasse sinon :/
- Le hachage des mdp : on voulait Argon2id mais on avait du Bcrypt, on a du forcer l'algorithme dans la config (sodium).

## Choix techniques notables

- On est restés sur MySQL pour la messagerie au lieu de MongoDB, pour gagner du temps et se concentrer sur les fonctionnalités.
- Le statut d'une mission est en auto à la création (ouvert), le user ne le choisit pas.

## Ce que nous retenons

- Il faut fixer l'environnement (versions, config) AVANT de commencer à coder, sinon
  on perd du temps au pire moment.
- À deux sur Git, il faut des règles claires : qui touche quel fichier, quand on pull/push.
- Ne jamais écrire une même valeur en dur à plein d'endroits, ça devrait être défini une seule fois.
- Avancer par petites étapes qu'on teste, plutôt que coder un gros bloc d'un coup (j'ai eu qu'un conflict sur tout ce qu'on a fait, je suis content :) Lucas).