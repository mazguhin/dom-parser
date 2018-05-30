<?php

namespace console\controllers;

use common\models\Home;
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

    public function actionImport($params)
    {
        $id = intval($params);

        $files = scandir(__DIR__.'/homes');
        for ($indexFile = $id; $indexFile < count($files); $indexFile++) {
            $file = file(__DIR__ . '/homes/'.$files[$indexFile]);
            $keys = [];
            $region_id = null;
            foreach ($file as $index => $item) {
                if ($index == 0) {
                    $keys = str_getcsv($item, ';');
                } else {
                    $line = str_getcsv($item, ';');
                    if (count($keys) != count($line)) {
                        echo "ERROR - " . $files[$indexFile] . PHP_EOL;
                    } else {
                        $record = [];
                        foreach ($keys as $i => $key) {
                            $record[$key] = $line[$i];
                        }

                        if (!empty($region_id)) {
                            $model = new Home();
                            $model->identifier = array_values($record)[0];
                            unset($record['id']);
                            $model->attributes = $record;
                            $model->updated_at = time();
                            $model->region_id = $region_id;
                            try {
                                if (!$model->save()) {
                                    echo "SAVE ERROR - " . $files[$indexFile] . PHP_EOL;
                                }
                            } catch (\Exception $e) {
                                    echo "SAVE ERROR2 - " . $files[$indexFile] . PHP_EOL;
                            }
                        } else {
                            $region_name = $record['formalname_region'];
                            $region = \common\entities\Region::find()->where(['like', 'name', $region_name])->one();
                            $region_id = $region->id;
                        }

                    }
                }
            }

            echo $files[$indexFile].'['.$indexFile.'/'.count($files).'] - SUCCESS'.PHP_EOL;
        }

    }
}