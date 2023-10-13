--
-- create database
--

CREATE DATABASE randonnees CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;


--
-- Structure de la table `administrateur`
--

CREATE TABLE `administrateur` (
  `id` int(11) UNSIGNED PRIMARY KEY AUTO_INCREMENT NOT NULL,
  `login_administrateur` varchar(255) UNIQUE NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `tel` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Structure de la table `difficultes`
--

CREATE TABLE `difficultes` (
  `id` int(11) UNSIGNED PRIMARY KEY AUTO_INCREMENT NOT NULL,
  `difficulte` varchar(255) UNIQUE NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



--
-- Structure de la table `environnement`
--

CREATE TABLE `environnement` (
  `id` int(11) UNSIGNED PRIMARY KEY AUTO_INCREMENT NOT NULL,
  `environnement` varchar(255) UNIQUE NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



--
-- Structure de la table `randonnees`
--

CREATE TABLE `randonnees` (
  `id_randonnes` int(11) UNSIGNED PRIMARY KEY AUTO_INCREMENT NOT NULL,
  `distance` int(4) UNSIGNED NOT NULL,
  `duree` float(10,2) NOT NULL,
  `denivele` int(4) UNSIGNED NOT NULL,
  `id_region` int(11) UNSIGNED NOT NULL,
  `id_environnement` int(1) UNSIGNED NOT NULL,
  `id_difficulte` int(1) UNSIGNED NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Structure de la table `regions`
--

CREATE TABLE `regions` (
  `id` int(11) UNSIGNED PRIMARY KEY AUTO_INCREMENT  NOT NULL,
  `region` varchar(255) UNIQUE NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `contact_us` (
  `id` int(11) UNSIGNED PRIMARY KEY AUTO_INCREMENT NOT NULL,
  `nom` varchar(255) UNIQUE NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `activite` varchar(255) NOT NULL,
  `fonction` varchar(255) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `ville` varchar(255) NOT NULL,
  `tel` varchar(255) NOT NULL,
  `objet` varchar(255) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



--
-- Contenu de la table `administrateur`
--

INSERT INTO `administrateur` (`id`, `login_administrateur`, `mot_de_passe`, `image`, `nom`, `prenom`, `adresse`, `tel`) VALUES
(NULL, 'hafsa', '123456', 'image/image', 'ismaili', 'hafsa', '111111111', 'marrakech alhamrae');


--
-- Contenu de la table `difficultes`
--

INSERT INTO `difficultes` (`id`, `difficulte`) VALUES
(NULL, 'difficile'),
(NULL, 'facile'),
(NULL, 'moyen');


--
-- Contenu de la table `environnement`
--

INSERT INTO `environnement` (`id`, `environnement`) VALUES
(NULL, 'compagne'),
(NULL, 'mer'),
(NULL, 'lac'),
(NULL, 'parc'),
(NULL, 'montagne');



--
-- Contenu de la table `regions`
--

INSERT INTO `regions` (`id`, `region`) VALUES
(NULL, 'ouest'),
(NULL, 'est'),
(NULL, 'sud'),
(NULL, 'nord'),


