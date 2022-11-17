<?php

$pdo = new PDO(
  'mysql:host=localhost;dbname=web2_rest','root',''
);

$metodo = $_SERVER['REQUEST_METHOD'];
$url = $_SERVER['REQUEST_URI'];
$urlArr = explode('/', $url);

if($metodo == "POST" and $urlArr[2] === "carrinho"){

  $nome = $_POST['nome'];
  $quantidade = $_POST['quantidade'];
  $valor_unitario = $_POST['valor_unitario'];

  try{

    $verifica = $pdo->prepare("SELECT nome FROM produtos WHERE nome = ?");
    $verifica->execute([$nome]);

    if($verifica->rowCount() == 1){
      http_response_code(500);
      echo json_encode([
        "status" => 0,
        "message" => "Produto ja cadastrado"
      ]);
    }else {
      $stmt = $pdo->prepare("INSERT INTO produtos(nome,quantidade,valor_unitario) VALUES(?,?,?)");
      $stmt->execute([$nome,$quantidade,$valor_unitario]);

      if($stmt->rowCount() == 1){
        http_response_code(200);
        echo json_encode([
          "status" => 1,
          "message" => "Produto inserido com sucesso"
        ]);
      }
    }
      
  }catch(Exception $e) {
    http_response_code(500);
    echo json_encode([
      "status" => 0,
      "message" => "Erro ao inserir produto"
    ]);
  }
}

else if($metodo === "GET" and count($urlArr) <= 3 and $urlArr[2] === "carrinho"){
  
  $produtos["registros"] = [];

  try{

   $stmt = $pdo->prepare("SELECT * FROM produtos");
   $stmt->execute();
   $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach($dados as $produto){
      array_push($produtos["registros"],[
        "id" => $produto['id'],
        "nome" => $produto['nome'],
        "quantidade" => $produto['quantidade'],
        "valor_unitario" => $produto['valor_unitario']
      ]);
    }

    http_response_code(200);
    echo json_encode(array(
      "status" => 1,
      "data" => $produtos["registros"]
    ));
      
  }catch(Exception $e) {
    http_response_code(500);
    echo json_encode([
      "status" => 0,
      "message" => "Erro ao listar"
    ]);
  }

}

else if($metodo === "GET" and count($urlArr) > 3 and $urlArr[2] === "carrinho") {
  
  try{

    $stmt = $pdo->prepare("SELECT * FROM produtos WHERE nome = ?");
    $stmt->execute([$urlArr[3]]);
    $dados = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if($stmt->rowCount() == 1){
      http_response_code(200);
      echo json_encode([
        "status" => 1,
        "data" => $dados
      ]);
    } else {
      http_response_code(500);
      echo json_encode([
        "status" => 0,
        "message" => "produto nao encontrado"
      ]);
    }
          
   }catch(Exception $e) {
     http_response_code(500);
     echo json_encode([
       "status" => 0,
       "message" => "erro"
     ]);
   }
}

else if($metodo === "PUT" and count($urlArr) > 3 and $urlArr[2] === "carrinho") {
  //$data = json_decode(file_get_contents("php://input"));
  parse_str(file_get_contents("php://input"), $_PUT);
  $param = $urlArr[3];

  $consulta = $pdo->prepare("SELECT nome FROM produtos WHERE nome = ?");
  $consulta->execute([$param]);

  if($consulta->rowCount() == 1) {
    /*
    $nome_put = $data->nome;
    $quantidade_put = $data->quantidade;
    $valor_put = $data->valor_unitario;
    */
    $nome_put = @$_PUT['nome'];
    $quantidade_put = @$_PUT['quantidade'];
    $valor_put = @$_PUT['valor_unitario'];
    try{

      $verifica = $pdo->prepare("SELECT nome FROM produtos WHERE nome = ?");
      $verifica->execute([$nome_put]);
  
      if($verifica->rowCount() == 1){
        http_response_code(500);
        echo json_encode([
          "status" => 0,
          "message" => "Produto ja cadastrado"
        ]);
      }else {
        $stmt = $pdo->prepare("UPDATE produtos SET nome = ?, quantidade = ?, valor_unitario = ? WHERE nome = ?");
        $stmt->execute([$nome_put,$quantidade_put,$valor_put,$param]);
  
        if($stmt->rowCount() == 1){
          http_response_code(200);
          echo json_encode([
            "status" => 1,
            "message" => "Produto atualizado com sucesso"
          ]);
        }
      }
        
    }catch(Exception $e) {
      http_response_code(500);
      echo json_encode([
        "status" => 0,
        "message" => "Erro ao atualizar produto"
      ]);
    }
  }else {
    http_response_code(404);
      echo json_encode([
        "status" => 0,
        "message" => "Produto nao encontrado"
      ]);
  }
}

else if($metodo === "DELETE" and count($urlArr) > 3 and $urlArr[2] === "carrinho") {
  $param = $urlArr[3];

  $consulta = $pdo->prepare("SELECT nome FROM produtos WHERE nome = ?");
  $consulta->execute([$param]);

  if($consulta->rowCount() == 1) {
    try {

      $stmt = $pdo->prepare("DELETE FROM produtos WHERE nome = ?");
      $stmt->execute([$param]);
  
      if($stmt->rowCount() == 1) {
        http_response_code(200);
        echo json_encode([
          "status" => 1,
          "message" => "Produto deletado"
        ]);
      }
    }catch(Exception $e) {
      http_response_code(500);
        echo json_encode([
          "status" => 0,
          "message" => "Erro ao deletar"
        ]);
    }
  }else {
    http_response_code(404);
    echo json_encode([
      "status" => 0,
      "message" => "Produto nao encontrado"
    ]);
  }
}
?>