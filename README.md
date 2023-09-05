## INTRODUÇÃO
Trata-se de um projeto full stack que possibilita o gerenciamento dos registros de médicos e suas respectivas especialidades. Cada médico pode estar associado a várias especialidades, e, reciprocamente, cada especialidade pode estar relacionada a vários médicos. 
<br/><br/>
O sistema oferece funcionalidades para realizar as operações básicas de CRUD (Create, Read, Update, Delete) e, adicionalmente, disponibiliza uma listagem, que apresenta o médico e suas especialidades correspondentes. Esta função inclui filtros, como o CRM e a especialidade, para facilitar a busca e consulta de informações específicas.

## DESENVOLVIMENTO
Este projeto foi desenvolvido com a utilização do framework Laravel no lado do servidor, enquanto para a interface do usuário, utilizou-se o Blade, o Bootstrap e também a biblioteca que lida com Datatables no Laravel, o Yajra. Quanto à persistência de dados, optou-se por empregar o banco de dados MySQL, através do ambiente de desenvolvimento Xampp.
<br/><br/>
A modelagem do banco de dados pode ser visualizada na ilustração abaixo: <br/><br/>
![image](https://github.com/tadeubdossantos/controle-medicos/assets/86169857/382a08e2-f127-4ea3-84c8-98d7f2c2e06b)

## PASSO À PASSO PARA RODAR O PROJETO

Ligue o serviço do MySQL no xampp: <br/><br/>
![image](https://github.com/tadeubdossantos/controle-medicos/assets/86169857/fc752c74-ae72-473c-acca-852f8df5e53d)

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
Execute o comando abaixo para obter a versão mais recente do pacote do DataTables do Laravel
```
composer require yajra/laravel-datatables-oracle:"^10.3.1"
```
Gere a key do projeto Laravel:
```
php artisan key:generate
```
Para o projeto estar apto a ser executado:
```
php artisan serve
```
Em uma nova instância do terminal dê os comandos:
```
# para baixar as depêndencias do projeto
npm install 

# para a compilação do assets
npm run build
```
Em um nova instância do terminal dê o comando abaixo para criar o banco de dados:
```
php artisan migrate
```
<br/>
Para acessar o projeto: http://localhost:8000/
<br/>
<br/>
Caso deseje alimentar o banco de dados para teste, dê o seguinte comando:

```
php artisan db:seed
```
<br/>
