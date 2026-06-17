<?php
/**
 * Этот файл является частью модуля веб-приложения RosGear.
 * 
 * @link https://rosgear.ru/
 * @copyright Copyright (c) 2015 RosGear
 * @license https://rosgear.ru/license/
 */

namespace Rg\Backend\Guide\Model;

use Ge;
use Ge\Panel\Data\Model\ModuleSettingsModel;

/**
 * Модель настроек модуля.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Rg\Backend\Guide\Model
 * @since 1.0
 */
class Settings extends ModuleSettingsModel
{
    /**
     * {@inheritdoc}
     */
    public function init(): void
    {
        parent::init();

        $this
            ->on(self::EVENT_AFTER_SAVE, function ($isInsert, $columns, $result, $message) {
                // всплывающие сообщение
                $this->response()
                    ->meta
                        ->cmdPopupMsg(Ge::t(BACKEND, 'Settings successfully changed'), $this->t('{settings.title}'), 'accept');
            });
    }

    /**
     * {@inheritdoc}
     */
    public function maskedAttributes(): array
    {
        return [
            'name' => 'name',
            'url' => 'url',
            'theme' => 'theme'
        ];
    }
}
