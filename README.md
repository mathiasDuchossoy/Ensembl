Objectifs
=======

L'objectif de cet exercice est de coder un serveur d'un petit jeu. 
Le but du jeu est de trouver une cible et de l'éliminer.

Règle du jeu
=======
Le jeu se déroule sur une carte carré de X case de coté.

La cible est placé aléatoirement en début de jeu sur une position (x,y).

Le joueur est placé au milieu de la carte en début de partie.

Le joueur peut voir la cible si elle se situe a 2 cases de lui.

Le joueur ne peut pas sortir de la carte.

Le joueur peut se effectuer les actions suivantes :
* se déplacer en haut
* se déplacer en bas
* se déplacer gauche
* se déplacer droite
* tirer sur la cible
La cible doit être touché trois fois pour être éliminer

Route du serveurs
=======

**Request move**
```
POST /move
{
  "action": "up|down|left|right"
}
```
**Response**
```
{
  "position": {
    "x" => 1,
    "y" => 7
  },
  "target": null | {
    "x" => 2,
    "y" => 8
  }
}
```

**Request shoot**
```
POST /shoot
{
  "x": 2,
  "y": 4
}
```
**Response**
```
{
  "result": "touch|miss|kill"
}
```

Bonus
=======

**Request**
```
GET /map
```
**Response**

Représentation graphique la carte à l'instant T, ça peut être en assci art :-)

Livrable attendu
=======

Un repo GIT avec le code et les tests associés

Les résultats sont importants mais il n'y a pas de solution unique, il existe différentes manières de réussir le test.
Le readme et le nom des commits sont tout aussi important.

N'oubliez pas que vous devrez expliquer et justifier vos choix lors d'un entretien.
