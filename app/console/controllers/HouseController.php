<?php

namespace console\controllers;

use common\models\House;
use common\models\Region;
use console\models\HouseApi;
use DOMDocument;
use yii\console\Controller;
use yii\filters\PageCache;
use Symfony\Component\DomCrawler\Crawler;

class HouseController extends Controller
{
    public static function actionParse($params)
    {
        $params = intval($params);
        $start = $end = 0;
        switch ($params) {
            case 1:
                $start = 1;
                $end = 30;
                break;
            case 2:
                $start = 31;
                $end = 46;
                break;
            case 3:
                $start = 47;
                $end = 61;
                break;
            case 4:
                $start = 62;
                $end = 83;
                break;
            default:
                break;
        }

        try {
            \Yii::info("Запускаюсь. Консоль №$params", 'house_parser_telegram');
            $api = new HouseApi();
            $result = $api->parse($start, $end);
        } catch (\Exception $e) {
            \Yii::info("Я сломался. Памагити! Консоль №$params", 'house_parser_telegram');
            $test = shell_exec('php yii house/parse '.$params);
            echo $test;
        }

        echo 'COMPLETED';
        return 0;
    }

    public function actionMakeList()
    {
        $regions = Region::find()->all();

        if (empty($regions)) {
            echo 'Нет регионов в БД';die;
        }

        $api = new HouseApi();
        $baseLimit = 500;

        foreach ($regions as $region) {
            $info = $api->actionHouses($region->url, 1, 1);
            $total = $info['total'];
            $info = $info['rows'];

            $pageCount = ceil($total/$baseLimit);
            sleep(3);

            for ($page = 1; $page <= $pageCount; $page++) {
                $info = $api->actionHouses($region->url, $page, $baseLimit)['rows'];

                if (!empty($info)) {
                    foreach ($info as $item) {
                        $houseModel = new House();

                        $houseModel->address = $item['address'];
                        $houseModel->square = $item['square'];
                        $houseModel->year = intval($item['year']);
                        $houseModel->floors = intval($item['floors']);
                        $houseModel->url = $item['url'];
                        $houseModel->region_id = $region->id;

                        try {
                            $houseModel->save();
                        } catch (\Exception $e) {
                            echo 'Возникла ошибка: '. $region->url.' / '.$item['url'];
                            echo PHP_EOL;
                            var_dump($houseModel->getErrors());
                            var_dump($e->getMessage());die;
                        }
                    }

                    echo $region->url. '['.$page.'/'.$pageCount.'] - success'.PHP_EOL;
                } else {
                    echo $region->url. '['.$page.'/'.$pageCount.'] - ERROR'.PHP_EOL;
                }
            }

            echo $region->url. ' - success'.PHP_EOL;
        }

        echo 'Completed';
        return;
    }
}