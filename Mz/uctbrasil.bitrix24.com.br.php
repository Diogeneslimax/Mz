<?php

$config = array(

    'BOT_ID' => '2449',
    'CLIENT_ID' => 'iv13x1orl1cndat3czkl1om2h9a57i65',
    'URL' => 'https://uctbrasil.bitrix24.com.br/rest/235/22h13288etctks0m/',

    //Uras do sistema
    'URA' => "Bem vindo a UC Technology.%0A%0ASelecione a opção desejada:%0A1 - Comercial%0A2 - Financeiro%0A3 - Suporte Técnico",
    'SUB_URA_3' => "Com qual area deseja falar?%0A%0A1 - Bitrix24%0A2 - Telefonia%0A9 - Voltar ao menu anterior",

    //Grupos
    'COMERCIAL' => '63',
    'BITRIX' => '67',
    'TELEFONIA' => '69',
    'FINANCEIRO' => '71',

    // Pesquisar funcionários
    'SRC_USER' => 'https://uctbrasil.bitrix24.com.br/rest/235/0dnvgnta4lhgeotv/'

);



function menu_ura($mensagem = NULL, $atual = NULL, $metodos, $conn, $config)
{

   
    if(mb_strpos($mensagem, '=== Outgoing message, author: Bitrix24 (')){
        
        //Captura do nome do usuário que enviou a mensagem pelo Wazzup
        $pos = strpos($mensagem, '(');
        $nome = substr($mensagem, ($pos + 1), -1);
        $pos = strpos($nome, ')');
        $nome = substr($nome, 0, $pos);
        //--------------------------------

        file_put_contents(__DIR__ . '/imbot.log', "\n" . 'Mensagem do Wazzup detectada com o nome: ' . $nome , FILE_APPEND);
        
        $IDUSER = getUserByName($config['SRC_USER'], 'user.search.json?', $nome);

        file_put_contents(__DIR__ . '/imbot.log', "\n" . "ID: $IDUSER encontrado!", FILE_APPEND);

        controler_bot($config['URL'], $metodos['TRANSFERIR'], array(
                
            'BOT_ID=' . $config['BOT_ID'] . '&',
            'CLIENT_ID=' . $config['CLIENT_ID'] . '&',
            'CHAT_ID=' . $_REQUEST['data']['PARAMS']['CHAT_ID'] . '&',
            'LEAVE=Y'  . '&',
            'TRANSFER_ID=' . $IDUSER
            
        ));

        return true;

    }
    if(mb_strpos($mensagem, '=== Outgoing message, author: Bitrix24')){

        controler_bot($config['URL'], $metodos['TRANSFERIR'], array(
                
            'BOT_ID=' . $config['BOT_ID'] . '&',
            'CLIENT_ID=' . $config['CLIENT_ID'] . '&',
            'CHAT_ID=' . $_REQUEST['data']['PARAMS']['CHAT_ID'] . '&',
            'LEAVE=Y'  . '&',
            'TRANSFER_ID=599'
            
        ));

        return true;
  
    }else{
        if (!is_null($atual)) {

            $navegador = $atual;
            $controler = 1;
        } else {
    
            $navegador = $mensagem;
            $controler = 0;
        }
    
    
    
    
        switch ($navegador) {
    
            case '1':
    
                controler_bot($config['URL'], $metodos['ENVIAR'], array(
    
                    'BOT_ID=' . $config['BOT_ID'] . '&',
                    'CLIENT_ID=' . $config['CLIENT_ID'] . '&',                            
                    'DIALOG_ID=chat' . $_REQUEST['data']['PARAMS']['CHAT_ID'] . '&',
                    'MESSAGE=Alguêm da equipe comercial já ira atender você'
                    
                    
                    ));
                    
                    controler_bot($config['URL'], $metodos['TRANSFERIR'], array(
                    
                    'BOT_ID=' . $config['BOT_ID'] . '&',
                    'CLIENT_ID=' . $config['CLIENT_ID'] . '&',                            
                    'CHAT_ID=' . $_REQUEST['data']['PARAMS']['CHAT_ID'] . '&',
                    'LEAVE=Y'  . '&',
                    'QUEUE_ID=' . $config['COMERCIAL']
                    
                    ));    
                    
                    $query = "DELETE FROM conversas WHERE CHAT_ID = " . $_REQUEST['data']['PARAMS']['CHAT_ID'];    
    
                    $result = mysqli_query($conn, $query);
    
    
                break;
    
            case '2':
    
                controler_bot($config['URL'], $metodos['ENVIAR'], array(
    
                    'BOT_ID=' . $config['BOT_ID'] . '&',
                    'CLIENT_ID=' . $config['CLIENT_ID'] . '&',                            
                    'DIALOG_ID=chat' . $_REQUEST['data']['PARAMS']['CHAT_ID'] . '&',
                    'MESSAGE=Alguêm da equipe financeira já ira atender você'
                    
                    
                    ));
                    
                    controler_bot($config['URL'], $metodos['TRANSFERIR'], array(
                    
                    'BOT_ID=' . $config['BOT_ID'] . '&',
                    'CLIENT_ID=' . $config['CLIENT_ID'] . '&',                            
                    'CHAT_ID=' . $_REQUEST['data']['PARAMS']['CHAT_ID'] . '&',
                    'LEAVE=Y'  . '&',
                    'QUEUE_ID=' . $config['FINANCEIRO']
                    
                    )); 
    
                    $query = "DELETE FROM conversas WHERE CHAT_ID = " . $_REQUEST['data']['PARAMS']['CHAT_ID'];    
        
                    $result = mysqli_query($conn, $query);
    
    
                break;
    
            case '3':
    
                if ($controler == 1) {
    
                    switch ($mensagem) {
    
                        case '1':
    
                            controler_bot($config['URL'], $metodos['ENVIAR'], array(
    
                                'BOT_ID=' . $config['BOT_ID'] . '&',
                                'CLIENT_ID=' . $config['CLIENT_ID'] . '&',                            
                                'DIALOG_ID=chat' . $_REQUEST['data']['PARAMS']['CHAT_ID'] . '&',
                                'MESSAGE=Alguêm da equipe de Bitrix24 já ira atender você'
                                
    
                            ));
    
                            controler_bot($config['URL'], $metodos['TRANSFERIR'], array(
    
                                
                                'CLIENT_ID=' . $config['CLIENT_ID'] . '&',                            
                                'CHAT_ID=' . $_REQUEST['data']['PARAMS']['CHAT_ID'] . '&',                            
                                'QUEUE_ID=' . $config['BITRIX'] . '&',
                                'LEAVE=' . "Y",
    
                            ));  
    
                            $query = "DELETE FROM conversas WHERE CHAT_ID = " . $_REQUEST['data']['PARAMS']['CHAT_ID'];    
    
                            $result = mysqli_query($conn, $query);
    
                            break;
    
                        case '2':
    
                            controler_bot($config['URL'], $metodos['ENVIAR'], array(
    
                                'BOT_ID=' . $config['BOT_ID'] . '&',
                                'CLIENT_ID=' . $config['CLIENT_ID'] . '&',                            
                                'DIALOG_ID=chat' . $_REQUEST['data']['PARAMS']['CHAT_ID'] . '&',
                                'MESSAGE=Alguêm da equipe de telefonia já ira atender você'
                                
    
                            ));
    
                            controler_bot($config['URL'], $metodos['TRANSFERIR'], array(
    
                                'BOT_ID=' . $config['BOT_ID'] . '&',
                                'CLIENT_ID=' . $config['CLIENT_ID'] . '&',                            
                                'CHAT_ID=' . $_REQUEST['data']['PARAMS']['CHAT_ID'] . '&',
                                'LEAVE=Y'  . '&',
                                'QUEUE_ID=' . $config['TELEFONIA']
    
                            ));  
    
                            $query = "DELETE FROM conversas WHERE CHAT_ID = " . $_REQUEST['data']['PARAMS']['CHAT_ID'];    
    
                            $result = mysqli_query($conn, $query);
    
                            break;
    
                       
    
                        case '9':
    
                            menu_ura(0, "" , $metodos, $conn, $config);
    
                            $query = "DELETE FROM conversas  WHERE CHAT_ID = '" . $_REQUEST['data']['PARAMS']['CHAT_ID'] . "' AND URL = '" . $_REQUEST['auth']['domain'] . "'";
    
                            $result = mysqli_query($conn, $query);
    
                            break;
    
                        default:
    
                            controler_bot($config['URL'], $metodos['ENVIAR'], array(
    
                                'BOT_ID=' . $config['BOT_ID'] . '&',
                                'CLIENT_ID=' . $config['CLIENT_ID'] . '&',
                                'DIALOG_ID=chat' . $_REQUEST['data']['PARAMS']['CHAT_ID'] . '&',
                                'MESSAGE=' . $config['SUB_URA_3']
    
                            ));
    
                            break;
                    }
                } else {
    
                    $query = "UPDATE conversas SET URA = '" . $navegador . "' WHERE CHAT_ID = '" . $_REQUEST['data']['PARAMS']['CHAT_ID'] . "' AND URL = '" . $_REQUEST['auth']['domain'] . "'";
    
                    $result = mysqli_query($conn, $query);
    
                    controler_bot($config['URL'], $metodos['ENVIAR'], array(
    
                        'BOT_ID=' . $config['BOT_ID'] . '&',
                        'CLIENT_ID=' . $config['CLIENT_ID'] . '&',
                        'DIALOG_ID=chat' . $_REQUEST['data']['PARAMS']['CHAT_ID'] . '&',
                        'MESSAGE=' . $config['SUB_URA_3']
    
                    ));
                }
    
                break;       
    
                case '9':
    
    
                    break;
    
                case '999':
    
    
                    break;
    
            default:
    
                controler_bot($config['URL'], $metodos['ENVIAR'], array(
    
                    'BOT_ID=' . $config['BOT_ID'] . '&',
                    'CLIENT_ID=' . $config['CLIENT_ID'] . '&',
                    'DIALOG_ID=chat' . $_REQUEST['data']['PARAMS']['CHAT_ID'] . '&',
                    'MESSAGE=' . $config['URA']
    
                ));
    
                break;
        }
    }

}

?>