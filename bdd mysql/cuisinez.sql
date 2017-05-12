-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Dim 30 Avril 2017 à 13:56
-- Version du serveur :  5.7.11
-- Version de PHP :  5.6.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `cuisinez`
--

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

CREATE TABLE `commentaire` (
  `id` int(11) NOT NULL,
  `idU` int(11) NOT NULL DEFAULT '0',
  `idR` int(11) NOT NULL DEFAULT '0',
  `contenu` varchar(250) DEFAULT NULL,
  `note` int(1) DEFAULT NULL,
  `date` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `ingredient`
--

CREATE TABLE `ingredient` (
  `id` int(11) NOT NULL,
  `label_ingredient` varchar(50) CHARACTER SET utf8 NOT NULL,
  `type_ingredient` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `ingredient`
--

INSERT INTO `ingredient` (`id`, `label_ingredient`, `type_ingredient`) VALUES
(1, 'lardon', 1),
(2, 'salade', 2),
(3, 'boeuf', 1),
(4, 'carotte', 2),
(5, 'radis', 2),
(6, 'poivre', 4),
(7, 'truite', 3),
(8, 'saumon', 3),
(9, 'riz', 2),
(10, 'lait', 4),
(11, 'sucre', 4),
(12, 'sucre vanillé', 4),
(13, 'zeste de citron', 4),
(14, 'citron', 5);

-- --------------------------------------------------------

--
-- Structure de la table `ligne_recette`
--

CREATE TABLE `ligne_recette` (
  `id` int(11) NOT NULL,
  `quantite` varchar(7) CHARACTER SET utf8 NOT NULL,
  `id_ingredient` int(11) NOT NULL,
  `id_recette` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `ligne_recette`
--

INSERT INTO `ligne_recette` (`id`, `quantite`, `id_ingredient`, `id_recette`) VALUES
(25, '150g', 9, 1),
(26, '5', 8, 1),
(103, '100g', 9, 2),
(104, '1L', 10, 2),
(105, '10', 11, 2),
(106, '1', 12, 2),
(107, '1', 13, 2);

-- --------------------------------------------------------

--
-- Structure de la table `recette`
--

CREATE TABLE `recette` (
  `id` int(11) NOT NULL,
  `id_auteur` int(11) NOT NULL,
  `label_recette` varchar(100) CHARACTER SET utf8 NOT NULL,
  `description_recette` text CHARACTER SET utf8 NOT NULL,
  `temps_recette` int(11) NOT NULL,
  `image` varchar(50) DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `recette`
--

INSERT INTO `recette` (`id`, `id_auteur`, `label_recette`, `description_recette`, `temps_recette`, `image`, `date`) VALUES
(1, 1, 'Riz au saumon', '<h4>Préparation de la recette :</h4>\r\n<br>\r\nPréparer d\'abord le riz vapeur : laver 3 1/3 tasses de riz à l\'eau froide et laisser égoutter pendant 1 heure.<br>Mettre le riz dans une casserole, verser 1 litre d\'eau, porter à ébullition sur feu moyen, couvrir et cuire à feu vif pendant 2 mn. Réduire le feu au minimum et continuer la cuisson 20 mn.<br> <br>Ouvrir, déposer un linge sur le riz, refermer et laisser reposer 15 mn. <br>Finition du riz pour les sushi et les maki:<br>dans une petite casserole, verser 6 cuillères à soupe de vinaigre de riz, 5 cuillères à soupe de sucre et 4 cuillères à café de sel. Faire chauffer quelques secondes pour faire dissoudre le sucre.<br>Verser doucement le vinaigre de riz dans le riz cuit encore chaud, mélanger et détacher les grains doucement à l\'aide de baguettes. <br>Ensuite, au travail ! Le principe de base est de <br>former de petites boules de riz préparé à sushi - chacune équivalent à 50 ml. Appliquer une très légère pointe de wasabi entre le riz et le poisson. Déposer dans la main, <br>mettre le poisson et autres préparations dessus, <br>mouler doucement le poisson sur le riz en aplatissant le tout. Déposer sur un plateau.<br>Enrouler un morceau de feuille de nori autour (facultatif).<br>Nouer une tige de ciboule pour faire de chaque sushi un petit cadeau (facultatif).<br><b>Sushi au saumon&nbsp;:</b><br>Tailler le poisson cru en fines tranches qui épouse la forme de feuille ou de pétale. Déposer sur 4 boules de riz aplaties en longueur en forme de feuille - soit une extrémité ronde et une extrémité pointue.<br>Présenter dans une assiette 4 sushis - les 4 extrémités rondes doivent se toucher au centre de l\'assiette. Saupoudrer le centre d\'un jaune d\'oeuf cuit dur et émietté pour symboliser le pollen de la fleur.<br>Servir avec du gingembre mariné, du wasabi et de la sauce soja.<br>\r\n<div class="m_content_recette_ps">\r\n	\r\n	<h4>Remarques :</h4>\r\n	<p>C\'est une recette originale. Après votre talent et les produits feront la différence.\r\nAttention à la cuisson du riz, je pense que c\'est le plus important.\r\n\r\nPersonnellement, je mets les sushi au congélateur 10 mn avant de les servir pour donner de la fermeté au riz.\r\n\r\nAttention : il est indispensable de demander conseil à votre poissonnier ou à un spcialiste pour éviter tout problème lié au poisson cru!!!</p>\r\n	\r\n</div>\r\n', 15, 'images/pics1.jpg', '2016-03-03 23:59:57'),
(2, 1, 'Riz au lait', '<h4>Préparation de la recette (modif chrome) :</h4>\r\n<br>\r\nFaire bouillir le lait avec le sucre, le sucre vanillé et le zeste de votre choix (attention faire un ruban assez long pour le retirer facilement en fin de cuisson). <br>Lorsque le lait bout, jeter le riz en pluie et baisser le feu pour que l\'ébullition soit très lente, le riz doit cuire très lentement. <br>Lorque le riz affleure le lait, couper le feu et laisser refroidir ; le riz va finir de s\'imbiber de lait en refroidissant. <br>On peut servir ce dessert tiède ou froid dans des ramequins avec un zeste de citron vert pour décorer le dessus.<br>\r\n<div class="m_content_recette_ps">\r\n	\r\n	<h4>Remarques :</h4>\r\n	<p>Pour plus de parfum on peut laisser infuser un bâton de cannelle dans le lait tout le long de la préparation. \r\nOn peut également ajouter des fruits confits, c\'est bon et c\'est joli pour les enfants.</p>\r\n	\r\n</div>\r\n', 55, 'images/recette_2.jpg', '2016-03-04 00:22:05');

-- --------------------------------------------------------

--
-- Structure de la table `type_ingredient`
--

CREATE TABLE `type_ingredient` (
  `id` int(11) NOT NULL,
  `label_type_ingredient` varchar(50) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `type_ingredient`
--

INSERT INTO `type_ingredient` (`id`, `label_type_ingredient`) VALUES
(1, 'viandes'),
(2, 'légumes'),
(3, 'poissons'),
(4, 'autre'),
(5, 'fruits');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id` int(11) NOT NULL,
  `pseudo` varchar(30) NOT NULL,
  `pass` varchar(35) NOT NULL,
  `droits` varchar(20) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `pseudo`, `pass`, `droits`) VALUES
(1, 'max', '2ffe4e77325d9a7152f7086ea7aa5114', 'admin');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idR` (`idR`);

--
-- Index pour la table `ingredient`
--
ALTER TABLE `ingredient`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type_ingredient` (`type_ingredient`);

--
-- Index pour la table `ligne_recette`
--
ALTER TABLE `ligne_recette`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_ingredient` (`id_ingredient`),
  ADD KEY `id_recette` (`id_recette`);

--
-- Index pour la table `recette`
--
ALTER TABLE `recette`
  ADD PRIMARY KEY (`id`),
  ADD KEY `INDEX_USER` (`id_auteur`);

--
-- Index pour la table `type_ingredient`
--
ALTER TABLE `type_ingredient`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `commentaire`
--
ALTER TABLE `commentaire`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT pour la table `ingredient`
--
ALTER TABLE `ingredient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT pour la table `ligne_recette`
--
ALTER TABLE `ligne_recette`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;
--
-- AUTO_INCREMENT pour la table `recette`
--
ALTER TABLE `recette`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT pour la table `type_ingredient`
--
ALTER TABLE `type_ingredient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD CONSTRAINT `FK_RECETTE` FOREIGN KEY (`idR`) REFERENCES `recette` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `ingredient`
--
ALTER TABLE `ingredient`
  ADD CONSTRAINT `FOREIGNKEY_1` FOREIGN KEY (`type_ingredient`) REFERENCES `type_ingredient` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `ligne_recette`
--
ALTER TABLE `ligne_recette`
  ADD CONSTRAINT `FOREIGNKEY_2` FOREIGN KEY (`id_ingredient`) REFERENCES `ingredient` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FOREIGNKEY_3` FOREIGN KEY (`id_recette`) REFERENCES `recette` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `recette`
--
ALTER TABLE `recette`
  ADD CONSTRAINT `FK_AUTEUR` FOREIGN KEY (`id_auteur`) REFERENCES `utilisateur` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
