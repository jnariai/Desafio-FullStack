# Desafio Full Stack - Projeto de Cadastro de Desenvolvedores 🚀

Este projeto foi desenvolvido como parte do processo de avaliação técnica da Gazin Tech. O repositório original pode ser encontrado [aqui](https://github.com/gazin-tech/Desafio-FullStack).

O desafio consiste em criar uma aplicação para cadastro de desenvolvedores, permitindo associá-los a diferentes níveis de experiência. A solução possui:

- **Backend**: API RESTful construída com **Laravel 12**
- **Frontend**: SPA desenvolvida com **Vue 3**, consumindo a API

## Tecnologias Utilizadas

- **Backend:** Laravel 12
- **Frontend:** Vue 3
- **Ambiente de Execução:** Docker & Docker Compose

## Pré-requisitos

Antes de iniciar, certifique-se de ter instaladas as seguintes ferramentas:

- [Docker](https://docs.docker.com/get-docker/) **(versão 28.1.x ou superior recomendada)**
- [Docker Compose](https://docs.docker.com/compose/install/) **(versão 2.33.x ou superior recomendada)**

> O projeto foi desenvolvido e testado com essas versões. Versões inferiores podem causar incompatibilidade.

## Como executar o projeto

1. **Clone o repositório:**
   ```bash
   git clone git@github.com:jnariai/Desafio-FullStack.git
   cd Desafio-FullStack
   ```

2. **Suba os containers e aguarde a montagem do ambiente**
   ```bash
   docker compose up -d
   ```

3. **Acesse a aplicação:**
   - Frontend: [http://localhost](http://localhost)
   - API: [http://localhost/api](http://localhost/api)

4. **Documentação da API:**
   - Consulte [http://localhost/api/docs](http://localhost/api/docs) para visualizar a documentação interativa da API (gerada com [Scramble](https://scramble.dedoc.co/).

5. **Testes**
   - Para executar os testes, acesse o container e execute `php artisan test`, ou execute o seguinte comando no terminal, a partir do diretório raiz do projeto:
     `docker compose exec app php artisan test`.

## Observações

- Todas as requisições para a API devem ser feitas via `localhost/api`.
- Caso precise reiniciar ou parar os containers, utilize:
  ```bash
  docker compose down
  ```
---