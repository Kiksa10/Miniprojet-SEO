# 📘 Projet Web Design - Site d'informations sur la guerre en Iran (PHP Natif)

## 📌 Contexte

Mini-projet de Web Design originellement prévu en Java, mais restructuré en **PHP natif (sans framework)** consistant à développer un site d'informations avec :

* Un **FrontOffice** (site public)
* Un **BackOffice** (administration)
* Une **base de données PostgreSQL**

---

## 🎯 Objectifs

Créer un site complet permettant :

* Affichage des articles (public)
* Gestion des articles (admin)
* Gestion des catégories
* Authentification sécurisée (PHP PDO / Session)

---

## 🛠️ Technologies utilisées

* **PHP 8.2** (sans framework)
* **HTML5 / CSS3**
* **PostgreSQL**
* **Docker / Docker Compose** (Apache 2)

---

## 📁 Structure du projet

La nouvelle structure est séparée visuellement et fonctionnellement :

```text
Miniprojet-SEO/
├── main/
│   ├── back/                  # Administration
│   │   ├── inc/               # Fonctions métiers PHP (auth, articles, categories, db)
│   │   ├── pages/             # Pages views pour l'admin (dashboard, crud...)
│   │   ├── assets/            # CSS spécifique admin
│   │   └── connexion.php      # Point d'entrée login Admin
│   │
│   └── front/                 # Site public
│       ├── inc/               # (Éventuellement des fonctions spécifiques front)
│       ├── pages/             # Pages publiques (index, article)
│       ├── assets/            # CSS public
│       └── connexion.php      # Base pour la connexion client
│
├── src/docker/
│   └── init.sql               # Script d'init de base de données (inchangé)
│
├── Dockerfile                 # Image PHP:8.2-apache + PDO PgSQL
├── docker-compose.yml         # Conteneurs (db + app)
└── README.md
```

---

## 🗄️ Base de données

### Configuration

Les informations de connexion à la base de données sont passées par variables d'environnement Docker au fichier `main/back/inc/db.php`.

Tables principales (conservées) :
* `articles`
* `categories`
* `article_categories`
* `users`

---

## 🔐 Authentification

* Login Admin via `/main/back/connexion.php`
* Mode : **PHP Sessions** (`$_SESSION`)
* Identifiants par défaut injectés par le script `init.sql` :
  ```text
  username: admin
  password: admin123
  ```

---

## 🌐 URLs d'accès

Une fois le conteneur lancé, l'application est accessible sur le port **8080** :

* **FrontOffice (Accueil)** : [http://localhost:8080/main/accueil](http://localhost:8080/main/accueil)
* **Détail d'article** : [http://localhost:8080/main/article/1](http://localhost:8080/main/article/1)
* **BackOffice (Admin)** : [http://localhost:8080/main/admin](http://localhost:8080/main/admin)

---

## 🐳 Docker

### Lancer le projet :

```bash
docker-compose up --build
```
*Le port exposé sur l'hôte est 8080 (mappé sur le port 80 d'Apache dans le conteneur).*
