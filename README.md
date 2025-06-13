# 📌 API de Gerenciamento de Tarefas (To-Do List)

Uma API RESTful construída em Laravel para gerenciamento de tarefas com autenticação via Sanctum. Cada usuário pode criar, listar, filtrar, atualizar e deletar suas próprias tarefas.

---

## ⚙️ Requisitos

- PHP >= 8.1
- Composer
- MySQL ou SQLite
- Laravel >= 12.x
- [Postman](https://www.postman.com/) ou `curl` para testar

--- 

## 🚀 Como configurar o projeto

```bash
git clone https://github.com/Kimossii/tasksge-api.git
cd seu-repo
composer install
cp .env.example .env
php artisan key:generate
```
##### NB: Alterar os dados das tuas credencias da Banco de Dodos com base as configuranções da tua máquina.
---
## 🛠️ Rodar migrations 
* No terminarl aonde tiver locazido o projecto
```bash

php artisan migrate
php artisan serve
```
Servidor geralemente roda em: http://localhost:8000


## 🧪 Testar a API
 * 🔑 Obter Token Sanctum
Faça o login (ou registre um novo usuário) e use o token para autenticação:
```bash
POST /api/auth/login

```
## 📫 Endpoints principais

### 🔐 Autenticação
#### 1. Registrar usuário 
* POST /api/auth/register
##### Exemplo:
```bash
{
  "name":"Eluki",
  "email":"eluki@email.com",
  "password":"senha123",
"password_confirmation":"senha123"
}
```
#### 2. Login e obter token
* POST /api/auth/login
```bash
{
  "email": "joao@email.com",
  "password": "senha123"
}
```
##### A resposta trará o token que você deve usar como Bearer Token nos headers de autenticação: Authorization: Bearer SEU_TOKEN_AQUI

#### 3. Logout
* POST /api/auth/logout

### 📘 Endpoints de Tarefas

#### Criar Tarefa
* POST /api/v1/tasks/ 
```bash
{
  "title": "Tarefa exemplo",
  "description": "Descrição opcional"
}
Response 201:
{
  "id": 1,
  "user_id": 1,
  "title": "Tarefa exemplo",
  "description": "Descrição opcional",
  "status": "pendente",
  "created_at": "...",
  "updated_at": "..."
}


```

#### Listar todas as tarefas do usuário
* GET /api/v1/tasks/ — Listar 
#### Filtrar por status -
* GET /api/v1/tasks/filter/{status} 
##### Filtrar por estatos: pendente; em andamento e conluída 
#### Atualizar status
PUT /api/v1/tasks/status/{status}
```bash
{
  "status": "concluída"
}
```
##### Os estatos são: pendente; em andamento e conluída

#### Deletar tarefa
DELETE /api/v1/tasks/{id} 

## ✅ Rodar testes
```bash
php artisan test
```
![Diagrama da API](public/images/API.png)

#### 🧪 Testes incluídos
* Criar tarefa

* Listar tarefas

* Filtrar por status

* Atualizar status

* Deletar tarefa

## 📘 Documentação Swagger 
#### Você pode visualizar a documentação completa da API em formato Swagger.
* http://127.0.0.1:8000/api/documentation/

 


#  Documentação Consumo API The CAT
## ✅ Testar as Rotas

##### Você pode testar as rotas no navegador ou usando o Postman:
###### Lista 5 imagens aleatórias de gatos
* " GET "  /cats	
###### Lista todas as raças disponíveis
* " GET "	/cats/breeds
###### 	Lista imagens de uma raça específica
* " GET "	/cats/race/{id}
###### Lista todas as categorias
* " GET "	/cats/categories
###### Lista imagens de uma categoria específica
* " GET "	/cats/category/{id}
###### Adiciona uma imagem aos favoritos
* " POST"	/cats/favorite
###### Lista as imagens favoritas
* " GET "/cats/favorites
## 🔐 Como configurar a chave/token da API
1. Registre-se em https://thecatapi.com/

2. Copie sua chave de API.

3. No arquivo .env, adicione
```bash
CAT_API_KEY=your_api_key_here
CAT_API_BASE=https://api.thecatapi.com/v1/

```
4. No arquivo config/services.php, adicione:
```bash
'catapi' => [
    'key' => env('CAT_API_KEY'),
    'base_uri' => env('CAT_API_BASE'),
],

```
## 🌐 Endpoints Criados
Todos os endpoints estão agrupados sob o prefixo /cats.
Exemplos:

    Listar imagens: GET /cats

    Listar raças: GET /cats/breeds

    Imagens por raça: GET /cats/race/{id}

    Favoritar imagem: POST /cats/favorite

    Listar favoritos: GET /cats/favorites
### 📥 Exemplo de Requisição (POST /cats/favorite)

Request:
```bash
POST /cats/favorite
Content-Type: application/x-www-form-urlencoded

image_id=abc123

```
Response esperada:
```bash
{
  "message": "Imagem favoritada com sucesso!"
}
```
### 📤 Exemplo de Resposta (GET /cats)
```bash
[
  {
    "id": "abc123",
    "url": "https://cdn2.thecatapi.com/images/abc123.jpg",
    "width": 1200,
    "height": 800
  },
  ...
]
```
##  ✅ Critérios de Avaliação Atendidos

* Uso correto do HTTP Client do Laravel (Http::withHeaders)

* Armazenamento seguro da chave via .env

* Tratamento de erros com fallback JSON

* Código organizado por controller e views separadas

* Documentação clara com exemplos e testes

## 📞 Contatos

- **Email:** eluckimossi@gmail.com  
- **LinkedIn:** [Eluki Júnior](https://www.linkedin.com/in/eluki-baptista/)  
- **GitHub:** [Eluki Júnior](https://github.com/Kimossii) 
