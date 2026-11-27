<?php

class Usuario {

    private ?int $id = null;
    private ?string $nome = null;
    private ?string $username = null;
    private ?string $email = null;
    private ?string $senha = null;
    private ?int $tokens = 0;
    private ?bool $adm = false;
    private ?string $foto = null;

    public function __construct(?string $nome = null, ?string $username = null, ?string $email = null, ?string $senha = null, ?bool $adm = false, ?string $foto = null) {
        if (!isset($nome) && !isset($username) && !isset($email) && !isset($senha)) return;

        $this->setNome($nome);
        $this->setUsername($username);
        $this->setEmail($email);
        $this->setSenha($senha);
        $this->tokens = 0;
        $this->adm = (bool) $adm;
        $this->setFoto($foto);
    }

    public function getId()       { return $this->id; }
    public function getNome()     { return $this->nome; }
    public function getUsername() { return $this->username; }
    public function getEmail()    { return $this->email; }
    public function getSenha()    { return $this->senha; }
    public function getTokens()   { return $this->tokens; }
    public function getAdm()      { return $this->adm; }
    public function getFoto()     { return $this->foto; }

    public function setNome(string $nome) {
        $nome = trim($nome);
        self::validaNome($nome);
        $this->nome = $nome;
    }

    public function setUsername(string $username) {
        $username = strtolower(trim($username));
        self::validaUsername($username, $this->id);
        $this->username = $username;
    }

    public function setEmail(string $email) {
        $email = strtolower(trim($email));
        self::validaEmail($email, $this->id);
        $this->email = $email;
    }

    public function setSenha(string $senha) {
        if (strlen($senha) < 6) {
            throw new Exception("A senha deve ter no mínimo 6 caracteres.");
        }
        // PASSWORD_BCRYPT garante exatamente 60 caracteres (compatível com CHAR(60))
        $this->senha = password_hash($senha, PASSWORD_BCRYPT);
    }

    public function setTokens(?int $tokens) {
        $this->tokens = $tokens ?? 0;
    }

    public function setAdm($adm) {
        $this->adm = (bool) $adm;
    }

    public function setFoto(?string $foto) {
        if ($foto === null || trim($foto) === '') {
            $this->foto = null;
            return;
        }

        $foto = trim($foto);
        if (mb_strlen($foto) > 128) {
            throw new Exception("O caminho da foto excede o limite de 128 caracteres.");
        }
        // Bloqueia path traversal, URLs externas (//host) e caracteres inválidos/XSS
        if (str_contains($foto, '..') || str_starts_with($foto, '//') || !preg_match('/^[a-zA-Z0-9_\/\.\-]+$/', $foto)) {
            throw new Exception("Caminho de foto inválido.");
        }

        $this->foto = $foto;
    }

    public function salvar() {
        $db = getConnection();
        $admInt = $this->adm ? 1 : 0;

        if ($this->id) {
            $sql = "UPDATE usuario 
                    SET nome = :n, username = :u, email = :e, senha = :s, tokens = :t, adm = :a, foto = :img 
                    WHERE id = :id;";
            $stmt = $db->prepare($sql);
            return $stmt->execute([
                ':n'   => $this->nome,
                ':u'   => $this->username,
                ':e'   => $this->email,
                ':s'   => $this->senha,
                ':t'   => $this->tokens,
                ':a'   => $admInt,
                ':img' => $this->foto,
                ':id'  => $this->id
            ]);
        }

        $sql = "INSERT INTO usuario (nome, username, email, senha, tokens, adm, foto) 
                VALUES (:n, :u, :e, :s, :t, :a, :img);";
        $stmt = $db->prepare($sql);
        $inserido = $stmt->execute([
            ':n'   => $this->nome,
            ':u'   => $this->username,
            ':e'   => $this->email,
            ':s'   => $this->senha,
            ':t'   => $this->tokens,
            ':a'   => $admInt,
            ':img' => $this->foto
        ]);

        if ($inserido) {
            $this->id = (int) $db->lastInsertId();
        }
        return $inserido;
    }

    public static function delete($id) {
        $db = getConnection();
        $sql = "DELETE FROM usuario WHERE id = :id;";
        $stmt = $db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    public static function getTodos() {
        $db = getConnection();
        $sql = "SELECT * FROM usuario;";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getById($id, $class = true) {
        $db = getConnection();
        $sql = "SELECT * FROM usuario WHERE id = :id;";
        $stmt = $db->prepare($sql);
        $stmt->execute([':id' => $id]);

        if ($class) {
            $obj = $stmt->fetch(PDO::FETCH_OBJ);
            if (!$obj) {
                throw new Exception('ID não encontrado.');
            }
            return self::hydrate($obj);
        }
        return $stmt->fetch();
    }

    public static function getByColumn($columnValue, $column) {
        // Whitelist contra SQL Injection no nome da coluna
        $colunasPermitidas = ['id', 'username', 'email'];
        if (!in_array($column, $colunasPermitidas, true)) {
            throw new Exception('Coluna de busca inválida.');
        }

        $db = getConnection();
        $sql = "SELECT * FROM usuario WHERE {$column} = :valor LIMIT 1;";
        $stmt = $db->prepare($sql);
        $stmt->execute([':valor' => $columnValue]);
        $obj = $stmt->fetch(PDO::FETCH_OBJ);

        if (!$obj) {
            return false;
        }
        return self::hydrate($obj);
    }

    public static function hydrate($obj) {
        $user = new self();
        $user->id       = (int) $obj->id;
        $user->nome     = $obj->nome;
        $user->username = $obj->username;
        $user->email    = $obj->email;
        $user->senha    = $obj->senha;
        $user->tokens   = (int) $obj->tokens;
        $user->adm      = (bool) $obj->adm;
        $user->foto     = $obj->foto;
        return $user;
    }

    private static function validaNome(string $nome) {
        if ($nome === '') {
            throw new Exception("O nome não pode ficar vazio.");
        }
        if (mb_strlen($nome) > 128) {
            throw new Exception("O nome digitado excede o limite de 128 caracteres.");
        }
    }

    private static function validaUsername(string $username, ?int $ignorarId = null) {
        if ($username === '') {
            throw new Exception("O nome de usuário não pode ficar vazio.");
        }
        if (mb_strlen($username) > 16) {
            throw new Exception("O username digitado excede o limite de 16 caracteres.");
        }
        if (!preg_match('/^[a-zA-Z0-9_.\-]+$/', $username)) {
            throw new Exception('O username digitado utiliza caracteres inválidos (utilize apenas: letras, números e . - _ ).');
        }

        $resultUsername = self::getByColumn($username, 'username');
        if (!empty($resultUsername) && $resultUsername->getId() !== $ignorarId) {
            throw new Exception('Este usuário já existe.');
        }
    }

    private static function validaEmail(string $email, ?int $ignorarId = null) {
        if ($email === '') {
            throw new Exception("O e-mail não pode ficar vazio.");
        }
        if (mb_strlen($email) > 320) {
            throw new Exception("O email digitado excede o limite de 320 caracteres.");
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('O email informado é inválido.');
        }

        $resultEmail = self::getByColumn($email, 'email');
        if (!empty($resultEmail) && $resultEmail->getId() !== $ignorarId) {
            throw new Exception('Este email já está cadastrado.');
        }
    }
}
