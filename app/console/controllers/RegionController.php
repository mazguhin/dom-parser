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

        $ul = $html->find('.row')[3];
        var_dump($ul->plaintext);die;
        foreach ($ul->find('li') as $li) {
            var_dump($li->plaintext);
        }

//        var_dump($ret);die;
    }
}