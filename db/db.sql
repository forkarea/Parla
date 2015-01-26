/****************************************
 *
 * Author: Piotr Sroczkowski
 *
 ****************************************/

DROP TABLE IF EXISTS messages;
CREATE TABLE messages (
  id int(11) NOT NULL AUTO_INCREMENT,
  text varchar(1024) DEFAULT NULL,
  sender int(11) DEFAULT NULL,
  receiver int(11) DEFAULT NULL,
  time datetime DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS users;
CREATE TABLE users (
  id int(11) NOT NULL AUTO_INCREMENT,
  name char(16) DEFAULT NULL,
  city char(255) DEFAULT NULL,
  country char(255) DEFAULT NULL,
  birth date DEFAULT NULL,
  gender enum('m', 'f', 'n') DEFAULT 'n',
  orientation enum('hetero', 'homo', 'bi', 'a') DEFAULT NULL,
  about text DEFAULT NULL,
  mykey char(255) DEFAULT NULL,
  password char(255) DEFAULT NULL,
  mail char(255) DEFAULT NULL,
  photo char(255) DEFAULT NULL,
  verified tinyint(1) DEFAULT 0,
  last_notified timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS verif_codes;
CREATE TABLE verif_codes (
  id int(11) NOT NULL AUTO_INCREMENT,
  user_id int(11) NOT NULL,
  code varchar(255) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS emails;
CREATE TABLE emails (
  email varchar(255) DEFAULT NULL,
  is_correct tinyint(1) DEFAULT 1,
  PRIMARY KEY (email)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TRIGGER IF EXISTS modii;
DELIMITER DELIM
CREATE TRIGGER modii BEFORE INSERT ON messages FOR EACH ROW
BEGIN
    SET NEW.time = NOW();
END;
DELIM
DELIMITER ;

DROP TRIGGER IF EXISTS modiu;
DELIMITER DELIM
CREATE TRIGGER modiu BEFORE UPDATE ON messages FOR EACH ROW
BEGIN
    SET NEW.time = NOW();
END;
DELIM
DELIMITER ;
