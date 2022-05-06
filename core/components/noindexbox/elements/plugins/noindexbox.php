<?php
/** @var modX $modx */
/* hello world! */

$modx->addPackage('noindexbox', MODX_CORE_PATH . 'components/noindexbox/model/');

switch ($modx->event->name) {
    case 'OnDocFormPrerender':
        /* @var int $id */
        $isChecked = 0;

        if($id > 0) {

            $query = $modx->newQuery('noindexbox');
            $query->where([
                'resource' => $id,
            ]);
            $noindexbox = $modx->getObject('noindexbox', $query);
            if(is_object($noindexbox)) {
                $isChecked = $noindexbox->get('isHidden');
            }
        }

        $modx->controller->addHtml(
            "<script>
                Ext.ComponentMgr.onAvailable('modx-resource-main-right', function(page) {
                    page.on('beforerender', function() {
                        page.insert(6,{
                          xtype: 'xcheckbox'
                          ,boxLabel: 'Исключить из индексации'
                          ,name: 'isHidden'
                          ,id: 'noindexbox-isHidden'
                          ,inputValue: 1
                          ,checked: parseInt({$isChecked}) || false
                          ,cls: 'x-hide-label'
                        });
                    });
                });
            </script>"
        );
        break;

    case 'OnDocFormSave':
        /* @var array $scriptProperties */

        $id = $scriptProperties['resource']->get('id');
        $query = $modx->newQuery('noindexbox');
        $query->where(array(
            'resource' => $id,
        ));
        $noindexbox = $modx->getObject('noindexbox',$query);
        if (!is_object($noindexbox)) {
            $noindexbox = $modx->newObject('noindexbox');
            $noindexbox->set('resource', $id);
        }
        $noindexbox->set('isHidden', $_POST['isHidden']);
        $noindexbox->save();
    break;
    case 'OnLoadWebDocument':
        $id = $modx->resource->get('id');
        $isChecked = 0;
        $query = $modx->newQuery('noindexbox');
        $query->where([
            'resource' => $id,
        ]);
        $noindexbox = $modx->getObject('noindexbox', $query);
        if(is_object($noindexbox)) {
            $isChecked = $noindexbox->get('isHidden');
        }
        if($isChecked) {
            $block = '<meta name="robots" content="noindex, nofollow" />';
            $modx->regClientStartupHTMLBlock($block);
        }
    break;
    case 'OnEmptyTrash':
        /* @var array $ids */
        $rows = $modx->removeCollection('noindexbox', [
            'resource:IN' => $ids,
        ]);

    break;
}