<?php $this->layout('layout'); ?>
<main class="container">
  <form class="container__formulario" method="post">
    <h2 class="formulario__titulo">Efetue login</h2>
    <div class="formulario__campo">
      <label class="campo__etiqueta" for="email">E-mail</label>
      <input name="email" type="email" class="campo__escrita" required placeholder="Digite seu usuário" id="email" />
    </div>
    <div class="formulario__campo">
      <label class="campo__etiqueta" for="password">Senha</label>
      <input type="password" name="password" class="campo__escrita" required placeholder="Digite sua senha" id="password" />
    </div>
    <input class="formulario__botao" type="submit" value="Entrar" />
  </form>
</main>
