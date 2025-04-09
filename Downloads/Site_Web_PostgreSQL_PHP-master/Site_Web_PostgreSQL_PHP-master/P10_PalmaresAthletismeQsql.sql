CREATE TABLE IF NOT EXISTS Sport(
	Sport_Id SERIAL,
	Sport_Catégorie VARCHAR(100) NOT NULL,
	Sport_Type VARCHAR (100) NOT NULL,
	PRIMARY KEY (Sport_Id)
);
CREATE TABLE IF NOT EXISTS Athlète(
	Athlète_Id SERIAL,
	Athlète_Nom VARCHAR(200) NOT NULL,
	Athlète_Prénom VARCHAR(200) NOT NULL,
	Athlète_Nationalité VARCHAR(100) NOT NULL,
	Athlète_Sexe VARCHAR(100) NOT NULL CHECK(Athlète_Sexe IN('Homme','Femme')),
	PRIMARY KEY (Athlète_Id)

);
CREATE TABLE IF NOT EXISTS Pratique(
	Sport_Id INTEGER,
	Athlète_Id INTEGER,
	PRIMARY KEY (Sport_Id, athlète_Id),
	FOREIGN KEY (Sport_Id) REFERENCES Sport(Sport_Id),
	FOREIGN KEY (Athlète_Id) REFERENCES Athlète(Athlète_Id)

);
INSERT INTO Sport(Sport_Catégorie, Sport_Type)
           Values('Sprint', '100m H'),
                 ('Sprint', '100m F'),
                 ('Haies', '400m H'),
                 ('Haies', '400m F'),
                 ('Fond', '10 000m H'),
                 ('Fond', '10 000m F'),
                 ('Lancer', 'Disque H'),
                 ('Lancer', 'Disque F'),
                 ('Saut', 'Saut en longueur H'),
                 ('Saut', 'Saut en longueur F'),
                 ('Epreuve combinée', 'Heptathlon'),
                 ('Natation', '200m Brasse F');

INSERT INTO athlète(Athlète_Nom, Athlète_Prénom, Athlète_Nationalité, Athlète_Sexe)
            Values ('Bolt', 'Usain', 'Jamaïcaine', 'Homme'),
                   ('Gatlin', 'Justin', 'Américain', 'Homme'),
                   ('De Grasse', 'Andre', 'Canadienne', 'Homme'),

                   ('Thompson-Herah', 'Elaine', 'jamaïcaine', 'Femme'),
                   ('Bowie', 'Tori', 'Américaine', 'Femme'),
                   ('Fraser-Pryce', 'Shelly-Ann', 'jamaïcaine', 'Femme'),

                   ('Clement', 'Kerron', 'Américaine', 'Homme'),
                   ('Mucheru Tumuti', 'Boniface', 'Kényan', 'Homme'),
                   ('Copello', 'Yasmani', 'Turque', 'Homme'),

                   ('Muhammad', 'Dalilah', 'Américaine', 'Femme'),
                   ('Slott Petersen', 'Sara', 'Danoise', 'Femme'),
                   ('Spencer', 'Ashley', 'Américaine', 'Femme'),

                   ('Farah', 'Mohamed', 'Britannique', 'Homme'),
                   ('Kipngetich Tanui', 'Paul', 'kényan', 'Homme'),
                   ('Tola', 'Tamirat', 'Ethiopien', 'Homme'),

                   ('Ayana', 'Almaz', 'Ethiopienne', 'Femme'),
                   ('Jepkemoi Cheruiyot', 'Vivian', 'kényan','Femme'),
                   ('Dibaba', 'Tirunesh', 'Ethiopienne', 'Femme'),

                   ('Harting', 'Christoph', 'Allemand', 'Homme'),
                   ('Malachowski', 'Piotr', 'Polonais', 'Homme'),
                   ('Jasinski', 'Daniel', 'Allemand', 'Homme'),

                   ('Perkovic', 'Sandra', 'Croate', 'Femme'),
                   ('Robert-Michon', 'Melina', 'Française', 'Femme'),
                   ('Caballero', 'Denia', 'Cubaine', 'Femme'),

                   ('Henderson', 'Jeff', 'Américain', 'Homme'),
                   ('Manyonga', 'Luvo', 'Sud-africain', 'Homme'),
                   ('Rutherford', 'Greg', 'Britannique', 'Homme'),

                   ('Bartoletta', 'Tianna', 'Américaine', 'Femme'),
                   ('Reese', 'Brittney', 'Américaine', 'Femme'),
                   ('Spanovic', 'Ivana', 'Serbe', 'Femme'),

                   ('Thiam', 'Nafissatou', 'Belge', 'Femme'),
                   ('Ennis', 'Jessica', 'Britannique', 'Femme'),
                   ('Theisen', 'Brianne', 'Canadienne', 'Femme'),
                   
                   ('Kaneto', 'Rie', 'Japonaise', 'Femme'),
		           ('Efimova', 'Yuliya', 'Russe', 'Femme'),
		           ('Shi', 'Jinglin', 'Chinoise', 'Femme');



INSERT INTO Pratique(Sport_Id, Athlète_Id)
              Values((SELECT Sport_Id FROM Sport WHERE Sport_Type = '100m H'), (SELECT Athlète_Id FROM Athlète WHERE Athlète_Nom = 'Bolt')),
                      ((SELECT Sport_Id FROM Sport WHERE Sport_Type = '100m H'), (SELECT Athlète_Id FROM Athlète WHERE Athlète_Nom ='Gatlin')),
                      ((SELECT Sport_Id FROM Sport WHERE Sport_Type = '100m H'), (SELECT Athlète_Id FROM Athlète WHERE Athlète_Nom = 'De Grasse')),

                      ((SELECT Sport_Id FROM Sport WHERE Sport_Type = '100m F'), (SELECT Athlète_Id FROM Athlète WHERE Athlète_Nom = 'Thompson-Herah')),
                      ((SELECT Sport_Id FROM Sport WHERE Sport_Type = '100m F'), (SELECT Athlète_Id FROM Athlète WHERE Athlète_Nom ='Bowie')),
                      ((SELECT Sport_Id FROM Sport WHERE Sport_Type = '100m F'), (SELECT Athlète_Id FROM Athlète WHERE Athlète_Nom = 'Fraser-Pryce')),

                      ((SELECT Sport_Id FROM Sport WHERE Sport_Type = '400m H'), (SELECT Athlète_Id FROM Athlète WHERE Athlète_Nom = 'Clement')),
                      ((SELECT Sport_Id FROM Sport WHERE Sport_Type = '400m H'), (SELECT Athlète_Id FROM Athlète WHERE Athlète_Nom ='Mucheru Tumuti')),
                      ((SELECT Sport_Id FROM Sport WHERE Sport_Type = '400m H'), (SELECT Athlète_Id FROM Athlète WHERE Athlète_Nom = 'Copello')),
                      

                      ((SELECT Sport_Id FROM Sport WHERE Sport_Type = '400m F'), (SELECT Athlète_Id FROM Athlète WHERE Athlète_Nom = 'Muhammad')),
                      ((SELECT Sport_Id FROM Sport WHERE Sport_Type = '400m F'), (SELECT Athlète_Id FROM Athlète WHERE Athlète_Nom ='Slott Petersen')),
                      ((SELECT Sport_Id FROM Sport WHERE Sport_Type = '400m F'), (SELECT Athlète_Id FROM Athlète WHERE Athlète_Nom = 'Spencer' )),

                      ((SELECT Sport_Id FROM Sport WHERE Sport_Type = '10 000m H'), (SELECT Athlète_Id FROM Athlète WHERE Athlète_Nom = 'Farah')),
                      ((SELECT Sport_Id FROM Sport WHERE Sport_Type = '10 000m H'), (SELECT Athlète_Id FROM Athlète WHERE Athlète_Nom ='Kipngetich Tanui')),
                      ((SELECT Sport_Id FROM Sport WHERE Sport_Type = '10 000m H'), (SELECT Athlète_Id FROM Athlète WHERE Athlète_Nom = 'Tola' )),

                      ((SELECT Sport_Id FROM Sport WHERE Sport_Type = '10 000m F'), (SELECT Athlète_Id FROM Athlète WHERE Athlète_Nom = 'Ayana')),
                      ((SELECT Sport_Id FROM Sport WHERE Sport_Type = '10 000m F'), (SELECT Athlète_Id FROM Athlète WHERE Athlète_Nom ='Jepkemoi Cheruiyot')),
                      ((SELECT Sport_Id FROM Sport WHERE Sport_Type = '10 000m F'), (SELECT Athlète_Id FROM Athlète WHERE Athlète_Nom = 'Dibaba' )),

                      ((SELECT Sport_Id FROM Sport WHERE Sport_Type = 'Disque H'), (SELECT Athlète_Id FROM Athlète WHERE Athlète_Nom = 'Harting')),
                      ((SELECT Sport_Id FROM Sport WHERE Sport_Type = 'Disque H'), (SELECT Athlète_Id FROM Athlète WHERE Athlète_Nom ='Malachowski')),
                      ((SELECT Sport_Id FROM Sport WHERE Sport_Type = 'Disque H'), (SELECT Athlète_Id FROM Athlète WHERE Athlète_Nom = 'Jasinski')),

                      ((SELECT Sport_Id FROM Sport WHERE Sport_Type = 'Disque F'), (SELECT Athlète_Id FROM Athlète WHERE Athlète_Nom = 'Perkovic')),
                      ((SELECT Sport_Id FROM Sport WHERE Sport_Type = 'Disque F'), (SELECT Athlète_Id FROM Athlète WHERE Athlète_Nom ='Robert-Michon')),
                      ((SELECT Sport_Id FROM Sport WHERE Sport_Type = 'Disque F'), (SELECT Athlète_Id FROM Athlète WHERE Athlète_Nom = 'Caballero' )),

                      ((SELECT Sport_Id FROM Sport WHERE Sport_Type = 'Saut en longueur H'), (SELECT Athlète_Id FROM Athlète WHERE Athlète_Nom = 'Henderson')),
                      ((SELECT Sport_Id FROM Sport WHERE Sport_Type = 'Saut en longueur H'), (SELECT Athlète_Id FROM Athlète WHERE Athlète_Nom ='Manyonga')),
                      ((SELECT Sport_Id FROM Sport WHERE Sport_Type = 'Saut en longueur H'), (SELECT Athlète_Id FROM Athlète WHERE Athlète_Nom = 'Rutherford')),

                      ((SELECT Sport_Id FROM Sport WHERE Sport_Type = 'Saut en longueur F'), (SELECT Athlète_Id FROM Athlète WHERE Athlète_Nom = 'Bartoletta')),
                      ((SELECT Sport_Id FROM Sport WHERE Sport_Type = 'Saut en longueur F'), (SELECT Athlète_Id FROM Athlète WHERE Athlète_Nom ='Reese')),
                      ((SELECT Sport_Id FROM Sport WHERE Sport_Type = 'Saut en longueur F'), (SELECT Athlète_Id FROM Athlète WHERE Athlète_Nom = 'Spanovic')),

                      ((SELECT Sport_Id FROM Sport WHERE Sport_Type = 'Heptathlon'), (SELECT Athlète_Id FROM Athlète WHERE Athlète_Nom = 'Thiam')),
                      ((SELECT Sport_Id FROM Sport WHERE Sport_Type = 'Heptathlon'), (SELECT Athlète_Id FROM Athlète WHERE Athlète_Nom ='Ennis')),
                      ((SELECT Sport_Id FROM Sport WHERE Sport_Type = 'Heptathlon'), (SELECT Athlète_Id FROM Athlète WHERE Athlète_Nom = 'Theisen')),
                      
                      ((SELECT Sport_Id From Sport WHERE Sport_Type = '200m Brasse F'), (SELECT Athlète_Id FROM Athlète WHERE Athlète_Nom = 'Kaneto')),
		              ((SELECT Sport_Id From Sport WHERE Sport_Type = '200m Brasse F'), (SELECT Athlète_Id FROM Athlète WHERE Athlète_Nom = 'Efimova')),
		              ((SELECT Sport_Id From Sport WHERE Sport_Type = '200m Brasse F'), (SELECT Athlète_Id FROM Athlète WHERE Athlète_Nom = 'Shi'));
