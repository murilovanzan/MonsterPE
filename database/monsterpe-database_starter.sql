
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
  id         char(36)    NOT NULL,
  usuario_id INT         NOT NULL,
  api_id     VARCHAR(38) NOT NULL,
  apelido    VARCHAR(12) NOT NULL,
  nivel      INT         NOT NULL DEFAULT 1,
  hp         INT         NOT NULL,
  speed      INT         NOT NULL,
  attack     INT         NOT NULL,
  spAttack   INT         NOT NULL,
  defense    INT         NOT NULL,
  spDefense  INT         NOT NULL,
  posicao    INT         NULL    ,
  item       VARCHAR(31) NULL    ,
  status     VARCHAR(10) NULL    ,
  ativo      BOOLEAN     NOT NULL DEFAULT 1,
  PRIMARY KEY (id),
  CONSTRAINT FK_usuario_TO_pokemon
    FOREIGN KEY (usuario_id)
    REFERENCES usuario (id)
);

CREATE TABLE IF NOT EXISTS pokemon_moves
(
  move_id    INT      NOT NULL,
  pokemon_id char(36) NOT NULL,
  posicao    INT      NOT NULL,
  PRIMARY KEY (move_id, pokemon_id),
  CONSTRAINT FK_pokemon_TO_pokemon_moves
    FOREIGN KEY (pokemon_id)
    REFERENCES pokemon (id)
    ON DELETE CASCADE
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