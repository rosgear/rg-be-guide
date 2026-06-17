/*!
 * Модуль "Справочная информация".
 * Copyright 2015 RosGear. Anton Tivonenko <anton.tivonenko@gmail.com>
 * https://rosgear.ru/license/
 */

/**
 * @class Rg.be.guide.DataModel
 * @extends Ext.data.Model
 */
Ext.define('Rg.be.guide.DataModel', {
    extend: 'Ext.data.Model',
    fields: ['text', 'doc']
});


/**
 * @class Rg.be.guide.TreePanel
 * @extends Ext.tree.Panel
 */
Ext.define('Rg.be.guide.TreePanel', {
    extend: 'Ext.tree.Panel',
    xtype: 'rg-guide-tree',
    cls: 'rg-guide-tree',
    controller: 'navigator',
    frameConfig: {},
    animate: false,
    useArrows: true,
    multiSelect: true,
    singleExpand: true,
    rootVisible: false,
    listeners: {
        itemclick: function (tree, record, item, index, e, eOpts) {
            if (!record.data.leaf) return false;
            var c = tree.panel.frameConfig;
            Ext.getCmp(c.id).loadSrc(c.url + record.data.doc + '.html' + c.params);
        }
    },
    tools: [{
         type:'refresh',
         handler: function (event, toolEl, panelHeader) {
            var tree = panelHeader.ownerCt,
                store = tree.getStore();
            store.getRootNode().removeAll();
            tree.mask();
            Ext.Ajax.request({
                url: Ge.url.build(tree.frameConfig.nodesUrl),
                method: 'get',
                success: function(response){
                    tree.unmask();
                    var response = Ge.response.normalize(response);
                    if (!response.success) {
                        Ext.Msg.exception(response, false, true);
                        return;
                    }
                    store.reload();
                    store.getRootNode().appendChild(response.data);
                },
                failure: function(response) {
                    tree.unmask();
                    Ext.Msg.exception(response, true, true);
                }
            });
        }
    }]
});
