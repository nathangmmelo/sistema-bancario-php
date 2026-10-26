<?php

declare(strict_types=1);

namespace App\Models;

use InvalidArgumentException;
use RuntimeException;

class ContaBancaria
{
    private float $saldo;
    private array $historico = [];

    public function __construct(
        private readonly string $titular,
        private readonly string $numero,
        float $saldoInicial = 0.0
    ) {
        if (trim($titular) === '') {
            throw new InvalidArgumentException('O nome do titular não pode ficar vazio.');
        }
        if (trim($numero) === '') {
            throw new InvalidArgumentException('O número da conta não pode ficar vazio.');
        }
        if ($saldoInicial < 0) {
            throw new InvalidArgumentException('O saldo inicial não pode ser negativo.');
        }

        $this->saldo = $saldoInicial;
        $this->registrar('Abertura da conta', $saldoInicial);
    }

    public function getTitular(): string { return $this->titular; }
    public function getNumero(): string { return $this->numero; }
    public function getSaldo(): float { return $this->saldo; }
    public function getHistorico(): array { return $this->historico; }

    public function depositar(float $valor): void
    {
        $this->validarValor($valor);
        $this->saldo += $valor;
        $this->registrar('Depósito', $valor);
    }

    public function sacar(float $valor): void
    {
        $this->validarValor($valor);
        if ($valor > $this->saldo) {
            throw new RuntimeException('Saldo insuficiente para realizar o saque.');
        }
        $this->saldo -= $valor;
        $this->registrar('Saque', -$valor);
    }

    public function transferir(float $valor, self $destino): void
    {
        if ($destino === $this) {
            throw new InvalidArgumentException('Não é possível transferir para a mesma conta.');
        }
        $this->validarValor($valor);
        if ($valor > $this->saldo) {
            throw new RuntimeException('Saldo insuficiente para realizar a transferência.');
        }

        // Valida tudo antes de alterar os saldos para evitar transferência parcial.
        $this->saldo -= $valor;
        $destino->saldo += $valor;
        $this->registrar('Transferência enviada para ' . $destino->numero, -$valor);
        $destino->registrar('Transferência recebida de ' . $this->numero, $valor);
    }

    private function validarValor(float $valor): void
    {
        if (!is_finite($valor) || $valor <= 0) {
            throw new InvalidArgumentException('O valor deve ser maior que zero.');
        }
    }

    private function registrar(string $operacao, float $valor): void
    {
        $this->historico[] = [
            'data' => date('d/m/Y H:i:s'),
            'operacao' => $operacao,
            'valor' => $valor,
            'saldo' => $this->saldo,
        ];
    }
}
