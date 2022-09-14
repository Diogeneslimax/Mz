<?php

if($_REQUEST['event'] != 'ONIMBOTJOINCHAT'){    

    if($_REQUEST['data']['PARAMS']['MESSAGE'] != '=== SYSTEM WZ === The client has not installed the app or has linked it to another number.'){

        include($_REQUEST['auth']['domain'] . '.php');
    
    include('conexao.php');
    
    include('metodos.php');
    
    include('funcoes.php');
    
    $query = "SELECT * FROM conversas WHERE CHAT_ID = '" . $_REQUEST['data']['PARAMS']['TO_CHAT_ID'] . "'AND URL = '" . $_REQUEST['auth']['domain'] . "'";
    
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);


    if(mysqli_num_rows($result) <= 0){
    
        $query = "INSERT INTO conversas(`CHAT_ID`, `URL`, `URA`) VALUES('" . $_REQUEST['data']['PARAMS']['CHAT_ID'] . "' ," . "'" . $_REQUEST['auth']['domain'] . "'". ", '0;')";    
    
        $result = mysqli_query($conn, $query);
    
        controler_bot($config['URL'], $metodos['ENVIAR'], array(
            
            'BOT_ID=' . $config['BOT_ID'] . '&',
            'CLIENT_ID=' . $config['CLIENT_ID'] . '&',
            'DIALOG_ID=chat' . $_REQUEST['data']['PARAMS']['CHAT_ID'] . '&',
            'MESSAGE=' . $config['SAUDACAO'] 
        
        ));

        sleep(1);

        controler_bot($config['URL'], $metodos['ENVIAR'], array(
            
            'BOT_ID=' . $config['BOT_ID'] . '&',
            'CLIENT_ID=' . $config['CLIENT_ID'] . '&',
            'DIALOG_ID=chat' . $_REQUEST['data']['PARAMS']['CHAT_ID'] . '&',
            'MESSAGE=' . $config['CAPTURA_NOME'] 
        
        ));

    }else{

        $query = "SELECT * FROM conversas WHERE CHAT_ID = '" . $_REQUEST['data']['PARAMS']['CHAT_ID'] . "'AND URL = '" . $_REQUEST['auth']['domain'] ."'";  
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);


        if($row['NOME'] == '' && $row['ETAPA'] != '1'){

            $query = "UPDATE conversas SET `NOME` = " . "'" . $_REQUEST['data']['PARAMS']['MESSAGE'] . "'". ", `ETAPA` = '1'" . " WHERE `ID` = '" . $row['ID'] . "'";    
    
            $result = mysqli_query($conn, $query);
            file_put_contents(__DIR__ . '/imbot.log', "\n" . $row['ID'], FILE_APPEND);

            controler_bot($config['URL'], $metodos['ENVIAR'], array(
                
                    'BOT_ID=' . $config['BOT_ID'] . '&',
                    'CLIENT_ID=' . $config['CLIENT_ID'] . '&',
                    'DIALOG_ID=chat' . $_REQUEST['data']['PARAMS']['CHAT_ID'] . '&',
                    'MESSAGE=' . $_REQUEST['data']['PARAMS']['MESSAGE'] . $config['CAPTURA_TELEFONE'] 
                
                ));
            
            return true;
        }elseif($row['ETAPA'] == '1' && $row['TELEFONE'] == ''){
            
            $query = "UPDATE conversas SET `TELEFONE` = " . "'" . $_REQUEST['data']['PARAMS']['MESSAGE'] . "'". ", `ETAPA` = '2'" . " WHERE `ID` = '" . $row['ID'] . "'";    
    
            $result = mysqli_query($conn, $query);    
            
            controler_bot($config['URL'], $metodos['ENVIAR'], array(
            
                'BOT_ID=' . $config['BOT_ID'] . '&',
                'CLIENT_ID=' . $config['CLIENT_ID'] . '&',
                'DIALOG_ID=chat' . $_REQUEST['data']['PARAMS']['CHAT_ID'] . '&',
                'MESSAGE=' . $row['NOME'] . $config['CAPTURA_EMAIL'] 
            
            ));

            return true;
            

        }elseif($row['ETAPA'] == '2' && $row['EMAIL'] == ''){
            
            $query = "UPDATE conversas SET `EMAIL` = " . "'" . $_REQUEST['data']['PARAMS']['MESSAGE'] . "'". ", `ETAPA` = '3'" . " WHERE `ID` = '" . $row['ID'] . "'";    
        
            $result = mysqli_query($conn, $query);         
            
            controler_bot($config['URL'], $metodos['ENVIAR'], array(
            
                'BOT_ID=' . $config['BOT_ID'] . '&',
                'CLIENT_ID=' . $config['CLIENT_ID'] . '&',
                'DIALOG_ID=chat' . $_REQUEST['data']['PARAMS']['CHAT_ID'] . '&',
                'MESSAGE=' . $row['NOME'] . $config['URA'] 
            
            ));

            return true;

        }else{

            menu_ura($_REQUEST['data']['PARAMS']['MESSAGE'], $ura[3] , $metodos, $conn, $config, $row);

            return true;

        }
        
        if($_REQUEST['data']['USER']['IS_EXTRANET'] == 'Y'){

            
    
            menu_ura($_REQUEST['data']['PARAMS']['MESSAGE'], $ura[3] , $metodos, $conn, $config, $row);
    
        }else{

            controler_bot($config['URL'], $metodos['SAIR'], array(

                'BOT_ID=' . $config['BOT_ID'] . '&',                           
                'CHAT_ID=' . $_REQUEST['data']['PARAMS']['CHAT_ID']

            ));  

        }
    
    }
    
    }


    
}
