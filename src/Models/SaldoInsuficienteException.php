<?php

    class SaldoInsuficienteException extends Exception {

        private float $saldo;
        private float $total;

        public function __construct(float $saldo, float $total){
            $this->saldo = $saldo;
            $this->total = $total;
            parent::__construct("Saldo insuficiente! Você tem R$ " . number_format($saldo, 2, ',', '') . " e o total da compra é R$ " . number_format($total, 2, ',', '') . ".");
        }

        public function getSaldo(): float { return $this->saldo; }
        public function getTotal(): float { return $this->total; }
    }

?>
