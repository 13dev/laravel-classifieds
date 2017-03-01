<?php

/**
 * Mensagens costumizadas Erros/ Successos  ex: session()->flash();
 */
return [
    'errors' => [
        'files' => [
            'maxFilesAllow' => 'Deverás escolher somente 5 imagens!'
        ],
        'login' => [
            'email' => 'Por favor confirme o seu email! Enviámos-lhe um e-mail com um link de confirmação da conta. Além disso, verifique a pasta de lixo eletrônico / spam.',
            'pass_email' => 'Password ou email incorretos. Verifique as suas credenciais e tente novamente.'
        ],
        'registration' => [
            'confirm_email' => 'Havia algo de errado com o token. Tente fazer o login.'
        ],
        'category' => [
            'havechilds' => 'Problema com a categoria do anúncio, por favor tente novamente!',
        ],
    ],
    'success' => [
        'anuncio' => [
            'create' => 'Anuncio criado com sucesso!'
        ],
        'login' => [
            'logout' => 'Você está desconectado. Desejamos um bom resto do dia.'
        ],
        'perfil' => [
            'update' => ' Utilizador atualizado com sucesso!',
            'create' => ' Utilizador criado com sucesso!',
            'delete' => ' Utilizador eliminado com successo!',
            'notFound' => ' Utilizador não encontrado',
        ],
        'registration' => [
            'email_send' => 'Enviámos-lhe um e-mail com um link de confirmação da conta. Além disso, verifique a pasta de lixo eletrônico / spam.',
            'confirm_email' => 'Você verificou a conta com êxito! Faça login na sua conta. Obrigado!'
        ],
    ],
    'etc' => [
    ],
];
