<?php

if(($nome_put == "" or !isset($_PUT['nome'])) and ($quantidade_put == 0 or !isset($_PUT['quantidade'])) and ($valor_put == 0 or !isset($_PUT['valor_unitario']))){
  $stmt = $pdo->prepare("SELECT nome FROM produtos WHERE nome = ?");
  $stmt->execute([$param]);
  $result = $stmt->fetch();
  $nome_put = $result[0];

  $stmt = $pdo->prepare("SELECT valor_unitario FROM produtos WHERE nome = ?");
  $stmt->execute([$param]);
  $result = $stmt->fetch();
  $valor_put = $result[0];  

  $stmt = $pdo->prepare("SELECT quantidade FROM produtos WHERE nome = ?");
  $stmt->execute([$param]);
  $result = $stmt->fetch();
  $quantidade_put = $result[0];
  var_dump($nome_put,$quantidade_put,$valor_put);
  
} else if($quantidade_put == 0 or !isset($_PUT['quantidade'])) {

    if($nome_put == "" or !isset($_PUT['nome'])) {
      $stmt = $pdo->prepare("SELECT nome FROM produtos WHERE nome = ?");
      $stmt->execute([$param]);
      $result = $stmt->fetch();
      $nome_put = $result[0];
    } else if($valor_put == 0 or !isset($_PUT['valor_unitario'])){
      $stmt = $pdo->prepare("SELECT valor_unitario FROM produtos WHERE nome = ?");
      $stmt->execute([$param]);
      $result = $stmt->fetch();
      $valor_put = $result[0];  
    }

    $stmt = $pdo->prepare("SELECT quantidade FROM produtos WHERE nome = ?");
    $stmt->execute([$param]);
    $result = $stmt->fetch();
    $quantidade_put = $result[0];
    var_dump($nome_put,$quantidade_put,$valor_put);

} else if($valor_put == 0 or !isset($_PUT['valor_unitario'])) {

    if($nome_put == "" or !isset($_PUT['nome'])) {
      $stmt = $pdo->prepare("SELECT nome FROM produtos WHERE nome = ?");
      $stmt->execute([$param]);
      $result = $stmt->fetch();
      $nome_put = $result[0];
    } else if($quantidade_put == 0 or !isset($_PUT['quantidade'])){
      $stmt = $pdo->prepare("SELECT quantidade FROM produtos WHERE nome = ?");
      $stmt->execute([$param]);
      $result = $stmt->fetch();
      $quantidade_put = $result[0];
    }

  $stmt = $pdo->prepare("SELECT valor_unitario FROM produtos WHERE nome = ?");
  $stmt->execute([$param]);
  $result = $stmt->fetch();
  $valor_put = $result[0];
  var_dump($nome_put,$quantidade_put,$valor_put);
  

} else if($nome_put == "" or !isset($_PUT['nome'])){

  if($quantidade_put == 0 or !isset($_PUT['quantidade'])){
    $stmt = $pdo->prepare("SELECT quantidade FROM produtos WHERE nome = ?");
    $stmt->execute([$param]);
    $result = $stmt->fetch();
    $quantidade_put = $result[0];
  } 

  else if($valor_put == 0 or !isset($_PUT['valor_unitario'])){
    $stmt = $pdo->prepare("SELECT valor_unitario FROM produtos WHERE nome = ?");
    $stmt->execute([$param]);
    $result = $stmt->fetch();
    $valor_put = $result[0];  
  }

  $stmt = $pdo->prepare("SELECT nome FROM produtos WHERE nome = ?");
  $stmt->execute([$param]);
  $result = $stmt->fetch();
  $nome_put = $result[0];
  var_dump($nome_put,$quantidade_put,$valor_put);

}

?>