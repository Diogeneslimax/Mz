<?php

$config = array(

    'BOT_ID' => '199',
    'CLIENT_ID' => 'v2a5gmggipzz8e3d4d8wq8ivth8m3fii',
    'URL' => 'https://cpapstore.bitrix24.com.br/rest/15/y9vk35dcxej97z3n/',

    //Uras do sistema
    'URA' => "Bem-vindo à central de atendimento da *CPAPSTORE*.%0A%0ADentro de alguns instantes você será atendido. Lembrando que nosso horário de atendimento é de segunda à sexta-feira, das 08:30 às 16:30.%0A%0ADigite *SOMENTE O NÚMERO* da opção desejada:%0A*1 - Comercial*%0A*2 - Entrega*%0A*3 - Pós Vendas*%0A*4 - Financeiro*",

    //Grupos
    'COMERCIAL' => '3',
    'Entregas' => '5',
    'Pos Vendas' => '7',
    'Financeiro' => '9',


);

function menu_ura($mensagem = NULL, $atual = NULL, $metodos, $conn, $config)
{

   

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
                'MESSAGE=Estamos direcionando para nossa equipe comercial... ☕😊%0A%0ALembrando que o nosso horário de atendimento é de segunda à sexta-feira, das 08:30 às 16:30.%0A%0AVocê também pode nos contatar através do e-mail atendimento@cpapstore.com.br'
                
                
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
                'MESSAGE=Estamos direcionando para nossa equipe de entregas... ☕😊%0A%0ALembrando que o nosso horário de atendimento é de segunda à sexta-feira, das 08:30 às 16:30.%0A%0AVocê também pode nos contatar através do e-mail atendimento@cpapstore.com.br'
                
                
                ));
                
                controler_bot($config['URL'], $metodos['TRANSFERIR'], array(
                
                'BOT_ID=' . $config['BOT_ID'] . '&',
                'CLIENT_ID=' . $config['CLIENT_ID'] . '&',                            
                'CHAT_ID=' . $_REQUEST['data']['PARAMS']['CHAT_ID'] . '&',
                'LEAVE=Y'  . '&',
                'QUEUE_ID=' . $config['Entregas']
                
                )); 

                $query = "DELETE FROM conversas WHERE CHAT_ID = " . $_REQUEST['data']['PARAMS']['CHAT_ID'];    
    
                $result = mysqli_query($conn, $query);


            break;

        case '3':

            controler_bot($config['URL'], $metodos['ENVIAR'], array(

                'BOT_ID=' . $config['BOT_ID'] . '&',
                'CLIENT_ID=' . $config['CLIENT_ID'] . '&',                            
                'DIALOG_ID=chat' . $_REQUEST['data']['PARAMS']['CHAT_ID'] . '&',
                'MESSAGE=Estamos direcionando para nossa equipe de pós vendas... ☕😊%0A%0ALembrando que o nosso horário de atendimento é de segunda à sexta-feira, das 08:30 às 16:30.%0A%0AVocê também pode nos contatar através do e-mail atendimento@cpapstore.com.br'
                   
                
                ));
                
                controler_bot($config['URL'], $metodos['TRANSFERIR'], array(
                
                'BOT_ID=' . $config['BOT_ID'] . '&',
                'CLIENT_ID=' . $config['CLIENT_ID'] . '&',                            
                'CHAT_ID=' . $_REQUEST['data']['PARAMS']['CHAT_ID'] . '&',
                'LEAVE=Y'  . '&',
                'QUEUE_ID=' . $config['Pos Vendas']
                
                )); 

                $query = "DELETE FROM conversas WHERE CHAT_ID = " . $_REQUEST['data']['PARAMS']['CHAT_ID'];    
    
                $result = mysqli_query($conn, $query);


            break;
            
        case '4':

            controler_bot($config['URL'], $metodos['ENVIAR'], array(

                'BOT_ID=' . $config['BOT_ID'] . '&',
                'CLIENT_ID=' . $config['CLIENT_ID'] . '&',                            
                'DIALOG_ID=chat' . $_REQUEST['data']['PARAMS']['CHAT_ID'] . '&',
                'MESSAGE=Estamos direcionando para nossa equipe financeira... ☕😊%0A%0ALembrando que o nosso horário de atendimento é de segunda à sexta-feira, das 08:30 às 16:30.%0A%0AVocê também pode nos contatar através do e-mail atendimento@cpapstore.com.br'
                  
                
                ));
                
                controler_bot($config['URL'], $metodos['TRANSFERIR'], array(
                
                'BOT_ID=' . $config['BOT_ID'] . '&',
                'CLIENT_ID=' . $config['CLIENT_ID'] . '&',                            
                'CHAT_ID=' . $_REQUEST['data']['PARAMS']['CHAT_ID'] . '&',
                'LEAVE=Y'  . '&',
                'QUEUE_ID=' . $config['Financeiro']
                
                )); 

                $query = "DELETE FROM conversas WHERE CHAT_ID = " . $_REQUEST['data']['PARAMS']['CHAT_ID'];    
    
                $result = mysqli_query($conn, $query);


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

