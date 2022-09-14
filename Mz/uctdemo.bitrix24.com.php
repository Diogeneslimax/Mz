<?php

$config = array(

    'BOT_ID' => '412',
    'CLIENT_ID' => 'bcr7mc35ek4qe9af5b2owxw05s8zi2hq',
    'URL' => 'https://uctdemo.bitrix24.com/rest/80/b3tccjddff2i2q0a/',

    //Uras do sistema
    'SAUDACAO' => "Olá! Que bom que você entrou em contato...",
    'SUB_URA_3' => "Com qual area deseja falar?%0A%0A1 - Bitrix24%0A2 - Telefonia%0A9 - Voltar ao menu anterior",
    'CAPTURA_NOME' => "Poderia me informar o seu nome?",
    'CAPTURA_TELEFONE' => ', se necessário, vamos entrar em contato por telefone para prosseguir com o seu atendimento de forma mais personalizada. Para isso, deixe aqui abaixo o seu melhor número. Com DDD, tá bom?',
    'CAPTURA_EMAIL' => ', agora me fala seu e-mail, por favor...',
    'URA' => ', para saber como te ajudar da melhor forma, preciso que você digite o número que corresponde ao motivo desse contato: %0A' .
        '1 - Quero saber mais sobre a Conta PJ do C6 Bank; %0A' .
        '2 - Quero saber sobre crédito para empresas; %0A' .
        '3 - Quero dar um falar com um atendente;',
    //Grupos
    'COMERCIAL' => '148',
    'BITRIX' => '150',
    'TELEFONIA' => '152',
    'FINANCEIRO' => '154',

    // Pesquisar funcionários
    'SRC_USER' => 'https://uctdemo.bitrix24.com/rest/12/z2fsucx4hgkw2im3/',

    // Criar leads
    'LEADADD' => 'https://uctdemo.bitrix24.com/rest/80/jzn1fxpd12bq7yj8/',

    'USERID' => '12',


    'URA_ERRO' => "Erro",
);



function menu_ura($mensagem = NULL, $atual = NULL, $metodos, $conn, $config, $row = null)
{


    if (mb_strpos($mensagem, '=== Outgoing message, author: Bitrix24 (')) {

        //Captura do nome do usuário que enviou a mensagem pelo Wazzup
        $pos = strpos($mensagem, '(');
        $nome = substr($mensagem, ($pos + 1), -1);
        $pos = strpos($nome, ')');
        $nome = substr($nome, 0, $pos);
        //--------------------------------

        file_put_contents(__DIR__ . '/imbot.log', "\n" . 'Mensagem do Wazzup detectada com o nome: ' . $nome, FILE_APPEND);

        $IDUSER = getUserByName($config['SRC_USER'], 'user.search.json?', $nome);

        file_put_contents(__DIR__ . '/imbot.log', "\n" . "ID: $IDUSER encontrado!", FILE_APPEND);

        controler_bot($config['URL'], $metodos['CRIARLEAD'], array(

            'BOT_ID=' . $config['BOT_ID'] . '&',
            'CLIENT_ID=' . $config['CLIENT_ID'] . '&',
            'CHAT_ID=' . $_REQUEST['data']['PARAMS']['CHAT_ID'] . '&',
            'LEAVE=Y'  . '&',
            'TRANSFER_ID=' . $IDUSER

        ));
    } else {

        $ura = array(
            array(
                '0' => array(             
                    'msg' => $row['NOME'] . $config['URA'],
                    '1' => array(
                        'msg' => 'Excelente escolha! O C6 Bank hoje é o único banco que oferece uma conta PJ TOTALMENTE gratuita e benefícios incríveis...' .
                            '~Cesta de serviços, pix e tag de pedágio GRÁTIS, desconto na conta de luz de até 12%, cartão de crédito sem anuidade e sua empresa ainda pode ter CRÉDITO APROVADO mediante solicitação.~' .
                            $row['NOME'] . ', você tem interesse?' .
                            '1 - Claro! Quero abrir a minha conta agora!' .
                            '2 - Não, não tenho interesse em economizar.' .
                            '0 - Para voltar ao menu anterior.',
                        '1' => array(
                            'msg' => 'Perfeito! Em breve, um de nossos atendentes entrará em contato para dar início já à abertura da sua conta e garantir tudo isso e muito mais para a sua empresa. 😊' .
                                '~Ou então, entre em contato agora pelo nosso WhatsApp através do link: wa.me/552139008295' .
                                '~CRIARLEAD~TRANSFERIR_USER',
                        ),
                        '2' => '',
                        '0' => array(
                            'msg' => '>>VOLTAR<<'
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
        
                ),

            ),
        );

        // encontrar um meio de validar se a opção digitada pelo cliente é valida

        $ura_db = explode(';', $row['URA']);
        array_pop($ura_db);

        $message = $mensagem;
        $mensagem = '';

        $msg = $ura;

        foreach ($ura_db as $key => $value) {
            // if (array_key_exists($value, $msg)) {
                $msg = $msg[$value];
            // } else {
            //     controler_bot($config['URL'], $metodos['ENVIAR'], array(

            //         'BOT_ID=' . $config['BOT_ID'] . '&',
            //         'CLIENT_ID=' . $config['CLIENT_ID'] . '&',
            //         'DIALOG_ID=chat' . $_REQUEST['data']['PARAMS']['CHAT_ID'] . '&',
            //         'MESSAGE=Desculpa, não compreendi.',
            //     ));

            //     popUra($row, $conn);
            //     return true;
            // }
        }

        $mensagem = '';
        file_put_contents(__DIR__ . '/imbot.log', "\n" . $msg['msg'], FILE_APPEND);
        $mensagem = explode('~', $msg(['msg']));

        foreach ($mensagem as $key => $value) {

            if ($value == 'CRIARLEAD') {

                controler_bot($config['LEADADD'], $metodos['CRIARLEAD'], array(

                    'FIELDS[TITLE]=' . $row['NOME'] . '&',
                    'FIELDS[NAME]=' . $row['NOME'] . '&',
                    'FIELDS[EMAIL][0][VALUE]=' . $row['EMAIL'] . '&',
                    'FIELDS[EMAIL][0][VALUE_TYPE]=WORK' . '&',
                    'FIELDS[PHONE][0][VALUE]=' . $row['TELEFONE'] . '&',
                    'FIELDS[PHONE][0][VALUE_TYPE]=WORK'
                ));
            } elseif ($value == 'TRANSFERIR_USER') {

                controler_bot($config['URL'], $metodos['TRANSFERIR'], array(

                    'BOT_ID=' . $config['BOT_ID'] . '&',
                    'CLIENT_ID=' . $config['CLIENT_ID'] . '&',
                    'CHAT_ID=' . $_REQUEST['data']['PARAMS']['CHAT_ID'] . '&',
                    'LEAVE=Y'  . '&',
                    'TRANSFER_ID=' . $config['USERID']

                ));
            } elseif ($value == '>>VOLTAR<<') {

                popUra($row, $conn);

            } else {

                controler_bot($config['URL'], $metodos['ENVIAR'], array(

                    'BOT_ID=' . $config['BOT_ID'] . '&',
                    'CLIENT_ID=' . $config['CLIENT_ID'] . '&',
                    'DIALOG_ID=chat' . $_REQUEST['data']['PARAMS']['CHAT_ID'] . '&',
                    'MESSAGE=' . $value,
                ));
            }
        }
        updateUra($row, $message, $conn);
    }
}
