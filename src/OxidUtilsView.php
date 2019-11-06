<?php
/**
 * Autor: Tobias Matthaiou <developer@tobimat.eu>
 * Date: 2019-08-20
 * Time: 21:33
 */

namespace tm\oxid\sql\logger;

/**
 * Class OxidUtilsView
 * @package tm\oxid\sql\logger
 */
class OxidUtilsView extends \OxidEsales\Eshop\Core\UtilsView
{

    /**
     * Removes existing Smarty instance
     */
    public static function clearSmarty()
    {
        \OxidEsales\Eshop\Core\UtilsView::$_oSmarty = null;
    }
}
