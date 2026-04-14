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

O Laravel, por padrão, armazena arquivos (como imagens) no diretório **storage/app/public**. No entanto, esse diretório não é acessível diretamente pelo navegador, já que o servidor web expõe apenas a pasta **public/**.
Para permitir o acesso aos arquivos, é utilizado o comando:

php artisan storage:link

(Esse comando cria um link simbólico entre public/storage e storage/app/public, possibilitando que os arquivos sejam acessados via URL)

Status consulta:

No contexto da regra de negócio de consultas, foi adotada uma abordagem simplificada visando funcionalidade e rapidez na implementação. Atualmente, ao criar uma consulta, o sistema define automaticamente um doctor_id = 2 como responsável inicial.

Quando outro veterinário acessa essa consulta e realiza alguma ação — como alteração de status ou adição de observação — o sistema atualiza o doctor_id, passando a atribuir a responsabilidade ao veterinário que realizou a interação.

Essa abordagem atende ao objetivo do projeto, mas existem alternativas mais flexíveis que podem ser consideradas conforme a evolução do sistema. Uma delas seria permitir que o campo doctor_id seja nulo (nullable()), possibilitando que qualquer veterinário assuma a consulta posteriormente. Outra opção seria definir o veterinário responsável já no momento do agendamento, evitando mudanças futuras. Também é possível implementar um modelo de “assumir consulta”, onde a responsabilidade é atribuída automaticamente ao primeiro veterinário que interagir com o registro.
