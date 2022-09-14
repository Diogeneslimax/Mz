<?php


$servidor = "localhost:3306";
$usuario = "root";
$senha = "O1X0il345!w-!Ly@";
$dbname = "chat-bot";
//Criar a conexao
$conn = mysqli_connect($servidor, $usuario, $senha, $dbname);


// function getUserByName($url = NULL, $metodo = NULL, $name){
//     if(($metodo != NULL) && ($url != NULL)){

//         $response = @file_get_contents($url . $metodo . 'NAME=' . $name);
//         $response = json_decode($response, true);
    
//         file_put_contents(__DIR__ . '/imbot.log', "\n" . $url . $metodo . 'NAME=' .$name, FILE_APPEND);
//     }

//     return $response['result'][0]['ID'];
// }

// $mensagem = '=== Outgoing message, author: Bitrix24 (Bruno Moreira) ===
// hi';
// if(mb_strpos($mensagem, 'Outgoing message')){
//     $pos = strpos($mensagem, '(');
//     $nome = substr($mensagem, ($pos + 1), -1);
//     $pos = strpos($nome, ')');
//     $nome = substr($nome, 0, $pos);
//     echo $nome;

//     $response = @file_get_contents("https://uctbrasil.bitrix24.com.br/rest/235/0dnvgnta4lhgeotv/user.search.json?NAME=$nome");
//     $response = json_decode($response);

//     echo('<pre>');
//     $resultado = $response->result;
//     echo($resultado[0]->ID);
// }


// $query = "SELECT * FROM conversas WHERE CHAT_ID = '" . '2038' . "'AND URL = '" . 'uctdemo.bitrix24.com' ."'";
    
//     $result = mysqli_query($conn, $query);
//     $r = $result;
// // 8075
// $linha = mysqli_fetch_assoc($r);

// echo '<pre>';
// print_r($linha);

$str = "1;1;";

$ura_db = explode(';', $str);
array_pop($ura_db);
echo'<pre>';
// print_r($ura);

$ura = array(
    '1' => array(
        'msg' => 'mensagem com opções 1 e 2',
        '1' => array(
            'msg' => 'tranfere para funcionario 1',
        ),
        '2' => array(
            'msg' => 'tranfere para grupo 1',
        ),
    ),
    '2' => array(
        'msg' => 'mensagem 1 ~mensagem 2 com as opções 1 e 2',
        '1' => array(
            'msg' => 'mensagem de criação de lead',    
        ),
        '2' => array(
            'msg' => 'mensagem de finalização de ura',
        ),
    ),
);

$controller = 1;

$mensagem = '';

$msg = $ura;

foreach ($ura_db as $key => $value) {  

      $msg = $msg[$value];

}

$mensagem = $msg['msg']; 

$mensagem = explode('~' , $mensagem);


foreach ($mensagem as $key => $value) {  

     echo $value . '<br \>';

}
