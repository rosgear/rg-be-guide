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
use Ge\Exception;
use Ge\Helper\Json;
use Ge\Mvc\Module\BaseModule;
use Ge\Data\Model\DataModel;

/**
 * Модель данных разделов (дерева) справки.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Rg\Backend\Guide\Model
 * @since 1.0
 */
class TreeNodes extends DataModel
{
    /**
     * @var BaseModule|Rg\Backend\Guide\Module
     */
    public BaseModule $module;

    /**
     * Возвращает все разделы справки через CURL.
     * 
     * @param string $url URL ресурс справки.
     * 
     * @return string|bool
     */
    public function getRemoteNodes(string $url): string|bool
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);

        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    /**
     * Возвращает URL-адрес.
     * 
     * @return string|null
     * 
     * @throws Exception\ForbiddenHttpException
     */
    public function getUrl(): string
    {
        /** @var \Ge\Version\AppVersion $version */
        $version = Ge::$app->version;
        /** @var \Ge\Version\Edition $edition */
        $edition = $version->getEdition();

        if (empty($edition->docsResource)) {
            if (empty($version->docsResource)) {
                throw new Exception\ForbiddenHttpException(
                    $this->t('It is impossible to gain access to the Help section')
                );
            }
            return $version->docsResource . '/contents.json';
        }
        return $edition->docsResource . '/contents.json';
    }

    /**
     * Возвращает все разделы справки.
     * 
     * @param string $url URL ресурс справки.
     * 
     * @return array
     * 
     * @throws Exception\ForbiddenHttpException
     * @throws Exception\JsonFormatException
     */
    public function getNodes(string $url = null): array
    {
        if ($url === null) {
            $url = $this->getUrl();
        }

        $nodes = @file_get_contents($url);
        if ($nodes === false) {
            $nodes = $this->getRemoteNodes($url);
            if ($nodes === false)
                throw new Exception\ForbiddenHttpException(
                    $this->t('It is impossible to gain access to the Help section') . ': ' . $url
                );
        }
        try {
            $json = Json::decode($nodes);
            $error = Json::error();
            if ($error)
                throw new Exception\JsonFormatException(
                    $this->t('Unable to determine help sections')
                );
        } catch(\Exception $e) {
            Ge::error($e->getMessage());
        }
        return $json;
    }
}
