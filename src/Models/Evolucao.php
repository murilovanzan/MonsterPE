<?php

    // Evolução de Pokémon com a Evolution Stone (fora da batalha).
    // Regra do trabalho: a pedra faz o Pokémon evoluir para a próxima forma da sua linha evolutiva.
    // Os dados vêm da PokeAPI, consultada pelo próprio servidor.
    class Evolucao {

        private const NOME_PEDRA = 'evolution stone';
        private const URL_API = 'https://pokeapi.co/api/v2/';

        /**
         * Evolui o Pokémon e gasta 1 pedra. Tudo acontece em uma transação.
         * @return array ['nomeAntigo', 'nome', 'restante']
         * @throws InvalidArgumentException dados inválidos, pedra/pokémon ausentes, ou Pokémon sem evolução
         * @throws RuntimeException falha ao consultar a PokeAPI
         */
        public static function evoluir(int $usuarioId, string $pokemonId, int $itemId): array {

            if (!preg_match('/^[0-9a-fA-F-]{36}$/', $pokemonId)) {
                throw new InvalidArgumentException("Pokémon inválido.");
            }

            $db = getConnection();
            $db->beginTransaction();

            try {
                // 1) Confere a pedra na mochila (trava a linha para não gastar duas vezes)
                $stmt = $db->prepare(
                    "SELECT ui.quantidade, i.nome FROM usuario_item ui
                     INNER JOIN item i ON i.id = ui.item_id
                     WHERE ui.usuario_id = :usuario AND ui.item_id = :item FOR UPDATE;"
                );
                $stmt->execute([':usuario' => $usuarioId, ':item' => $itemId]);
                $pedra = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!$pedra || (int) $pedra['quantidade'] < 1) {
                    throw new InvalidArgumentException("Você não possui este item na mochila.");
                }
                if (strtolower(trim($pedra['nome'])) !== self::NOME_PEDRA) {
                    throw new InvalidArgumentException("Este item não faz Pokémon evoluir.");
                }

                // 2) Confere se o Pokémon é do usuário
                $stmt = $db->prepare("SELECT * FROM pokemon WHERE id = :id AND usuario_id = :usuario FOR UPDATE;");
                $stmt->execute([':id' => $pokemonId, ':usuario' => $usuarioId]);
                $pokemon = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!$pokemon) {
                    throw new InvalidArgumentException("Pokémon não encontrado.");
                }

                // 3) Descobre a próxima forma na PokeAPI
                $evolucao = self::proximaEvolucao((int) $pokemon['api_id']);

                // 4) Atualiza o Pokémon (nível e movimentos são mantidos)
                $apelido = $pokemon['apelido'];
                if (strtolower(trim($apelido)) === $evolucao['nomeAntigo']) {
                    // Apelido padrão (nome da espécie) acompanha a evolução
                    $apelido = mb_substr(ucfirst($evolucao['nome']), 0, 12);
                }

                $stmt = $db->prepare(
                    "UPDATE pokemon
                     SET api_id = :api, apelido = :apelido, hp = :hp, speed = :speed,
                         attack = :attack, spAttack = :spAttack, defense = :defense, spDefense = :spDefense
                     WHERE id = :id AND usuario_id = :usuario;"
                );
                $stmt->execute([
                    ':api'       => (string) $evolucao['id'],
                    ':apelido'   => $apelido,
                    ':hp'        => $evolucao['stats']['hp'],
                    ':speed'     => $evolucao['stats']['speed'],
                    ':attack'    => $evolucao['stats']['attack'],
                    ':spAttack'  => $evolucao['stats']['special-attack'],
                    ':defense'   => $evolucao['stats']['defense'],
                    ':spDefense' => $evolucao['stats']['special-defense'],
                    ':id'        => $pokemonId,
                    ':usuario'   => $usuarioId,
                ]);

                // 5) Gasta a pedra
                $stmt = $db->prepare("UPDATE usuario_item SET quantidade = quantidade - 1 WHERE usuario_id = :usuario AND item_id = :item;");
                $stmt->execute([':usuario' => $usuarioId, ':item' => $itemId]);

                $db->commit();

                return [
                    'nomeAntigo' => $evolucao['nomeAntigo'],
                    'nome'       => $evolucao['nome'],
                    'restante'   => (int) $pedra['quantidade'] - 1,
                ];

            } catch (Throwable $e) {
                if ($db->inTransaction()) {
                    $db->rollBack();
                }
                throw $e;
            }
        }

        // Retorna a próxima forma da linha evolutiva do Pokémon (api_id)
        private static function proximaEvolucao(int $apiId): array {

            $pokeAtual  = self::getJson(self::URL_API . "pokemon/" . $apiId);
            $especie    = self::getJson($pokeAtual['species']['url'] ?? '');
            $nomeAntigo = $especie['name'];

            $cadeia = self::getJson($especie['evolution_chain']['url'] ?? '')['chain'] ?? null;
            $candidatas = $cadeia ? self::evolucoesDe($cadeia, $nomeAntigo) : null;

            if ($candidatas === null) {
                throw new RuntimeException("Não foi possível encontrar a linha evolutiva deste Pokémon.");
            }
            if (count($candidatas) === 0) {
                throw new InvalidArgumentException("Este Pokémon não pode evoluir.");
            }

            // Prefere a evolução por item; se não houver, usa a primeira
            $escolhida = $candidatas[0];
            foreach ($candidatas as $candidata) {
                foreach (($candidata['evolution_details'] ?? []) as $detalhe) {
                    if (($detalhe['trigger']['name'] ?? null) === 'use-item') {
                        $escolhida = $candidata;
                        break 2;
                    }
                }
            }

            $nomeNovo = $escolhida['species']['name'];
            $novo = self::getJson(self::URL_API . "pokemon/" . $nomeNovo);

            $stats = [];
            foreach ($novo['stats'] as $stat) {
                $stats[$stat['stat']['name']] = (int) $stat['base_stat'];
            }

            return [
                'nomeAntigo' => $nomeAntigo,
                'id'         => (int) $novo['id'],
                'nome'       => $nomeNovo,
                'stats'      => $stats,
            ];
        }

        // Procura a espécie na árvore da evolução e devolve as formas seguintes (null se não achar)
        private static function evolucoesDe(array $no, string $nome): ?array {
            if (($no['species']['name'] ?? null) === $nome) {
                return $no['evolves_to'] ?? [];
            }
            foreach (($no['evolves_to'] ?? []) as $filho) {
                $achou = self::evolucoesDe($filho, $nome);
                if ($achou !== null) {
                    return $achou;
                }
            }
            return null;
        }

        private static function getJson(string $url): array {
            if ($url === '') {
                throw new RuntimeException("Não foi possível consultar a PokeAPI agora. Tente novamente.");
            }

            $corpo = false;
            if (function_exists('curl_init')) {
                $ch = curl_init($url);
                curl_setopt_array($ch, [
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_TIMEOUT        => 10,
                ]);
                $corpo  = curl_exec($ch);
                $codigo = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                if ($codigo !== 200) {
                    $corpo = false;
                }
            } else {
                $contexto = stream_context_create(['http' => ['timeout' => 10]]);
                $corpo = @file_get_contents($url, false, $contexto);
            }

            $dados = $corpo !== false ? json_decode($corpo, true) : null;
            if (!is_array($dados)) {
                throw new RuntimeException("Não foi possível consultar a PokeAPI agora. Tente novamente.");
            }
            return $dados;
        }
    }

?>
