# DOCUMENTATION TECHNIQUE
**Projet** : Miniprojet SEO - Iran News  
**Étudiants** : ETU003281, ETU003360  

---

## 🚀 Lancement du projet

Pour démarrer l'application avec Docker, ouvrez un terminal à la racine du projet et exécutez la commande suivante :

```bash
docker-compose up --build
```

**Comment savoir que le projet est prêt ?**
Vous saurez que le projet a démarré avec succès et est prêt à être testé lorsque vous verrez apparaître **ces logs de confirmation** dans votre console :

```text
[+] Running 2/2
 ✔ miniprojet-seo-app          Built                                                                                           0.0s 
 ✔ Container irannews-php-app  Recreated                                                                                       1.1s 
Attaching to irannews-db, irannews-php-app
irannews-db  | 
irannews-db  | PostgreSQL Database directory appears to contain a database; Skipping initialization
irannews-db  | 
irannews-db  | 2026-03-31 07:17:44.707 UTC [1] LOG:  starting PostgreSQL 15.15 on x86_64-pc-linux-musl, compiled by gcc (Alpine 15.2.0) 15.2.0, 64-bit
irannews-db  | 2026-03-31 07:17:44.822 UTC [1] LOG:  database system is ready to accept connections
irannews-php-app  | [Tue Mar 31 07:17:56.059312 2026] [mpm_prefork:notice] [pid 1:tid 1] AH00163: Apache/2.4.66 (Debian) PHP/8.2.30 configured -- resuming normal operations
```

Si vous voyez la ligne confirmant que PostgreSQL est prêt à accepter des connexions, vous pouvez vous rendre sur le navigateur !

## 🔗 Liens importants

* **FrontOffice (Accueil)** : [http://localhost:8080/main/accueil](http://localhost:8080/main/accueil)
* **BackOffice (Login Admin)** : [http://localhost:8080/main/admin](http://localhost:8080/main/admin)

## 🔐 Accès BackOffice (BO)

Par défaut, l'utilisateur administrateur de test est généré lors du lancement de la base de données.
* **Nom d'utilisateur (User)** : `admin`
* **Mot de passe (Pass)** : `admin123`

---

## 🗄️ Modélisation de la base de données

> *Espace réservé pour votre capture d'écran de l'architecture de la base (MCD / MLD).*
> 
> *Insérez l'image ici : `![Modélisation de la base](chemin/vers/image.png)`*

### 💡 Comment importer le schéma SQL dans le logiciel Looping :

Si vous souhaitez obtenir rapidement le Modèle Conceptuel de Données (MCD) sur Looping à partir de votre script existant :
1. Lancez l'application **Looping**.
2. Allez dans le menu **Fichier > Importer**.
3. Choisissez **Script SQL** (ou import de DDL/schéma relationnel).
4. Sélectionnez le fichier `init.sql` situé à la racine du projet.
5. Dans les options de syntaxe, choisissez la syntaxe **PostgreSQL** ou **Générique** si PostgreSQL n'est pas spécifié.
6. Looping génèrera automatiquement vos classes, entités et liens. *(Note : Vous devrez peut-être réarranger manuellement les boîtes à l'écran pour que le schéma soit beau et clair avant de prendre votre capture)*.

---

## 🖼️ Captures d'écran (FrontOffice et BackOffice)

### FrontOffice (FO)
> *Insérez la capture de la page d'accueil ou des articles.*
> 
> *`![Capture FrontOffice](chemin/vers/capture_fo.png)`*

### BackOffice (BO)
> *Insérez la capture du tableau de bord ou de l'éditeur d'articles.*
> 
> *`![Capture BackOffice](chemin/vers/capture_bo.png)`*
