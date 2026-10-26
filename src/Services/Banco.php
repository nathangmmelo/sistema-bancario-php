<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\ContaBancaria;
use InvalidArgumentException;

class Banco
{
    /** @var array<string, ContaBancaria> */
    private array $contas = [];
    private int $proximoNumero = 1001;

    public function criarConta(string $titular, float $saldoInicial = 0.0): ContaBancaria
    {
        $numero = (string) $this->proximoNumero++;
        $conta = new ContaBancaria($titular, $numero, $saldoInicial);
        $this->contas[$numero] = $conta;
        return $conta;
    }

    public function buscarConta(string $numero): ContaBancaria
    {
        if (!isset($this->contas[$numero])) {
            throw new InvalidArgumentException('Conta não encontrada.');
        }
        return $this->contas[$numero];
    }

    /** @return ContaBancaria[] */
    public function listarContas(): array
    {
        return array_values($this->contas);
    }
}
