
CREATE DATABASE IF NOT EXISTS monsterpe;
USE monsterpe;

SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
CREATE TABLE IF NOT EXISTS usuario
(
  id       INT          NOT NULL AUTO_INCREMENT,
  nome     VARCHAR(128) NOT NULL,
  username VARCHAR(16)  NOT NULL,
  email    VARCHAR(320) NOT NULL,
  senha    CHAR(60)     NOT NULL,
  tokens   INT          NOT NULL DEFAULT 0,
  adm      BOOLEAN      NOT NULL DEFAULT 0,
  foto     VARCHAR(128) NULL    ,
  PRIMARY KEY (id),
  CONSTRAINT UQ_usuario_username UNIQUE (username),
  CONSTRAINT UQ_usuario_email UNIQUE (email)
);

CREATE TABLE IF NOT EXISTS pokemon
(
  id         INT         NOT NULL AUTO_INCREMENT,
  usuario_id INT         NOT NULL,
  pokemon    VARCHAR(38) NOT NULL,
  hp         INT         NOT NULL,
  speed      INT         NOT NULL,
  attack     INT         NOT NULL,
  spAttack   INT         NOT NULL,
  defense    INT         NOT NULL,
  spDefense  INT         NOT NULL,
  posicao    INT         NOT NULL,
  item       VARCHAR(31) NULL    ,
  status     VARCHAR(10) NULL    ,
  PRIMARY KEY (id),
  CONSTRAINT FK_usuario_TO_pokemon
    FOREIGN KEY (usuario_id)
    REFERENCES usuario (id)
);

CREATE TABLE IF NOT EXISTS usuario_item
(
  id         INT         NOT NULL AUTO_INCREMENT,
  usuario_id INT         NOT NULL,
  url        VARCHAR(31) NOT NULL,
  PRIMARY KEY (id),
  CONSTRAINT FK_usuario_TO_usuario_item
    FOREIGN KEY (usuario_id)
    REFERENCES usuario (id)
);

INSERT INTO usuario (nome, username, email, senha, adm)
VALUES ("admin", "admin", "murilovanzandasilva@gmail.com", "$2y$10$Is5WEHHrza8dYLZNUMeVLuCOboGXJWGsZEPNGRBakqFnV144.LYNu", 1);

SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
