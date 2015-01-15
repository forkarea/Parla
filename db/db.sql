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
  time datetime DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS users;
CREATE TABLE users (
  id int(11) NOT NULL AUTO_INCREMENT,
  name char(255) DEFAULT NULL,
  mykey char(255) DEFAULT NULL,
  password char(255) DEFAULT NULL,
  photo char(255) DEFAULT NULL,
  last_notified timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;

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
