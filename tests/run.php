<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/Models/ContaBancaria.php';
require_once __DIR__ . '/../src/Services/Banco.php';

use App\Models\ContaBancaria;
use App\Services\Banco;

$passou = 0;
$falhou = 0;

function verificar(bool $condicao, string $descricao): void
{
    global $passou, $falhou;
    if ($condicao) { $passou++; echo "[PASSOU] $descricao\n"; }
    else { $falhou++; echo "[FALHOU] $descricao\n"; }
}

function deveLancar(callable $acao, string $descricao): void
{
    try { $acao(); verificar(false, $descricao); }
    catch (Throwable) { verificar(true, $descricao); }
}

$banco = new Banco();
$a = $banco->criarConta('Ana', 100.00);
$b = $banco->criarConta('Bruno');
verificar($a->getSaldo() === 100.0, 'Cria conta com saldo inicial');
$a->depositar(50.0);
verificar($a->getSaldo() === 150.0, 'Realiza depósito');
$a->sacar(25.0);
verificar($a->getSaldo() === 125.0, 'Realiza saque');
$a->transferir(45.0, $b);
verificar($a->getSaldo() === 80.0 && $b->getSaldo() === 45.0, 'Transfere entre contas');
verificar(count($a->getHistorico()) === 4, 'Mantém histórico de operações da conta');
deveLancar(fn() => $a->sacar(1000.0), 'Bloqueia saque acima do saldo');
deveLancar(fn() => $a->depositar(0.0), 'Bloqueia depósito zero');
deveLancar(fn() => $a->transferir(1.0, $a), 'Bloqueia transferência para a mesma conta');
deveLancar(fn() => $banco->buscarConta('9999'), 'Informa conta inexistente');
deveLancar(fn() => new ContaBancaria('', '999'), 'Bloqueia titular vazio');

printf("\nResultado: %d passaram; %d falharam.\n", $passou, $falhou);
exit($falhou === 0 ? 0 : 1);
