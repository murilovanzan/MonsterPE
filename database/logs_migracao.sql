-- Logs do MonsterPE: rode UMA vez no banco monsterpe (depois dos outros scripts).
USE monsterpe;

-- Log geral: login, cadastro, edição de perfil, time, compras, uso de itens...
CREATE TABLE IF NOT EXISTS log_usuario (
  id          INT           NOT NULL AUTO_INCREMENT,
  usuario_id  INT           NULL,            -- NULL quando o login falha com usuário inexistente
  acao        VARCHAR(40)   NOT NULL,
  detalhes    VARCHAR(500)  NULL,
  ip          VARCHAR(45)   NULL,
  criado_em   DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  INDEX IX_log_usuario_usuario (usuario_id),
  INDEX IX_log_usuario_acao (acao),
  CONSTRAINT FK_usuario_TO_log_usuario
    FOREIGN KEY (usuario_id) REFERENCES usuario (id)
    ON DELETE SET NULL
);

-- Log de batalhas: uma linha por batalha iniciada
CREATE TABLE IF NOT EXISTS log_batalha (
  id             INT          NOT NULL AUTO_INCREMENT,
  usuario_id     INT          NOT NULL,
  resultado      VARCHAR(20)  NOT NULL DEFAULT 'em_andamento', -- em_andamento | vitoria | derrota | fuga
  rounds         INT          NOT NULL DEFAULT 0,
  iniciado_em    DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  finalizado_em  DATETIME     NULL,
  PRIMARY KEY (id),
  INDEX IX_log_batalha_usuario (usuario_id),
  CONSTRAINT FK_usuario_TO_log_batalha
    FOREIGN KEY (usuario_id) REFERENCES usuario (id)
);

-- Mensagens de cada batalha, na ordem em que aconteceram
CREATE TABLE IF NOT EXISTS log_batalha_evento (
  id          INT           NOT NULL AUTO_INCREMENT,
  batalha_id  INT           NOT NULL,
  ordem       INT           NOT NULL,
  round       INT           NOT NULL,
  mensagem    VARCHAR(500)  NOT NULL,
  PRIMARY KEY (id),
  INDEX IX_log_batalha_evento_batalha (batalha_id),
  CONSTRAINT FK_log_batalha_TO_log_batalha_evento
    FOREIGN KEY (batalha_id) REFERENCES log_batalha (id)
    ON DELETE CASCADE
);
