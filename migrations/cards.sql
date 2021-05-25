USE vanilla;

CREATE TABLE cards (
    id INT NOT NULL AUTO_INCREMENT,
    holderName VARCHAR (255) NOT NULL UNIQUE,
    pin VARCHAR (127),
    sold DECIMAL (10, 2),
    PRIMARY KEY (id)
);
