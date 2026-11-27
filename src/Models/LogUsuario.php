<?php

    // Registra as ações do usuário na tabela log_usuario.
    // Falhas de log nunca interrompem a ação do usuário: apenas são gravadas no log do servidor.
    class LogUsuario {

        public const LOGIN         = 'login';
        public const LOGIN_FALHOU  = 'login_falhou';
        public const LOGOUT        = 'logout';
        public const CADASTRO      = 'cadastro';
        public const EDITAR_PERFIL = 'editar_perfil';
        public const SALVAR_TIME   = 'salvar_time';
        public const SALVAR_MOVES  = 'salvar_moves';
        public const LIMPAR_TIME   = 'limpar_time';
        public const EXCLUIR_POKEMON = 'excluir_pokemon';
        public const COMPRA        = 'compra';
        public const USO_ITEM      = 'uso_item';
        public const EVOLUIR       = 'evolucao';

        public static function registrar(?int $usuarioId, string $acao, ?string $detalhes = null): void {
            try {
                $db = getConnection();
                $sql = "INSERT INTO log_usuario (usuario_id, acao, detalhes, ip) VALUES (:usuario, :acao, :detalhes, :ip);";
                $stmt = $db->prepare($sql);
                $stmt->execute([
                    ':usuario'  => $usuarioId,
                    ':acao'     => $acao,
                    ':detalhes' => $detalhes !== null ? mb_substr($detalhes, 0, 500) : null,
                    ':ip'       => $_SERVER['REMOTE_ADDR'] ?? null,
                ]);
            } catch (Throwable $e) {
                error_log("MonsterPE - falha ao registrar log de usuário: " . $e->getMessage());
            }
        }
    }

?>
