## INTRODUÇÃO
Trata-se de um projeto full stack que possibilita o gerenciamento dos registros de médicos e suas respectivas especialidades. Cada médico pode estar associado a várias especialidades, e, reciprocamente, cada especialidade pode estar relacionada a vários médicos. 
<br/><br/>
O sistema oferece funcionalidades para realizar as operações básicas de CRUD (Create, Read, Update, Delete) e, adicionalmente, disponibiliza um recurso de geração de relatórios em formato de lista, que apresenta informações sobre os médicos e suas especialidades correspondentes. Este relatório inclui filtros, como o CRM e a especialidade, para facilitar a busca e consulta de informações específicas.

## DESENVOLVIMENTO
Este projeto foi desenvolvido com a utilização do framework Laravel no lado do servidor, enquanto para a interface do usuário, utilizou-se o Blade. Quanto à persistência de dados, optou-se por empregar o banco de dados MySQL, através do ambiente de desenvolvimento Xampp.
<br/><br/>
A modelagem do banco de dados pode ser visualizada na ilustração abaixo: <br/><br/>
![image](https://github.com/tadeubdossantos/controle-medicos/assets/86169857/9a052e11-e636-4f32-8876-e1b7869457dd)

## PASSO À PASSO PARA RODAR O PROJETO

Clone o repositório:
```
git clone https://github.com/tadeubdossantos/controle-medicos.git
```
Acesse o diretório do projeto:
```
cd controle-medicos
```
Crie o arquivo .env:
```
cp .env.example .env
```
Atualize essas variáveis de ambiente no arquivo .env:
```
APP_NAME="Controle Médicos"

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=controle-medicos
DB_USERNAME=root
DB_PASSWORD=
```
Instale as dependências do projeto:
```
composer install
```
Gere a key do projeto Laravel:
```
php artisan key:generate
```
Antes de acessar o projeto dê o seguinte comando no terminal:
```
php artisan serve
```
Em uma nova instância do terminal dê os comandos abaixo:
```
# para baixar as depêndencias do projeto
npm install 

# para a compilação dos assets
npm run build
```
Ligue o serviço do MySQL no xampp: <br/><br/>
![image](https://github.com/tadeubdossantos/controle-medicos/assets/86169857/767703b5-cc5f-4728-a49e-8ea98f221ea0)
<br/>
Para acessar o projeto: http://localhost:8000/



