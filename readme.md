Pour installer :

`composer require acti/am_i_up_to_date_sf`

ensuite 
- vérifier que le bundle est bien enregisté dans votre application `Acti\VersionBundle\ActiVersionBundle()`

- ajouter un fichier `acti_version.yml` contenant :

```
acti_version:
       token: tokendedemon
       path: /home/monprojet/baseprojetdemo
```
si nécessaire, importer le fichier  dans `config.yml`
exemple:
```
    - { resource: bundles/acti_version.yml }
```

- et dans `routing.yml` : 

```
renderversionacti:
    path: /url-au-choix
    controller: Acti\VersionBundle\Controller\VersionController:renderVersion
```

la route s'appelle en `GET` uniquement et avec le header suivant `apikey` (qui doit correspondre au `token` renseigné).
et `path` est le dossier racine de votre projet (pour savoir où se trouve le composer.lock)
