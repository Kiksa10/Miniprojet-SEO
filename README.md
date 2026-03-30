# 📘 Projet Web Design - Site d'informations sur la guerre en Iran

## 📌 Contexte

Mini-projet de Web Design consistant à développer un site d'informations avec :

* Un **FrontOffice** (site public)
* Un **BackOffice** (administration)
* Une **base de données PostgreSQL**

---

## 🎯 Objectifs

Créer un site complet permettant :

* Affichage des articles (public)
* Gestion des articles (admin)
* Gestion des catégories
* Authentification sécurisée

---

## 🛠️ Technologies utilisées

* **Java 17**
* **Spring Boot 3.x**
* **Spring Data JPA**
* **Thymeleaf**
* **PostgreSQL**
* **Maven**
* **Docker**

---

## 📁 Structure du projet

```
mon-projet/
├── src/
│   ├── main/
│   │   ├── java/com/projet/irannews/
│   │   │   ├── IrannewsApplication.java
│   │   │   ├── entity/
│   │   │   ├── repository/
│   │   │   ├── service/
│   │   │   ├── controller/
│   │   │   └── config/
│   │   └── resources/
│   │       ├── templates/
│   │       └── static/
│   ├── docker/
│   │   └── init.sql
├── Dockerfile
├── docker-compose.yml
├── pom.xml
└── README.md
```

---

## 🗄️ Base de données

### Tables principales

* `articles`
* `categories`
* `article_categories`
* `users`

### Fonctionnalités :

* Articles avec statut (draft/published)
* Catégories multiples
* Compteur de vues
* SEO (meta title, description)

---

## 🔐 Authentification

* Login via `/admin/login`
* Accès sécurisé `/admin/**`
* Identifiants par défaut :

  ```
  username: admin
  password: admin123
  ```

---

## 🌐 FrontOffice

### Pages :

* Accueil (`/`)
* Article (`/article/{id}`)

### Fonctionnalités :

* Liste des articles publiés
* Détail article
* Compteur de vues
* SEO optimisé

---

## 🖥️ BackOffice

### Accès :

```
/admin
```

### Fonctionnalités :

* Dashboard
* CRUD articles
* Publication
* Gestion catégories

---

## 🔎 SEO (Obligatoire)

* Une seule balise `<h1>` par page
* Structure : `<h1> → <h2> → <h3>`
* Meta description
* Attribut `alt` pour images
* URLs propres

---

## 🐳 Docker

### Lancer le projet :

```bash
docker-compose up --build
```

### Accès :

* FrontOffice : http://localhost:8080
* BackOffice : http://localhost:8080/admin

---

## 📦 Livraison

### À fournir :

* ZIP du projet
* Repo GitHub/GitLab
* Docker fonctionnel
* Document technique

---

## 📄 Document technique

### Contenu :

#### 1. Présentation

* Description du projet
* Objectifs

#### 2. Technologies

#### 3. Captures d’écran

* Accueil
* Article
* Login
* Dashboard
* CRUD

#### 4. Base de données

* Diagramme ER
* Tables + relations

#### 5. Architecture

* Controller / Service / Repository

#### 6. Déploiement

* Docker
* Variables d’environnement

#### 7. Informations

* Numéro étudiant : ETU003281 et 
* Repo : https://github.com/Kiksa10/Miniprojet-SEO.git

---

## ⚠️ Contraintes importantes

* Java 17 obligatoire
* URLs avec ID (pas de slug pour l’instant)
* Articles visibles seulement si `published`
* Images avec `alt`
* Projet fonctionnel avec Docker

---

## 🚀 Ordre de génération du code

1. pom.xml
2. init.sql
3. application.properties
4. Application.java
5. Entities
6. Repositories
7. Services
8. Controllers
9. Security
10. Templates
11. CSS
12. Docker
13. README
14. Document technique

---

## 💡 Conseil

Commence par :

1. Base de données
2. Backend (API + sécurité)
3. FrontOffice
4. BackOffice
5. Docker

---

🔥 Projet complet = Backend + Front + Sécurité + SEO + Docker
