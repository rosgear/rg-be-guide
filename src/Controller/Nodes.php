<?php
/**
 * Этот файл является частью модуля веб-приложения RosGear.
 * 
 * @link https://rosgear.ru/
 * @copyright Copyright (c) 2015 RosGear
 * @license https://rosgear.ru/license/
 */

namespace Rg\Backend\Guide\Controller;

use Ge\Panel\Http\Response;
use Ge\Panel\Controller\BaseController;

/**
 * Контроллер разделов (дерева) справки.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Rg\Backend\Guide\Controller
 * @since 1.0
 */
class Nodes extends BaseController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            'verb' => [
                'class'    => '\Ge\Filter\VerbFilter',
                'autoInit' => true,
                'actions'  => [
                    'data' => ['GET',  'ajax' => 'GJAX'],
                    '*'    => ['POST', 'ajax' => 'GJAX']
                ]
            ]
        ];
    }

    /**
     * Действие "data" выводит разделы справки.
     * 
     * @return Response
     */
    public function dataAction(): Response
    {
        /** @var Response $response */
        $response = $this->getResponse();

        /** @var \Rg\Backend\Guide\Model\TreeNodes $tree */
        $tree = $this->getModel('TreeNodes');
        return $response->setContent($tree->getNodes());
    }
}
