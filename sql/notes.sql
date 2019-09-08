DROP DATABASE IF EXISTS notes_app;

CREATE DATABASE notes_app CHARACTER SET UTF8MB4;

USE notes_app;

CREATE TABLE users (
	user_id INT AUTO_INCREMENT,
	user_email VARCHAR(100) NOT NULL UNIQUE,
	user_password VARCHAR(200) NOT NULL COMMENT 'Generated Hash with PHP',
	user_firstname VARCHAR(50) NOT NULL,
	user_lastname VARCHAR(50) NOT NULL,
	CONSTRAINT PK_users PRIMARY KEY(user_id, user_email)
);

CREATE TABLE notes (
	note_id INT PRIMARY KEY AUTO_INCREMENT,
	note_user INT,
	note_name VARCHAR(50) NOT NULL,
	note_body VARCHAR(200),
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	CONSTRAINT FK_notes_users FOREIGN KEY(note_user) 
	REFERENCES users(user_id)
	ON DELETE CASCADE
);

INSERT INTO users(user_email, user_password, user_firstname, user_lastname) VALUES
('borisbelmarm@gmail.com', 'bbelmar123', 'Boris', 'Belmar');

INSERT INTO notes(note_user, note_name, note_body) VALUES
(1, 'Primera nota', 'Nota con cuerpo'),
(1, 'Segunda nota', '');

UPDATE notes 
SET note_body = 'Agregamos una nota', updated_at = CURRENT_TIMESTAMP 
WHERE note_id = 2;