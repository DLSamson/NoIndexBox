<?php
/** @var xPDOTransport $transport */
/** @var array $options */
/** @var modX $modx */
if ($transport->xpdo) {
    $modx =& $transport->xpdo;

    $dev = MODX_BASE_PATH . 'Extras/noIndexBox/';
    /** @var xPDOCacheManager $cache */
    $cache = $modx->getCacheManager();
    if (file_exists($dev) && $cache) {
        if (!is_link($dev . 'assets/components/noindexbox')) {
            $cache->deleteTree(
                $dev . 'assets/components/noindexbox/',
                ['deleteTop' => true, 'skipDirs' => false, 'extensions' => []]
            );
            symlink(MODX_ASSETS_PATH . 'components/noindexbox/', $dev . 'assets/components/noindexbox');
        }
        if (!is_link($dev . 'core/components/noindexbox')) {
            $cache->deleteTree(
                $dev . 'core/components/noindexbox/',
                ['deleteTop' => true, 'skipDirs' => false, 'extensions' => []]
            );
            symlink(MODX_CORE_PATH . 'components/noindexbox/', $dev . 'core/components/noindexbox');
        }
    }
}

return true;