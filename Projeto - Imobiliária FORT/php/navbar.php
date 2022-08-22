
<nav id="nav1"class="navbar navbar-expand-sm bg-dark navbar-dark">
  <!-- Brand -->
  <a class="navbar-brand" href="php/menu.php">MENU</a>

  <!-- Links -->
  <ul class="navbar-nav">
    <!-- Dropdown -->
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="php/menu.php" id="navbardrop" data-toggle="dropdown">
        Cadastros
      </a>
      <div class="dropdown-menu">
        <a class="dropdown-item" href="cadastroFuncionario.php">Cadastrar Funcionário</a>
        <a class="dropdown-item" href="cadastroCliente.php">Cadastrar Cliente</a>
        <a class="dropdown-item" href="cadastroImovel.php">Cadastrar Imóvel</a>
      </div>
    </li>
	<li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="php/menu.php" id="navbardrop" data-toggle="dropdown">
        Mostrar
      </a>
      <div class="dropdown-menu">
        <a class="dropdown-item" href="listaFuncionario.php">Mostrar Funcionários</a>
        <a class="dropdown-item" href="listaCliente.php">Mostrar Clientes</a>
         <a class="dropdown-item" href="lista2Cliente.php">Mostrar Endereços Clientes</a>
        <a class="dropdown-item" href="listaImovel.php">Mostrar Imóveis</a>
        <a class="dropdown-item" href="fotosImovel.php">Fotos Imóveis Cadastrados</a>
      </div>
    </li>
    <a class="navbar-brand" href="php/sair.php" >LOGOUT</a>

 </ul>
</nav>
