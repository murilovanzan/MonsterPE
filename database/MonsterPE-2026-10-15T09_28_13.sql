
CREATE DATABASE IF NOT EXISTS MonsterPE;
USE MonsterPE;

SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;

CREATE TABLE IF NOT EXISTS pokemon
(
  id        INT          NOT NULL AUTO_INCREMENT,
  nome      VARCHAR(12)  NOT NULL,
  descricao VARCHAR(255) NOT NULL,
  geracao   INT          NOT NULL,
  hp        INT          NOT NULL,
  speed     INT          NOT NULL,
  attack    INT          NOT NULL,
  spAttack  INT          NOT NULL,
  defense   INT          NOT NULL,
  spDefense INT          NOT NULL,
  PRIMARY KEY (id),
  CONSTRAINT UQ_pokemon_nome UNIQUE (nome)
);

CREATE TABLE IF NOT EXISTS usuario
(
  id       INT          NOT NULL AUTO_INCREMENT,
  nome     VARCHAR(128) NOT NULL,
  username VARCHAR(16)  NOT NULL,
  email    VARCHAR(320) NOT NULL,
  senha    CHAR(60)     NOT NULL,
  tokens   INT          NULL     DEFAULT 0,
  adm    BOOLEAN      NOT NULL DEFAULT 0,
  foto     VARCHAR(128) NULL    ,
  PRIMARY KEY (id),
  CONSTRAINT UQ_usuario_username UNIQUE (username),
  CONSTRAINT UQ_usuario_email UNIQUE (email),
  CONSTRAINT UQ_usuario_admin UNIQUE (admin)
);

SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
