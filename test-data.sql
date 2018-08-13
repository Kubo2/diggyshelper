--liquibase formatted sql
--
-- Diggy's Helper Database Test Unit
-- This is the test data for local dh development.
-- 

/*
use skdiggyshelper;
*/

-- Some mysterious users
--changeset Kubo2:users-data-1
INSERT INTO `users` (
	`id`, `username`, `password`, `registerdate`, `email`, `description`
) VALUES (
	1, 'Kubo2', MD5('heslo123'), NOW(), 'kelerest123@gmail.com', 'Spoluzakladateľ projektu DH + softwarový manažér'
), (
	2, 'Administrátor', MD5('admin'), NOW(), 'admin@localhost', 'Administrátor diskusného fóra'
), (
	3, 'WladinQ', MD5('heslo'), NOW(), 'vladimir.jacko.ml@gmail.com', 'Zakladateľ DH'
), (
	4, 'Example', MD5('example'), NOW(), 'example@example.com', NULL
);

--rollback TRUNCATE TABLE `users`;


--changeset Kubo2:users-administrators-1
UPDATE `users` SET
	`access` = 'admin'
WHERE `username` IN (
	'Kubo2', 'WladinQ', 'Administrátor'
);

--rollback UPDATE `users` SET `access` = 'member' WHERE `username` IN ('Kubo2', 'Administrátor');

-- Example categories
--changeset Kubo2:category1
INSERT INTO `categories` (
	`id`, `category_title`, `category_description`
) VALUES (
	1, 'Testy', 'Testy prispievania a podobnej funkcionality'
), (
	2, 'Kategória 2', 'ľubovolné debaty na ľubovoľné témy'
);

--rollback TRUNCATE TABLE `categories`;

-- Dummy topics (threads).
--changeset Kubo2:topic1
INSERT INTO `topics` (
	`topic_title`, `category_id`, `topic_creator`, `topic_date`, `topic_reply_date`
) VALUES (
	'Testovacie vlákno', 1, 2, NOW(), NOW()
), (
	'Debata 1', 2, 1, NOW(), NOW()
);

--rollback TRUNCATE TABLE `topics`;

--changeset Kubo2:posts-1
INSERT INTO `posts` (
	`category_id`, `topic_id`, `post_creator`, `post_content`, `post_date`
) VALUES (
	1, 1, 2, 'Sledujeme týmto používanie beta-verzie diskusného fóra.', NOW()
), (
	2, 2, 1, 'Počiatočný príspevok debaty', NOW()
);

--rollback   /* FUCK IT! depends on topic existence*/ 

--changeset Kubo2:images-1
TRUNCATE TABLE `images`;
