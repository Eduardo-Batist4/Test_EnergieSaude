# Test Energie Saúde

Este projeto foi desenvolvido como parte de um teste técnico, com o objetivo de gerenciar o fluxo de atendimentos entre clientes (proprietários), pacientes (pets) e veterinários.

Confira os detalhes no [README Principal](./OriginREADME.md).

## Passos

Abaixo, descrevo brevemente algumas etapas realizadas.

**🐶 Gestão de Pacientes & Imagens**

-   Criação de migration para adicionar a coluna picture na tabela patients.

-   Ajuste do preenchimento de campos na Model e atualização da lógica de persistência no Controller.

-   Renderização das imagens e campos atualizados nas views. Implementei uma imagem padrão para exibição caso o campo picture esteja nulo.

-   Implementei uma camada de Helper para centralizar o upload e a remoção de arquivos.
    **(** Optei por utilizar uma classe estática em App\Helpers em vez de um helper global via composer, visando melhor organização e encapsulamento.**)**

### 📅 Agendamento de Consultas (Área do Cliente)

-   O objetivo aqui foi permitir o agendamento de consultas e a visualização do histórico pelo usuário cliente.

-   Criação da tabela appointments para persistência dos dados de agendamento.

-   Estabeleci as relações entre as tabelas users, patients e appointments.

-   Desenvolvi o método checkAvailability para validar se a data e o horário selecionados estão disponíveis. Este método foi estruturado para ser consumido via script JS no front-end, melhorando a interatividade.

### 🩺 Painel do Veterinário (Atendimento)

-   Focado em listar todas as consultas agendadas para o especialista. Ao acessar um agendamento, o veterinário pode adicionar observações e salvar o prontuário.

-   Optei por uma estrutura mais robusta utilizando um Enum na tabela appointments com os status: pending (default), confirmed, cancelled e completed.

Regras de Negócio da atualização de status:

-   Apenas agendamentos com status confirmed permitem a inserção de descrições (notes). Ao salvar as notas, o sistema atualiza o status para completed automaticamente.
