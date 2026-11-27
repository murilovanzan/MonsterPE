<?php

    // Registra as batalhas na tabela log_batalha e suas mensagens em log_batalha_evento.
    class LogBatalha {

        private const RESULTADOS_VALIDOS = ['vitoria', 'derrota', 'fuga'];
        private const MAX_EVENTOS = 2000;

        // Cria a linha da batalha quando a tela de batalha é aberta. Retorna o id.
        public static function iniciar(int $usuarioId): int {
            $db = getConnection();
            $stmt = $db->prepare("INSERT INTO log_batalha (usuario_id) VALUES (:usuario);");
            $stmt->execute([':usuario' => $usuarioId]);
            return (int) $db->lastInsertId();
        }

        /**
         * Fecha a batalha: grava resultado, rounds e todas as mensagens.
         * Só funciona para batalhas do próprio usuário que ainda estão em andamento.
         * @throws InvalidArgumentException dados inválidos
         */
        public static function finalizar(int $usuarioId, int $batalhaId, string $resultado, int $rounds, array $eventos): void {
            if (!in_array($resultado, self::RESULTADOS_VALIDOS, true)) {
                throw new InvalidArgumentException("Resultado de batalha inválido.");
            }

            $db = getConnection();
            $db->beginTransaction();

            try {
                // Trava a linha: garante que a batalha é do usuário e ainda não foi fechada
                $stmt = $db->prepare("SELECT id FROM log_batalha WHERE id = :id AND usuario_id = :usuario AND resultado = 'em_andamento' FOR UPDATE;");
                $stmt->execute([':id' => $batalhaId, ':usuario' => $usuarioId]);
                if ($stmt->fetchColumn() === false) {
                    throw new InvalidArgumentException("Batalha não encontrada ou já finalizada.");
                }

                $stmt = $db->prepare("UPDATE log_batalha SET resultado = :resultado, rounds = :rounds, finalizado_em = NOW() WHERE id = :id;");
                $stmt->execute([':resultado' => $resultado, ':rounds' => max(0, $rounds), ':id' => $batalhaId]);

                $stmtEvento = $db->prepare("INSERT INTO log_batalha_evento (batalha_id, ordem, round, mensagem) VALUES (:batalha, :ordem, :round, :mensagem);");
                $ordem = 0;
                foreach (array_slice($eventos, 0, self::MAX_EVENTOS) as $evento) {
                    if (!is_array($evento) || !isset($evento['texto'])) {
                        continue;
                    }
                    $stmtEvento->execute([
                        ':batalha'  => $batalhaId,
                        ':ordem'    => $ordem++,
                        ':round'    => max(0, (int) ($evento['round'] ?? 0)),
                        ':mensagem' => mb_substr((string) $evento['texto'], 0, 500),
                    ]);
                }

                $db->commit();
            } catch (Throwable $e) {
                if ($db->inTransaction()) {
                    $db->rollBack();
                }
                throw $e;
            }
        }
    }

?>
