-- Migração da loja: rode UMA vez no banco monsterpe que você já tem.
-- (Para um banco novo, use só o monsterpe-database_starter.sql)
USE monsterpe;

-- As colunas originais eram pequenas demais para os itens (ex.: 'Evolution Stone' tem 15 letras)
ALTER TABLE item
  MODIFY nome      VARCHAR(30)  NOT NULL,
  MODIFY descricao VARCHAR(255) NOT NULL,
  MODIFY efeito    VARCHAR(50)  NOT NULL;

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

-- Para testar a compra, dê dinheiro ao seu usuário (troque o username):
-- UPDATE usuario SET tokens = 500 WHERE username = 'admin';
