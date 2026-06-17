<?php
/**
 * Этот файл является частью модуля веб-приложения RosGear.
 * 
 * @link https://rosgear.ru/
 * @copyright Copyright (c) 2015 RosGear
 * @license https://rosgear.ru/license/
 */
namespace Rg\Backend\Guide\Controller;

use Ge;
use Ge\Panel\Http\Response;
use Ge\Panel\Widget\TabGuide;
use Ge\Mvc\Module\BaseModule;
use Ge\Panel\Controller\BaseController;

/**
 * Контроллер панели справки.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Rg\Backend\Guide\Controller
 * @since 1.0
 */
class Docs extends BaseController
{
    /**
     * @var BaseModule|\Rg\Backend\Guide\Module
     */
    public BaseModule $module;

    /**
     * Создаёт виджет вкладки справки.
     * 
     * @return TabGuide
     */
    public function createWidget(): TabGuide
    {
        /** @var TabGuide $tab */
        $tab = new TabGuide();
        $tab
            ->setNamespaceJS('Rg.be.guide')
            ->addRequire('Rg.be.guide.IFrame' . (GE_DEBUG ? '-debug' : ''))
            ->addRequire('Rg.be.guide.Tree' . (GE_DEBUG ? '-debug' : ''))
            ->addCss(GE_DEBUG ? '/guide.css' : '/guide.min.css');
        return $tab;
    }

     /**
     * Действие "view" выводи интерфейса справки.
     * 
     * @return Response
     */
    public function viewAction(): Response
    {
        /** @var Response $response */
        $response = $this->getResponse();

        // настройки справки
        $params   = '?view=article';
        $settings = $this->module->getSettings();
        if ($settings->url == null) {
            $response
                ->meta->error($this->t('It is impossible to gain access to the Help section'));
            return $response;
        }
        if ($settings->theme != null) {
            $params .= '&theme=' . $settings->theme;
        }
        $name = Ge::$app->request->getQuery('name', false);
        if ($name)
            $frameUrl = $settings->url . $name . '.html';
        else
            $frameUrl = $settings->url;

        // получение разделов справки
        $store = $this->module->getStorage();
        if ($store->guideTreeNodes != null) {
            $nodes = $store->guideTreeNodes;
        } else {
            /** @var \Rg\Backend\Guide\Model\TreeNodes $tree */
            $tree  = $this->getModel('TreeNodes');
            $nodes = $tree->getNodes();
        }
        if (empty($nodes)) {
            $response
                ->meta->error($this->t('It is impossible to gain access to the Help section') . ': ' . $settings->url . $this->module->getBaseGuideNodesUrl());
            return $response;
        }
        $store->guideTreeNodes = $nodes;

        /** @var TabGuide $widget */
        $widget = $this->getWidget();
        // если была ошибка при формировании виджета
        if ($widget === false) {
            return $response;
        }

        // разделы справки (Ge.view.guide.TreePanel GeJS)
        $widget->tree->frameConfig['url'] = $settings->url;
        $widget->tree->frameConfig['params'] = $params;

        // панель фрейма справки (Ext.Panel Sencha ExtJS)
        $widget->frame->src = $frameUrl . $params;

        $response
            ->setContent($widget->run())
            ->meta
                ->addWidget($widget);
        return $response;
    }
}
