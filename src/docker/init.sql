-- ============================================
-- Script d'initialisation de la base de données
-- Site d'informations sur la guerre en Iran
-- ============================================

-- Table des utilisateurs
CREATE TABLE IF NOT EXISTS users (
    id BIGSERIAL PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) NOT NULL DEFAULT 'ADMIN'
);

-- Table des catégories
CREATE TABLE IF NOT EXISTS categories (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    description TEXT
);

-- Table des articles
CREATE TABLE IF NOT EXISTS articles (
    id BIGSERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    meta_title VARCHAR(255),
    meta_description VARCHAR(500),
    status VARCHAR(20) NOT NULL DEFAULT 'DRAFT',
    view_count INTEGER NOT NULL DEFAULT 0,
    image_url VARCHAR(500),
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Table de liaison articles-catégories (Many-to-Many)
CREATE TABLE IF NOT EXISTS article_categories (
    article_id BIGINT NOT NULL,
    category_id BIGINT NOT NULL,
    PRIMARY KEY (article_id, category_id),
    FOREIGN KEY (article_id) REFERENCES articles(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);

-- ============================================
-- Données initiales
-- ============================================

-- Utilisateur admin (mot de passe: admin123, encodé en BCrypt)
INSERT INTO users (username, password, role) VALUES
('admin', '$2a$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcfl7p92ldGxad68LJZdL17lhWy', 'ADMIN');

-- Catégories
INSERT INTO categories (name, description) VALUES
('Politique', 'Actualités politiques et diplomatiques'),
('Militaire', 'Opérations militaires et défense'),
('Humanitaire', 'Aide humanitaire et réfugiés'),
('Économie', 'Impact économique et sanctions'),
('International', 'Réactions et relations internationales');

-- Articles exemples
INSERT INTO articles (title, content, meta_title, meta_description, status, view_count, image_url, created_at, updated_at) VALUES
(
    'Tensions croissantes au Moyen-Orient : analyse de la situation actuelle',
    '<p>La situation géopolitique au Moyen-Orient connaît une escalade significative ces dernières semaines. Les tensions entre les différentes puissances régionales continuent de façonner le paysage politique de la région.</p><p>Les experts en relations internationales soulignent l''importance du dialogue diplomatique pour éviter une escalade supplémentaire. Les Nations Unies ont appelé à la retenue de toutes les parties impliquées.</p><p>L''impact sur les populations civiles reste une préoccupation majeure pour les organisations humanitaires présentes sur le terrain.</p>',
    'Tensions au Moyen-Orient - Analyse géopolitique',
    'Analyse complète de la situation géopolitique actuelle au Moyen-Orient et des tensions croissantes dans la région.',
    'PUBLISHED', 245, NULL, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
),
(
    'Impact humanitaire : les réfugiés face à la crise',
    '<p>Le nombre de personnes déplacées continue d''augmenter dans la région, créant une crise humanitaire majeure. Les organisations internationales mobilisent des ressources considérables pour répondre aux besoins essentiels des populations affectées.</p><p>L''UNHCR rapporte que les camps de réfugiés dans les pays voisins atteignent leur capacité maximale. L''accès à l''eau potable, à la nourriture et aux soins médicaux reste un défi quotidien.</p><p>Les enfants sont particulièrement vulnérables dans ce contexte, avec des interruptions prolongées de leur scolarité et des traumatismes psychologiques importants.</p>',
    'Crise humanitaire - Réfugiés et déplacés',
    'Point sur la situation humanitaire et les défis auxquels font face les réfugiés et personnes déplacées.',
    'PUBLISHED', 189, NULL, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
),
(
    'Sanctions économiques : conséquences sur la population civile',
    '<p>Les sanctions économiques internationales ont un impact profond sur l''économie et la vie quotidienne des citoyens. L''inflation galopante et la dévaluation de la monnaie nationale affectent le pouvoir d''achat de millions de personnes.</p><p>Les secteurs de la santé et de l''éducation sont particulièrement touchés, avec des pénuries de médicaments et de matériel éducatif.</p>',
    'Sanctions économiques et impact civil',
    'Analyse de l''impact des sanctions économiques internationales sur la population civile.',
    'PUBLISHED', 132, NULL, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
),
(
    'Diplomatie internationale : les négociations en cours',
    '<p>Plusieurs rounds de négociations diplomatiques se poursuivent dans le but de trouver une résolution pacifique au conflit. Les grandes puissances mondiales sont impliquées dans ces discussions complexes.</p><p>Les pourparlers portent sur le programme nucléaire, les droits de l''homme et la stabilité régionale.</p>',
    'Négociations diplomatiques internationales',
    'Suivi des négociations diplomatiques en cours pour la résolution du conflit.',
    'DRAFT', 0, NULL, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP
);

-- Liaisons articles-catégories
INSERT INTO article_categories (article_id, category_id) VALUES
(1, 1), (1, 5),
(2, 3),
(3, 4), (3, 5),
(4, 1), (4, 5);
