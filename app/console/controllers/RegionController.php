<?php

namespace console\controllers;

use DOMDocument;
use simple_html_dom;
use yii\console\Controller;

require_once 'simple_html_dom.php';

class RegionController extends Controller
{
    public function actionParse()
    {
        $html = new simple_html_dom();
        $html->load_file('http://dom.mingkh.ru/');

        $ret = $html->find('.row');

        var_dump($ret);die;
    }
}