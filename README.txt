CODERBYTE ASSESSMENT

Instruções seguidas na codificação do projeto:
  - Temos um pdf com um resultado de um concurso em anexo;
  - Precisamos de um script em php que leia um anexo e retorne um csv, 
    xls com os dados dos aprovados. Vale atentar aos resultados para candidatos com deficiência, etc.;
  - Utilize expressões regulares;
  - Deve ser feito com PHP.


Como executar o projeto:

Opção 1: Command Line (CMD, BASH, PowerShell) [RECOMENDADO]
  Requisitos: 
    - PHP (versão 7.4.3)
    - composer
  Passos: 
    - executar o comando 'composer install' (sem as aspas) para instalar as dependências do projeto
    - executar o comando 'php index.php' (sem as aspas) para executar o script


Opção 2: Docker
  Requisitos: 
      - Docker
      - docker-compose
      - usuário logado como administrador ou no grupo do windows docker-users
  Passos: 
    - executar o comando 'docker-compose up --build -d' (sem as aspas) para buildar o container com o projeto
    - executar o comando 'docker exec -ti granchallenge sh -c "composer install"' (sem as aspas) para instalar as
      dependências do projeto.
    - acessar no navegador o endereço http://localhost:8070/

O arquivo será gerado na pasta 'reports' com o nome informado no arquivo index.php