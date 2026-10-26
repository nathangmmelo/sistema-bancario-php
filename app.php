<?php

declare(strict_types=1);

require_once __DIR__ . '/src/Models/ContaBancaria.php';
require_once __DIR__ . '/src/Services/Banco.php';

use App\Services\Banco;

$banco = new Banco();

function ler(string $mensagem): string
{
    echo $mensagem;
    return trim((string) fgets(STDIN));
}

function dinheiro(float $valor): string
{
    return 'R$ ' . number_format($valor, 2, ',', '.');
}

function lerValor(string $mensagem): float
{
    $entrada = str_replace(',', '.', ler($mensagem));
    if (!is_numeric($entrada)) {
        throw new InvalidArgumentException('Digite um valor numérico válido.');
    }
    return (float) $entrada;
}

while (true) {
    echo "\n=================================\n";
    echo "       SISTEMA BANCÁRIO PHP      \n";
    echo "=================================\n";
    echo "1. Criar conta\n2. Listar contas\n3. Consultar saldo e histórico\n4. Depositar\n5. Sacar\n6. Transferir\n0. Sair\n";

    $opcao = ler('Escolha uma opção: ');
    try {
        switch ($opcao) {
            case '1':
                $titular = ler('Nome do titular: ');
                $saldo = lerValor('Saldo inicial (use 0 se não houver): R$ ');
                $conta = $banco->criarConta($titular, $saldo);
                echo "Conta criada! Número: {$conta->getNumero()} | Saldo: " . dinheiro($conta->getSaldo()) . "\n";
                break;
            case '2':
                $contas = $banco->listarContas();
                if (!$contas) { echo "Nenhuma conta cadastrada.\n"; break; }
                foreach ($contas as $conta) {
                    echo "Conta {$conta->getNumero()} | {$conta->getTitular()} | " . dinheiro($conta->getSaldo()) . "\n";
                }
                break;
            case '3':
                $conta = $banco->buscarConta(ler('Número da conta: '));
                echo "Titular: {$conta->getTitular()}\nSaldo: " . dinheiro($conta->getSaldo()) . "\nHistórico:\n";
                foreach ($conta->getHistorico() as $item) {
                    $sinal = $item['valor'] > 0 ? '+' : '';
                    echo "- {$item['data']} | {$item['operacao']} | {$sinal}" . dinheiro($item['valor']) . " | Saldo: " . dinheiro($item['saldo']) . "\n";
                }
                break;
            case '4':
                $conta = $banco->buscarConta(ler('Número da conta: '));
                $conta->depositar(lerValor('Valor do depósito: R$ '));
                echo 'Depósito realizado. Saldo atual: ' . dinheiro($conta->getSaldo()) . "\n";
                break;
            case '5':
                $conta = $banco->buscarConta(ler('Número da conta: '));
                $conta->sacar(lerValor('Valor do saque: R$ '));
                echo 'Saque realizado. Saldo atual: ' . dinheiro($conta->getSaldo()) . "\n";
                break;
            case '6':
                $origem = $banco->buscarConta(ler('Número da conta de origem: '));
                $destino = $banco->buscarConta(ler('Número da conta de destino: '));
                $origem->transferir(lerValor('Valor da transferência: R$ '), $destino);
                echo "Transferência realizada com sucesso.\n";
                break;
            case '0':
                echo "Obrigado por utilizar o sistema!\n";
                exit(0);
            default:
                echo "Opção inválida. Tente novamente.\n";
        }
    } catch (Throwable $erro) {
        echo 'Erro: ' . $erro->getMessage() . "\n";
    }
}
