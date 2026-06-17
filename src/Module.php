<?php
/**
 * Модуль веб-приложения RosGear.
 * 
 * @link https://rosgear.ru/
 * @copyright Copyright (c) 2015 RosGear
 * @license https://rosgear.ru/license/
 */

namespace Rg\Backend\Guide;

/**
 * Модуль справки.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Rg\Backend\Guide
 * @since 1.0
 */
class Module extends \Ge\Panel\Module\Module
{
    /**
     * @var string Локальный путь к ресурсу справки.
     */
    public const baseGuideNodesUrl = '/output/tree.json';

    /**
     * {@inheritdoc}
     */
    public string $id = 'rg.be.guide';

    /**
     * Возращение URL-пути разделов справки.
     * 
     * @return string
     */
    public function getBaseGuideNodesUrl(): string
    {
        return self::baseGuideNodesUrl;
    }
}