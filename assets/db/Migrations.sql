CREATE TABLE IF NOT EXISTS utenti (
id int NOT NULL AUTO_INCREMENT,
nome varchar(45),
cognome varchar(45),
email varchar(255) UNIQUE,
password varchar(255),
token varchar(255) UNIQUE,
ruolo varchar(255),
PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS eventi (
id int NOT NULL AUTO_INCREMENT,
attendees text,
nome_evento varchar(255),
data_evento datetime,
descrizione text,
PRIMARY KEY (id)
);

INSERT INTO `eventi`(`attendees`, `nome_evento`, `data_evento`, `descrizione`) VALUES ('ulysses200915@varen8.com,qmonkey14@falixiao.com,mavbafpcmq@hitbase.net','Test Edusogno 1', '2022-10-13 14:00', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.'), ('dgipolga@edume.me,qmonkey14@falixiao.com,mavbafpcmq@hitbase.net','Test Edusogno 2', '2022-10-15 19:00', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.'), ('dgipolga@edume.me,ulysses200915@varen8.com,mavbafpcmq@hitbase.net','Test Edusogno 3', '2022-10-15 19:00', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.');

INSERT INTO `utenti`(`nome`, `cognome`, `email`, `password`, `ruolo`) VALUES ('Marco','Rossi', 'ulysses200915@varen8.com', 'Edusogno123', 'utente'), ('Filippo', 'D\'Amelio', 'qmonkey14@falixiao.com','Edusogno?123', 'utente'), ('Gian Luca', 'Carta', 'mavbafpcmq@hitbase.net', 'EdusognoCiao', 'utente'), ('Stella', 'De Grandis', 'dgipolga@edume.me', 'EdusognoGia', 'admin');