<?php
/**
 * $URL: svn://svn.mzz.ru/mzz/trunk/system/modules/admin/templates/generator/controller.list.tpl $
 *
 * MZZ Content Management System (c) 2011
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: controller.list.tpl 4201 2010-04-12 11:27:49Z desperado $
 */

/**
 * processListProcessController
 *
 * @package modules
 * @subpackage process
 * @version 0.0.1
 */
fileLoader::Load("libraries/DbSimple/Generic");
class processListProcessController extends simpleController
{
    private $skip_props = array();
    private $ref_props = array( 'user_id' => array( 'table' => 'user_user', 'ref' => 'id', 'select' => 'name' ) );

    protected function getView()
    {
        $processMapper = $this->toolkit->getMapper('process', 'process');

        $offset = $this->request->getInteger('offset', SC_GET);
        if(!$offset) {
            $offset = 0;
        }

        $limit = $this->request->getInteger('limit', SC_GET);
        if(!$limit) {
            $limit = 50;
        }

        $needFilter = $this->request->getBoolean('needFilter', SC_GET);

        $getfilters = $this->request->getArray('filter', SC_GET);

        $criteria = new criteria;
        $criteria->join('user_user', new criterion('user.id', 'process_process.user_id', criteria::EQUAL, true), 'user', criteria::JOIN_LEFT);
        $criterion = new criterion( 'id', 0, criteria::GREATER );

        if($getfilters) {
            foreach($getfilters as $gf_k => $gf_v) {
                if($gf_v != 'NO_FILTER_USE') {
                    $criterion->addAnd(new criterion("process_process.{$gf_k}", $gf_v));
                }
            }
        }

        $criteria->where($criterion);
        $criteria->orderByDesc( 'id' );
        $criteria->limit($limit);
        $criteria->offset($offset);
        $pager = $this->setPager($processMapper);
        $process = $processMapper->searchAllByCriteria($criteria);
        $criteria->table('process_process');
        $criteria->select(new SQLFunction("COUNT", "process_process.art_id"), 'count');

        $sql = $criteria->debug(true);
        $sql = strpos($sql, 'LIMIT') ? substr($sql, 0, strpos($sql, 'LIMIT')-1) : $sql;

        $db = DbSimple_Generic::connect("mysql://" . systemConfig::$db['default']['user'] . ":" . systemConfig::$db['default']['password'] . "@" . systemConfig::$db['default']['host'] . "/" . systemConfig::$db['default']['dbname']);
        if(!$db) {
            logMe("Can't connect to DB!", 4);
            $error++;
            break;
        }
        $db->query("SET NAMES `utf8`");
        $db->setErrorHandler('databaseErrorHandler');

        $count_all = $db->selectRow($sql);
        $count_all = $count_all['count'];

        if($needFilter) {
            $filter_tmp = $db->select("DESCRIBE `process_process`");
            $filter = array();
            foreach($filter_tmp as $f_tmp) {
                if(!in_array($f_tmp['Field'], $this->skip_props))
                {
                    $filter[$f_tmp['Field']]['name'] = $f_tmp['Field'];
                    $filter[$f_tmp['Field']]['code'] = $f_tmp['Field'];

                    if ( in_array( $f_tmp[ 'Field' ], array_keys( $this->ref_props ) ) )
                    {
                        $vals = $db->select( "SELECT DISTINCT `{$this->ref_props[ $f_tmp[ 'Field' ] ][ 'table' ]}`.`{$this->ref_props[ $f_tmp[ 'Field' ] ][ 'ref' ]}` as ID,
                                                              `{$this->ref_props[ $f_tmp[ 'Field' ] ][ 'table' ]}`.`{$this->ref_props[ $f_tmp[ 'Field' ] ][ 'select' ]}` as NAME
                                                         FROM `process_process` LEFT JOIN {$this->ref_props[ $f_tmp[ 'Field' ] ][ 'table' ]}
                                                         ON `process_process`.`{$f_tmp[ 'Field' ]}`=`{$this->ref_props[ $f_tmp[ 'Field' ] ][ 'table' ]}`.`{$this->ref_props[ $f_tmp[ 'Field' ] ][ 'ref' ]}`" );
                        $values = array( 'NO_FILTER_USE' => 'Без фильтра' );
                        foreach( $vals as $val )
                        {
                            $values[ $val[ 'ID' ] ] = $val[ 'NAME' ];
                        }
                    }
                    else
                    {
                        $vals = $db->selectCol("SELECT DISTINCT `{$f_tmp['Field']}` FROM `process_process`");

                        $values = array('NO_FILTER_USE' => 'Без фильтра');
                        foreach($vals as $val)
                        {
                            $values[(string)$val] = $val;
                        }
                    }
                    $filter[$f_tmp['Field']]['values'] = $values;
                }
            }
            $this->view->assign('filter', $filter);
        }

        $url = new url('process');
        $url->setAction('listProcess');

        $request_uri = strpos($_SERVER['REQUEST_URI'], '?') ? substr($_SERVER['REQUEST_URI'], strpos($_SERVER['REQUEST_URI'], '?')+1) : $_SERVER['REQUEST_URI'];
        $request_uri = str_replace($url->get(), "", $request_uri);
        $request_uri = strpos($request_uri, 'offset') ? substr($request_uri, 0, strpos($request_uri, 'offset')) : $request_uri;

        $this->view->assign('count_all', $count_all);
        $this->view->assign('request_uri', $request_uri );
        $this->view->assign('all', $process);
        $this->view->assign('getfilters', $getfilters);
        $this->view->assign('offset', $offset);
        $this->view->assign('limit', $limit);
        $this->view->assign('needFilter', $needFilter);

        return $this->render('process/listProcess.tpl');
    }
}

?>