
CREATE TABLE pokemon
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
  PRIMARY KEY (id)
);

ALTER TABLE pokemon
  ADD CONSTRAINT UQ_pokemon_nome UNIQUE (nome);

CREATE TABLE usuario
(
  id       INT          NOT NULL AUTO_INCREMENT,
  nome     VARCHAR(128) NOT NULL,
  username VARCHAR(16)  NOT NULL,
  email    VARCHAR(320) NOT NULL,
  senha    CHAR(60)     NOT NULL,
  tokens   INT          NULL     DEFAULT 0,
  PRIMARY KEY (id)
);

ALTER TABLE usuario
  ADD CONSTRAINT UQ_usuario_username UNIQUE (username);

ALTER TABLE usuario
  ADD CONSTRAINT UQ_usuario_email UNIQUE (email);
