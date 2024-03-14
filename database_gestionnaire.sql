DROP TABLE IF EXISTS employe, mdpuser;

CREATE TABLE employe (
    id SERIAL,
    nom VARCHAR(128) NOT NULL,
    mail VARCHAR(128) NOT NULL,
    mdp VARCHAR(128) NOT NULL,
    fonction VARCHAR(64),
    PRIMARY KEY (id)

);
CREATE TABLE mdpuser (
    id SERIAL,
    app VARCHAR(128) NOT NULL,
	identifiant VARCHAR(128) NOT NULL,
    mdp VARCHAR(128) NOT NULL,
    FOREIGN KEY (id) REFERENCES employe(id)
);

-- Insérer des données dans la table employe
INSERT INTO employe (id, nom, mail, mdp, fonction) VALUES
(1, 'John Doe', 'john.doe@example.com', 'motdepasse1', 'Manager'),
(2, 'Jane Smith', 'jane.smith@example.com', 'motdepasse2', 'Développeur'),
(3, 'Alice Johnson', 'alice.johnson@example.com', 'motdepasse3', 'Analyste'),
(4, 'Bob Williams', 'bob.williams@example.com', 'motdepasse4', 'Ingénieur'),
(5, 'Eva Davis', 'eva.davis@example.com', 'motdepasse5', 'Designer');

-- Insérer des données dans la table mdpuser
INSERT INTO mdpuser (id, app, identifiant, mdp) VALUES
(1, 'Application1', 'john.doe', 'motdepasse123'),
(1, 'Application2', 'joker', 'motdepasse456'),
(1, 'Application3', 'jojo', 'motdepasse789'),
(2, 'Application4', 'jay', 'motdepasse101'),
(3, 'Application5', 'alice', 'motdepasse202');
