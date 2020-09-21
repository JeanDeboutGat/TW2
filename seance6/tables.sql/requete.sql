--insert into equipes (couleur, nom) values ('orange', 'Nouvelle Équipe');

--insert into coureurs (nom,dossard,equipe,taille) values ('Prince2laForet','10','Nouvelle Équipe','182');

--insert into coureurs values ('1010','Sirene2laForet','Nouvelle Équipe','179');

--UPDATE coureurs
--SET taille = taille - 1
--WHERE equipe = 'PicsouBank';

--UPDATE equipes
--SET directeur = 'Archibald'
--WHERE directeur is null;

-- 
-- Structure de la table etape
-- 

--	CREATE TABLE etape (
--	dossard integer,
--	arrivee time
--	);

-- 
-- Contenu de la table coureurs
-- 

--INSERT INTO etape (dossard) values (10);
--INSERT INTO etape (arrivee) values (time '20:30:17');

--UPDATE etape 
--SET arrivee = '17:20:30'
--WHERE dossard = 10;

--UPDATE etape
--SET dossard = 1010
--WHERE arrivee = time'20:30:17';
