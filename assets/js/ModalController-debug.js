/*!
 * Контроллер модального окна справки.
 * Модуль "Справочная информация".
 * Copyright 2015 RosGear. Anton Tivonenko <anton.tivonenko@gmail.com>
 * https://rosgear.ru/license/
 */

Ext.define('Rg.be.guide.ModalController', {
    extend: 'Ge.view.form.PanelController',
    alias: 'controller.rg-be-guide-modal',

    /**
     * Нажатие на кнопку "Содержание" (главная страница компонента).
     * @param {Ext.button.Button} btn
     * @param {Event} e
     * @param {Object} eOpts
     */
    clickHome: function (btn, e, eOpts ) {
        Ext.getDom('rg-guide__iframe').src = btn.handlerArgs.url;
    }
});