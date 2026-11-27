
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

CREATE TABLE IF NOT EXISTS item
(
  id        INT           NOT NULL AUTO_INCREMENT,
  nome      VARCHAR(30)   NOT NULL,
  descricao VARCHAR(255)  NOT NULL,
  status    VARCHAR(20)   NOT NULL,
  efeito    VARCHAR(50)   NOT NULL,
  preco     DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS usuario_item
(
  item_id    INT         NOT NULL AUTO_INCREMENT,
  usuario_id INT         NOT NULL,
  quantidade INT         NOT NULL,
  PRIMARY KEY (item_id, usuario_id),
  CONSTRAINT FK_usuario_TO_usuario_item
    FOREIGN KEY (usuario_id)
    REFERENCES usuario (id),
  CONSTRAINT FK_item_TO_usuario_item
    FOREIGN KEY (item_id)
    REFERENCES item (id)
);

INSERT INTO usuario (nome, username, email, senha, adm)
VALUES ("admin", "admin", "murilovanzandasilva@gmail.com", "$2y$10$Is5WEHHrza8dYLZNUMeVLuCOboGXJWGsZEPNGRBakqFnV144.LYNu", 1);

INSERT INTO item (nome, descricao, status, efeito, preco) VALUES
  ('Antidote', 'Cura um Pokémon do estado de Envenenamento.', 'Ativo', 'Cura Envenenamento', 10.00),
  ('Awakening', 'Cura um Pokémon do estado de Sono.', 'Ativo', 'Cura Sono', 10.00),
  ('Burn Heal', 'Cura um Pokémon do estado de Queimadura.', 'Ativo', 'Cura Queimadura', 10.00),
  ('Full Heal', 'Cura um Pokémon de status de Envenenamento, Sono, Congelamento, Paralisia e Queimadura, sem recuperar HP.', 'Ativo', 'Cura Status Negativos', 30.00),
  ('Full Restore', 'Cura 100% do HP e todos status.', 'Ativo', 'Cura Total (HP + Status)', 70.00),
  ('Hyper Potion', 'Cura um 200HP de um pokémon que não esteja desmaiado.', 'Ativo', '+200 HP', 30.00),
  ('Ice Heal', 'Cura um Pokémon do estado de Congelamento.', 'Ativo', 'Cura Congelamento', 10.00),
  ('Max Potion', 'Cura 100% do HP de um pokémon que não esteja desmaiado.', 'Ativo', 'Cura 100% HP', 40.00),
  ('Paralyze Heal', 'Cura um Pokémon do estado de Paralisia.', 'Ativo', 'Cura Paralisia', 10.00),
  ('Potion', 'Cura 20HP de um pokémon que não esteja desmaiado.', 'Ativo', '+20 HP', 10.00),
  ('Rare Candy', 'Aumenta um nível de um pokémon.', 'Ativo', '+1 Nível', 15.00),
  ('Revive', 'Tira o pokémon do estado de desmaiado e cura 50% de seu HP', 'Ativo', 'Revive + 50% HP', 30.00),
  ('Super Potion', 'Cura 50HP de um pokémon que não esteja desmaiado.', 'Ativo', '+50 HP', 15.00),
  ('Evolution Stone', 'A pedra que concede ao pokémon evolução imediata.', 'Ativo', 'Evolução Imediata', 100.00),
  ('Sweet honey', 'Serve para atrair pokémons e deixá-los confusos.', 'Ativo', 'Atrai e Confunde', 67.00),
  ('Precious Ruby', 'Pode te salvar de grandes fumaceiros.', 'Ativo', 'Proteção', 42.00),
  ('Lucky Egg', 'O PascualOVO da sorte serve para aumentar a amizade com seu pokémon.', 'Ativo', 'Aumenta Amizade', 15.00);

SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;