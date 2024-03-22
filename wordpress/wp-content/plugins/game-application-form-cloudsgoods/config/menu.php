<?php

return [       // структура меню
        'CloudsGoods'   => [
            'page_title'    => 'Clouds Goods',
            'capability'    => 'administrator',
            'slug'          => 'cgadminpage',
            'icon'          => 'https://cloudsgoods.com/favicon.ico',
            'function'      => 'generalMenu',
            'submenu'       => [
                'Создание игры' => [
                    'page_title'    => 'Создание игры страница',
                    'capability'    => 'administrator',
                    'slug'          => 'cgadminpagecreategame',
                    'function'      => 'createMenu',
                ],
                'Статистика' => [
                    'page_title'    => 'Статистика страница',
                    'capability'    => 'administrator',
                    'slug'          => 'cgadminpagestat',
                    'function'      => 'statMenu',
                ],
                'Настройка виджета' => [
                    'page_title'    => 'Настройка виджета страница',
                    'capability'    => 'administrator',
                    'slug'          => 'cgadminpagewidget',
                    'function'      => 'widgetMenu',
                ],
                'Профиль' => [
                    'page_title'    => 'Профиль страница',
                    'capability'    => 'administrator',
                    'slug'          => 'cgadminpageprofile',
                    'function'      => 'profileMenu',
                ],
                'Тарифы' => [
                    'page_title'    => 'Тарифы страница',
                    'capability'    => 'administrator',
                    'slug'          => 'cgadminpagetarif',
                    'function'      => 'tarifMenu',
                ],
                'Мои игры' => [
                    'page_title'    => 'Мои игры страница',
                    'capability'    => 'administrator',
                    'slug'          => 'cgadminpagemygames',
                    'function'      => 'myGamesMenu',
                ],
            ],
        ],
    ];
