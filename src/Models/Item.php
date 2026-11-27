<?php

    class Item {

        private const PASTA_IMAGENS = '/MonsterPE/assets/imgs/Loja/';
        private const IMAGEM_PADRAO = '/MonsterPE/assets/imgs/MasterballIcon.png';

        // O banco não guarda imagem, então ligamos o nome do item ao arquivo em assets/imgs/Loja
        private const IMAGENS = [
            'antidote'        => 'antidote.png',
            'awakening'       => 'awakening.jpeg',
            'burn heal'       => 'burnheal.png',
            'full heal'       => 'full heal.png',
            'full restore'    => 'fullrestore.png',
            'hyper potion'    => 'hyperpotion.jpeg',
            'ice heal'        => 'iceheal.png',
            'max potion'      => 'maxpotion.jpeg',
            'paralyze heal'   => 'paralyzeheal.jpeg',
            'potion'          => 'Potion.jpeg',
            'rare candy'      => 'rarecandy.jpeg',
            'revive'          => 'revive.png',
            'super potion'    => 'superpotion.png',
            'evolution stone' => 'evolutionstone.png',
            'sweet honey'     => 'honey.png',
            'precious ruby'   => 'redorb.png',
            'lucky egg'       => 'Egg.jpeg',
        ];

        private ?int $id = null;
        private ?string $nome = null;
        private ?string $descricao = null;
        private ?string $status = null;
        private ?string $efeito = null;
        private ?float $preco = null;

        public function __construct(?int $id = null, ?string $nome = null, ?string $descricao = null, ?string $status = null, ?string $efeito = null, ?float $preco = null){

            if (!isset($id) && !isset($nome) && !isset($descricao) && !isset($status) && !isset($efeito) && !isset($preco)) return;

            $this->id = $id;
            $this->nome = $nome;
            $this->descricao = $descricao;
            $this->status = $status;
            $this->efeito = $efeito;
            $this->preco = $preco;
        }

        // Getters
        public function getId() { return $this->id; }
        public function getNome() { return $this->nome; }
        public function getDescricao() { return $this->descricao; }
        public function getStatus() { return $this->status; }
        public function getEfeito() { return $this->efeito; }
        public function getPreco() { return $this->preco; }

        // Setters
        public function setId($id) { $this->id = $id; }
        public function setNome($nome) { $this->nome = $nome; }
        public function setDescricao($descricao) { $this->descricao = $descricao; }
        public function setStatus($status) { $this->status = $status; }
        public function setEfeito($efeito) { $this->efeito = $efeito; }
        public function setPreco($preco) { $this->preco = $preco; }

        public function salvar($update = false) {
            $db = getConnection();
            if(!$update){
                $sql = "INSERT INTO item (nome, descricao, status, efeito, preco) VALUES (:nome, :descricao, :status, :efeito, :preco);";
                $stmt = $db->prepare($sql);
                $resultado = $stmt->execute([
                    ':nome'      => $this->nome,
                    ':descricao' => $this->descricao,
                    ':status'    => $this->status,
                    ':efeito'    => $this->efeito,
                    ':preco'     => $this->preco
                ]);

                if ($resultado) {
                    $this->id = (int) $db->lastInsertId();
                }
                return $resultado;
            }
            else{
                $sql = "UPDATE item SET nome = :nome, descricao = :descricao, status = :status, efeito = :efeito, preco = :preco WHERE id = :id;";
                $stmt = $db->prepare($sql);
                return $stmt->execute([
                    ':nome'      => $this->nome,
                    ':descricao' => $this->descricao,
                    ':status'    => $this->status,
                    ':efeito'    => $this->efeito,
                    ':preco'     => $this->preco,
                    ':id'        => $this->id
                ]);
            }
        }

        public static function delete($id){
            $db = getConnection();
            $sql = "DELETE FROM item WHERE id = :id;";
            $stmt = $db->prepare($sql);
            return $stmt->execute([
                ':id' => $id
            ]);
        }

        public static function getAllItens(){
            $db = getConnection();
            $sql = "SELECT * FROM item;";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // Itens que aparecem na loja
        public static function getAtivos(){
            $db = getConnection();
            $sql = "SELECT * FROM item WHERE status = 'Ativo' ORDER BY id;";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // Itens que o usuário possui (mochila), com quantidade > 0
        public static function getInventario(int $usuarioId): array {
            $db = getConnection();
            $sql = "SELECT i.id, i.nome, i.descricao, i.efeito, ui.quantidade
                    FROM usuario_item ui
                    INNER JOIN item i ON i.id = ui.item_id
                    WHERE ui.usuario_id = :usuario AND ui.quantidade > 0
                    ORDER BY i.id;";
            $stmt = $db->prepare($sql);
            $stmt->execute([':usuario' => $usuarioId]);
            $itens = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return array_map(function ($i) {
                return [
                    'id'         => (int) $i['id'],
                    'nome'       => $i['nome'],
                    'descricao'  => $i['descricao'],
                    'efeito'     => $i['efeito'],
                    'quantidade' => (int) $i['quantidade'],
                ];
            }, $itens);
        }

        /**
         * Gasta uma unidade de um item da mochila (dentro de transação).
         * @return int quantidade que sobrou
         * @throws InvalidArgumentException se o usuário não tiver o item
         */
        public static function consumir(int $usuarioId, int $itemId): int {
            $db = getConnection();
            $db->beginTransaction();

            try {
                $stmt = $db->prepare("SELECT quantidade FROM usuario_item WHERE item_id = :item AND usuario_id = :usuario FOR UPDATE;");
                $stmt->execute([':item' => $itemId, ':usuario' => $usuarioId]);
                $quantidade = $stmt->fetchColumn();

                if ($quantidade === false || (int) $quantidade < 1) {
                    throw new InvalidArgumentException("Você não possui este item na mochila.");
                }

                $stmt = $db->prepare("UPDATE usuario_item SET quantidade = quantidade - 1 WHERE item_id = :item AND usuario_id = :usuario;");
                $stmt->execute([':item' => $itemId, ':usuario' => $usuarioId]);

                $db->commit();
                return (int) $quantidade - 1;
            } catch (Throwable $e) {
                if ($db->inTransaction()) {
                    $db->rollBack();
                }
                throw $e;
            }
        }

        public static function getById($id){
            $db = getConnection();
            $sql = "SELECT * FROM item WHERE id = :id;";
            $stmt = $db->prepare($sql);
            $stmt->execute([
                ':id' => $id
            ]);
            $dados = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($dados) {
                return new self(
                    $dados['id'], $dados['nome'],
                    $dados['descricao'], $dados['status'],
                    $dados['efeito'], $dados['preco']
                );
            }
            return null;
        }

        public static function getImagem(string $nome): string {
            $arquivo = self::IMAGENS[strtolower(trim($nome))] ?? null;
            if ($arquivo === null) {
                return self::IMAGEM_PADRAO;
            }
            return self::PASTA_IMAGENS . rawurlencode($arquivo);
        }

        /**
         * Compra os itens do carrinho de uma vez só (transação):
         * ou desconta o dinheiro E entrega todos os itens, ou nada acontece.
         *
         * $carrinho = [['id' => 1, 'quantidade' => 2], ...]
         * Os preços vêm sempre do banco, nunca do navegador.
         *
         * @return int novo saldo do usuário
         * @throws InvalidArgumentException carrinho inválido ou item indisponível
         * @throws SaldoInsuficienteException dinheiro não cobre o total
         */
        public static function comprar(int $usuarioId, $carrinho): int {

            if (!is_array($carrinho) || count($carrinho) === 0) {
                throw new InvalidArgumentException("Seu carrinho está vazio.");
            }

            // Junta linhas repetidas do mesmo item e valida os dados
            $quantidades = [];
            foreach ($carrinho as $linha) {
                $itemId = filter_var($linha['id'] ?? null, FILTER_VALIDATE_INT);
                $qtd = filter_var($linha['quantidade'] ?? null, FILTER_VALIDATE_INT);

                if ($itemId === false || $itemId < 1 || $qtd === false || $qtd < 1) {
                    throw new InvalidArgumentException("Carrinho com dados inválidos.");
                }
                $quantidades[$itemId] = ($quantidades[$itemId] ?? 0) + $qtd;
            }

            $db = getConnection();
            $db->beginTransaction();

            try {
                // Trava a linha do usuário para duas compras simultâneas não gastarem o mesmo dinheiro
                $stmt = $db->prepare("SELECT tokens FROM usuario WHERE id = :id FOR UPDATE;");
                $stmt->execute([':id' => $usuarioId]);
                $saldo = $stmt->fetchColumn();
                if ($saldo === false) {
                    throw new InvalidArgumentException("Usuário não encontrado.");
                }
                $saldo = (float) $saldo;

                $stmtItem = $db->prepare("SELECT preco FROM item WHERE id = :id AND status = 'Ativo';");
                $total = 0.0;
                foreach ($quantidades as $itemId => $qtd) {
                    $stmtItem->execute([':id' => $itemId]);
                    $preco = $stmtItem->fetchColumn();
                    if ($preco === false) {
                        throw new InvalidArgumentException("Um dos itens do carrinho não está mais disponível.");
                    }
                    $total += (float) $preco * $qtd;
                }

                if ($saldo < $total) {
                    throw new SaldoInsuficienteException($saldo, $total);
                }

                $stmt = $db->prepare("UPDATE usuario SET tokens = tokens - :total WHERE id = :id;");
                $stmt->execute([':total' => number_format($total, 2, '.', ''), ':id' => $usuarioId]);

                // Se o usuário já tem o item, soma a quantidade
                $stmtInv = $db->prepare(
                    "INSERT INTO usuario_item (item_id, usuario_id, quantidade) VALUES (:item, :usuario, :qtd)
                     ON DUPLICATE KEY UPDATE quantidade = quantidade + VALUES(quantidade);"
                );
                foreach ($quantidades as $itemId => $qtd) {
                    $stmtInv->execute([':item' => $itemId, ':usuario' => $usuarioId, ':qtd' => $qtd]);
                }

                $stmt = $db->prepare("SELECT tokens FROM usuario WHERE id = :id;");
                $stmt->execute([':id' => $usuarioId]);
                $novoSaldo = (int) $stmt->fetchColumn();

                $db->commit();
                return $novoSaldo;

            } catch (Throwable $e) {
                if ($db->inTransaction()) {
                    $db->rollBack();
                }
                throw $e;
            }
        }

    }

?>
