<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Argos Vision - Gestão Comercial Inteligente</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      padding: 0;
      background: #f4f4f4;
      color: #333;
    }

    header {
      background-color: #1d3557;
      color: white;
      padding: 40px 20px;
      text-align: center;
    }

    header h1 {
      margin: 0;
      font-size: 2.5em;
    }

    header p {
      margin-top: 10px;
      font-size: 1.2em;
    }

    nav {
      background-color: #457b9d;
      text-align: center;
      padding: 10px;
    }

    nav a {
      color: white;
      margin: 0 15px;
      text-decoration: none;
      font-weight: bold;
    }

    section {
      max-width: 1000px;
      margin: 40px auto;
      background: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    section h2 {
      margin-top: 0;
      color: #1d3557;
    }

    .screen img {
      max-width: 100%;
      border-radius: 8px;
      margin: 20px 0;
      box-shadow: 0 0 5px rgba(0,0,0,0.1);
    }

    footer {
      background: #1d3557;
      color: white;
      text-align: center;
      padding: 20px;
      font-size: 0.9em;
    }

    .cta {
      display: inline-block;
      margin-top: 20px;
      background: #e63946;
      color: white;
      padding: 12px 25px;
      text-decoration: none;
      border-radius: 8px;
      font-weight: bold;
      transition: background 0.3s;
    }

    .cta:hover {
      background: #d62839;
    }
  </style>
</head>
<body>

  <header>
    <h1>Argos Vision</h1>
    <p>Gestão Comercial Inteligente — Vendas, Estoque, Equipe e Finanças em um só lugar.</p>
  </header>

  <nav>
    <a href="#home">Home</a>
    <a href="#vendas">Loja</a>
    <a href="#produtos">Produtos</a>
    <a href="#vendedores">Vendedores</a>
    <a href="#financeiro">Financeiro</a>
    <a href="#perfil">Perfil</a>
    <a href="#ajuda">Help Center</a>
  </nav>

  <section>
    <h2>Apresentação</h2>
    <p>O <strong>Argos Vision</strong> é uma plataforma desenvolvida para oferecer controle total sobre o ciclo comercial de sua empresa. Com funcionalidades que integram vendas, estoque, equipe de vendas e finanças, ele transforma a maneira como você gerencia seu negócio.</p>
  </section>

  <section id="home" class="screen">
    <h2>🏠 Tela: Home</h2>
    <p>Resumo geral com dados da carteira, vendas em andamento, controle de estoque e performance dos vendedores.</p>
    <!-- Adicione aqui o print da tela -->
    <img src="prints/1home.png" alt="Tela Home">
  </section>

  <section id="vendas" class="screen">
    <h2>🛒 Tela: Loja (Cadastro de Vendas)</h2>
    <p>Registro de vendas com seleção de produto, quantidade, valor e forma de pagamento.</p>
    <img src="prints/2loja.png" alt="Tela Loja">
  </section>

  <section id="produtos" class="screen">
    <h2>📦 Tela: Produtos</h2>
    <p>Catálogo de produtos cadastrados com detalhes como valor, estoque e categoria.</p>
    <img src="prints/3produtos.png" alt="Tela Produtos">
  </section>

  <section class="screen">
    <h2>➕ Atribuir Produto a Vendedores</h2>
    <p>Atribuição de produtos para vendedores com controle individual de estoque.</p>
    <img src="prints/4atribuir.png" alt="Tela Atribuir Produto">
  </section>

  <section class="screen">
    <h2>📈 Tela: Vendas</h2>
    <p>Lista detalhada de todas as vendas com resumo de indicadores no painel superior.</p>
    <img src="prints/5vendas.png" alt="Tela Vendas">
  </section>

  <section id="vendedores" class="screen">
    <h2>👥 Tela: Vendedores</h2>
    <p>Gestão da equipe com nome, e-mail e tipo de usuário.</p>
    <img src="prints/6vendedores.png" alt="Tela Vendedores">
  </section>

  <section id="financeiro" class="screen">
    <h2>💰 Tela: Financeiro</h2>
    <p>Controle financeiro com visão da carteira, valores pagos, pendentes e histórico de comissões.</p>
    <img src="prints/7financeiro.png" alt="Tela Financeiro">
  </section>

  <section id="perfil" class="screen">
    <h2>👤 Tela: Perfil</h2>
    <p>Informações do usuário logado, estoque vinculado e desempenho comercial.</p>
    <img src="prints/perfil.png" alt="Tela Perfil">
  </section>

  <section id="ajuda" class="screen">
    <h2>❓ Tela: Help Center</h2>
    <p>Objetivo do projeto, perguntas frequentes e ajuda rápida para novos usuários.</p>
    <img src="prints/helpcenter.png" alt="Tela Help Center">
  </section>

  <section style="text-align: center;">
    <h2>Comece agora a transformar sua gestão</h2>
    <a href="#contato" class="cta">Solicitar Demonstração</a>
  </section>

  <footer>
    &copy; 2025 Argos Vision - Todos os direitos reservados.
  </footer>

</body>
</html>
