<?php

if($_REQUEST['event'] != 'ONIMBOTJOINCHAT'){    

    if($_REQUEST['data']['PARAMS']['MESSAGE'] != '=== SYSTEM WZ === The client has not installed the app or has linked it to another number.'){

        include($_REQUEST['auth']['domain'] . '.php');
    
    include('conexao.php');
    
    include('metodos.php');
    
    include('funcoes.php');
    
    $query = "SELECT * FROM conversas WHERE CHAT_ID = '" . $_REQUEST['data']['PARAMS']['TO_CHAT_ID'] . "'AND URL = '" . $_REQUEST['auth']['domain'] ."'";
    
    $result = mysqli_query($conn, $query);
    
    if(mysqli_num_rows($result) <= 0){
    
        $query = "INSERT INTO conversas(`CHAT_ID`, `URL`) VALUES('" . $_REQUEST['data']['PARAMS']['CHAT_ID'] . "' ," . "'" . $_REQUEST['auth']['domain'] . "')";    
    
        $result = mysqli_query($conn, $query);
    
        controler_bot($config['URL'], $metodos['ENVIAR'], array(
            
            'BOT_ID=' . $config['BOT_ID'] . '&',
            'CLIENT_ID=' . $config['CLIENT_ID'] . '&',
            'DIALOG_ID=chat' . $_REQUEST['data']['PARAMS']['CHAT_ID'] . '&',
            'MESSAGE=' . $config['URA'] 
        
        ));
    
    }else{
    
        $ura = mysqli_fetch_row($result);   
    
        //file_put_contents(__DIR__ . '/imbot.log', "\n" . 'Batata', FILE_APPEND);
    // mb-finance.bitrix24.com.br
        if($_REQUEST['data']['USER']['IS_EXTRANET'] == 'Y'){

            
    
            menu_ura($_REQUEST['data']['PARAMS']['MESSAGE'], $ura[3] , $metodos, $conn, $config);
    
        }else{

            controler_bot($config['URL'], $metodos['SAIR'], array(

                'BOT_ID=' . $config['BOT_ID'] . '&',                           
                'CHAT_ID=' . $_REQUEST['data']['PARAMS']['CHAT_ID']

            ));  

        }
    
    }
    
    }


    
}


