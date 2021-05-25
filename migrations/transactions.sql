USE vanilla;

CREATE TABLE transactions (
     id INT NOT NULL AUTO_INCREMENT,
     type TINYINT NULL,
     amount DECIMAL (10, 2),
     PRIMARY KEY (id)
);
