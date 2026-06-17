<?php
/**
 * Этот файл является частью модуля веб-приложения RosGear.
 * 
 * Файл конфигурации установки модуля.
 * 
 * @link https://rosgear.ru/
 * @copyright Copyright (c) 2015 RosGear
 * @license https://rosgear.ru/license/
 */

return [
    'use'         => BACKEND,
    'id'          => 'rg.be.guide',
    'name'        => 'Guide', 
    'description' => 'User guide information',
    'namespace'   => 'Rg\Backend\Guide',
    'path'        => '/rg/rg.be.guide',
    'route'       => 'guide',
    'routes'      => [
        [
            'type'    => 'crudSegments',
            'options' => [
                'module'   => 'rg.be.guide',
                'route'    => 'guide',
                'prefix'   => BACKEND,
                'defaults' => [
                    'controller' => 'docs',
                    'action'     => 'view',
                ]
            ]
        ]
    ],
    'locales'     => ['ru_RU', 'en_GB'],
    'permissions' => ['any', 'view', 'read', 'settings', 'info'],
    'events'      => [],
    'required'    => [
        ['php', 'version' => '8.2'],
        ['app', 'code' => 'RG Workspace'],
        ['app', 'code' => 'RG CMS'],
        ['app', 'code' => 'RG CRM'],
    ]
];
