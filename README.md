# 💳 Sistema Bancário em PHP — POO

Sistema bancário de linha de comando desenvolvido em **PHP**, com foco na prática de Programação Orientada a Objetos (POO). Permite criar contas, consultar saldos, depositar, sacar, transferir valores e consultar o histórico de operações.

## 🎯 Objetivo

Projeto de portfólio para demonstrar fundamentos de PHP e POO, organização de código, encapsulamento, validações e regras de negócio.

## 🚀 Funcionalidades

- ✅ Criar contas bancárias com número gerado automaticamente
- ✅ Listar contas cadastradas durante a execução
- ✅ Consultar saldo e histórico de movimentações
- ✅ Realizar depósitos e saques
- ✅ Transferir valores entre contas
- ✅ Impedir valores inválidos e operações sem saldo suficiente
- ✅ Impedir transferência para a mesma conta
- ✅ Registrar data, operação, valor e saldo após cada movimentação
- ✅ Executar testes automatizados sem bibliotecas externas

> **Observação:** os dados ficam em memória e são perdidos quando o programa é encerrado. O projeto não se conecta a um banco de dados e não movimenta dinheiro real.

## 🛠️ Tecnologias

- PHP 8.1 ou superior
- Programação Orientada a Objetos (POO)
- Terminal / linha de comando
- Git e GitHub

## 🧠 Conceitos de POO aplicados

- **Classes e objetos:** `ContaBancaria` representa uma conta; `Banco` gerencia as contas.
- **Encapsulamento:** saldo, titular, número e histórico são propriedades privadas ou somente leitura; o saldo só muda por operações controladas.
- **Construtor:** valida os dados ao criar uma conta.
- **Métodos:** `depositar()`, `sacar()` e `transferir()` representam comportamentos da conta.
- **Responsabilidade única:** a conta aplica regras financeiras; a classe `Banco` cadastra e localiza contas.
- **Tratamento de exceções:** entradas inválidas e operações não permitidas retornam mensagens de erro.

## 📁 Estrutura do projeto

```text
sistema-bancario-php/
├── src/
│   ├── Models/
│   │   └── ContaBancaria.php
│   └── Services/
│       └── Banco.php
├── tests/
│   └── run.php
├── app.php
├── README.md
├── LICENSE
└── .gitignore
```

## ⚙️ Pré-requisitos

1. PHP 8.1 ou superior instalado.
2. Terminal (Prompt de Comando, PowerShell, Terminal do macOS ou Linux).
3. Para conferir a instalação, execute:

```bash
php -v
```

## ▶️ Como executar

### 1. Clone o repositório

Depois de criar o repositório no GitHub:

```bash
git clone https://github.com/SEU_USUARIO/sistema-bancario-php.git
cd sistema-bancario-php
```

### 2. Inicie a aplicação

```bash
php app.php
```

Use o menu exibido no terminal para escolher uma operação. Crie duas contas para testar transferências. Os números das contas são gerados automaticamente, começando em `1001`.

### 3. Execute os testes

```bash
php tests/run.php
```

O comando executa os testes de criação de conta, depósito, saque, transferência, histórico e validações. Ao final, informa quantos testes passaram e falharam.

## 🧪 Exemplo rápido

```text
1. Criar conta
Nome do titular: Ana Souza
Saldo inicial (use 0 se não houver): R$ 100
Conta criada! Número: 1001 | Saldo: R$ 100,00
```

Crie uma segunda conta e use a opção **6. Transferir** para enviar dinheiro entre elas.

## 🔒 Regras de negócio

- O titular e o número da conta não podem ficar vazios.
- O saldo inicial não pode ser negativo.
- Depósitos, saques e transferências devem ter valor maior que zero.
- Não é permitido sacar ou transferir mais do que o saldo disponível.
- Não é permitido transferir para a própria conta.
- Toda operação concluída é registrada no histórico da conta.

## 📌 Melhorias futuras

- Persistir contas em SQLite ou MySQL
- Criar interface web ou API REST
- Adicionar autenticação e perfis de usuário
- Implementar transferências com identificador e comprovante
- Migrar os testes para PHPUnit

## 👨‍💻 Autor

**Nathan Gabriel** — projeto de estudo e portfólio.

## 📄 Licença

Distribuído sob a licença MIT. Consulte o arquivo [LICENSE](LICENSE).
