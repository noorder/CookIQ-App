<?php
//тут прописываем маршруты

return [
    '' => [
        'controller' => 'main',
        'action' => 'index',
    ],

    'account/login' => [
        'controller' => 'account',
        'action' => 'login',
    ],

    'account/register' => [
        'controller' => 'account',
        'action' => 'register',
    ],

    'posts/show' => [
        'controller' => 'posts',
        'action' => 'show',
    ],
]

?>