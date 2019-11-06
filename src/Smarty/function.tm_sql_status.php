<?php
/*
* Smarty plugin
* -------------------------------------------------------------
* File: function.tm_sql_status.php
* Name: tm_sql_status
* Purpose: Output info on SQL dabase queries
*
* Enable: add in config.inc.php line $this->blSQLStatusBox = true
* -------------------------------------------------------------
*/
function smarty_function_tm_sql_status($aParams, &$smarty)
{
    $myConfig = \OxidEsales\Eshop\Core\Registry::getConfig();

    // muss in config.inc.php gesetzt sein

    $box = $myConfig->getConfigParam('blSQLStatusBox');

    if ($box == false) {
        return '';
    }

    $db = \OxidEsales\Eshop\Core\DatabaseProvider::getDb(\OxidEsales\Eshop\Core\DatabaseProvider::FETCH_MODE_ASSOC);
    $query = "SHOW STATUS WHERE Variable_name IN ( 'Com_select', 'Com_update', 'Com_insert', 'Com_delete' )";

    $iSelects = $iDeletes = $iInserts = $iUpdates = 0;
    $rows = $db->getAll($query);
    foreach ($rows as $row) {
        switch ($row['Variable_name']) {
            case 'Com_select':
                $iSelects = (int)$row['Value'];
                break;
            case 'Com_update':
                $iUpdates = (int)$row['Value'];
                break;
            case 'Com_insert':
                $iInserts = (int)$row['Value'];
                break;
            case 'Com_delete':
                $iDeletes = (int)$row['Value'];
                break;
            default:
                break;
        }
    }

    $iSum = $iSelects + $iDeletes + $iInserts + $iUpdates;
    $sTable = '<style>table#tmqueries { border: 1px solid black; position: fixed; bottom: 15px; left: 0; background-color: aliceblue; z-index: 90009} table#tmqueries td { padding: 6px; text-aligb:center  }</style>';
    $sTable .= '<table id="tmqueries">';
    $sTable .= "<tr><td> All: $iSum </td><td> SELECT: $iSelects </td><td> UPDATE: $iUpdates </td><td> INSERT: $iInserts </td><td> DELETE: $iDeletes </td></tr>";
    $sTable .= '</table>';

    return $sTable;
}
