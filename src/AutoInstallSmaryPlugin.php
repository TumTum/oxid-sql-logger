<?php
/**
 * Autor: Tobias Matthaiou <developer@tobimat.eu>
 * Date: 2019-08-20
 * Time: 21:33
 */

namespace tm\oxid\sql\logger;

/**
 * Class AutoInstallSmaryPlugin
 */
class AutoInstallSmaryPlugin
{
    public function runInstall()
    {
        $oxideshop_ce = new \SplFileInfo(__DIR__ . '/../../../oxid-esales/oxideshop-ce/source/Core/Smarty/Plugin');
        $smartyPlugin = new \SplFileInfo(__DIR__ . '/Smarty/function.tm_sql_status.php');

        if ($oxideshop_ce->isDir()) {

            $target = new \SplFileInfo($oxideshop_ce->getRealPath() . '/' . $smartyPlugin->getBasename());

            if ($target->isFile() && $this->isSameFile($target, $smartyPlugin)) {
                return;
            }

            $this->createHardLink($smartyPlugin, $target);

            OxidUtilsView::clearSmarty();
        }
    }

    /**
     * @param \SplFileInfo $target
     * @param \SplFileInfo $
     * @return bool
     */
    protected function isSameFile(\SplFileInfo $target, \SplFileInfo $smartyPlugin)
    {
        return @md5_file($target->getPathname()) == @md5_file($smartyPlugin->getRealPath());
    }

    /**
     * @param \SplFileInfo $smarty_func_tm_sql_status
     * @param \SplFileInfo $target
     */
    protected function createHardLink(\SplFileInfo $smartyPlugin, \SplFileInfo $target)
    {
        if ($target->isFile()) {
            @unlink($target->getPathname());
        }

        link($smartyPlugin->getPathname(), $target->getPathname());
    }
}

