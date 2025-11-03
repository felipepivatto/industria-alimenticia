# 🗂️ Sistema de Gerenciamento de Tarefas - Kanban CRUD

## 📋 Descrição
Este projeto é um sistema de gerenciamento de tarefas baseado no modelo **Kanban** (A Fazer, Fazendo, Pronto), desenvolvido como atividade prática da disciplina de Desenvolvimento de Sistemas.  
O objetivo é permitir o **cadastro, visualização, atualização e exclusão de tarefas** vinculadas a usuários, com controle de prioridade e status, exibidas de forma organizada e visual.

## 🧠 Contexto
Uma indústria alimentícia utiliza um sistema simples de controle de tarefas, mas precisa de **maior integração e visibilidade entre setores**.  
O sistema aqui proposto funciona como uma **To-Do List interativa**, oferecendo recursos de gerenciamento visual e atualização dinâmica de status.

## 🚀 Funcionalidades
- **Cadastro de Usuários**
  - Campos obrigatórios: nome e e-mail (com validação).
  - Exibe mensagem de sucesso ao cadastrar.
- **Cadastro de Tarefas**
  - Campos obrigatórios: descrição, setor, prioridade e usuário vinculado.
  - Status inicial: “A Fazer”.
  - Exibe mensagem de sucesso após o cadastro.
- **Gerenciamento de Tarefas**
  - Exibição das tarefas divididas em três colunas:
    - 🟡 A Fazer  
    - 🟠 Fazendo  
    - 🟢 Pronto
  - Permite editar, excluir e alterar o status das tarefas diretamente.
  - Atualização automática da visualização ao mudar o status.
- **Menu Principal**
  - Acesso às telas de:
    - Cadastro de Usuários  
    - Cadastro de Tarefas  
    - Gerenciamento de Tarefas  

## 🗃️ Estrutura do Banco de Dados
**Tabelas principais:**
1. **usuarios**
   - id_usuario (PK)  
   - nome  
   - email  
2. **tarefas**
   - id_tarefa (PK)  
   - id_usuario (FK)  
   - descricao  
   - setor  
   - prioridade (baixa, média, alta)  
   - data_cadastro  
   - status (a fazer, fazendo, pronto)

Relacionamento:  
Um usuário pode ter várias tarefas, mas cada tarefa pertence a apenas um usuário (**1:N**).

## ⚙️ Tecnologias Utilizadas
- **Frontend:** HTML, CSS e JavaScript  
- **Backend:** PHP (MySQLi ou PDO)  
- **Banco de Dados:** MySQL (via phpMyAdmin)  
- **Servidor local:** XAMPP  

## 📂 Estrutura de Pastas
```
kanban-crud/
│
├── db/
│   └── banco.sql               # Script de criação do banco de dados
│
├── public/
│   ├── index.php               # Página inicial (menu principal)
│   ├── cadastrar_usuario.php   # Tela de cadastro de usuários
│   ├── cadastrar_tarefa.php    # Tela de cadastro de tarefas
│   └── gerenciar_tarefas.php   # Tela principal do Kanban
│
├── css/
│   └── style.css               # Estilos das páginas
│
├── includes/
│   └── conexao.php             # Conexão com o banco de dados
│
└── README.md
```

## 🧩 Etapas do Projeto
1. Criação do **Diagrama Entidade-Relacionamento (DER)**  
2. Implementação do **Banco de Dados MySQL**  
3. Desenvolvimento do **Diagrama de Caso de Uso**  
4. Implementação das **telas de cadastro e gerenciamento**  
5. Integração e testes das funcionalidades CRUD  

## 🧪 Execução
1. Instale e abra o **XAMPP**.  
2. Inicie o **Apache** e o **MySQL**.  
3. Importe o arquivo `banco.sql` no **phpMyAdmin**.  
4. Coloque o projeto dentro da pasta `htdocs`.  
5. Acesse no navegador:  
   ```
   http://localhost/kanban-crud/public/
   ```

## 👨‍🏫 Autor e Orientação
**Aluno:** [Seu Nome]  
**Curso:** Técnico em Desenvolvimento de Sistemas  
**Unidade:** Unidade de Desenvolvimento de Sistemas  
**Professor:** Ícaro Botelho  
