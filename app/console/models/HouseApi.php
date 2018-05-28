<?php

namespace console\models;

use common\entities\House;
use Symfony\Component\DomCrawler\Crawler;
use yii\httpclient\Client;

class HouseApi
{
    private $baseUrl = 'http://dom.mingkh.ru/api/';
    private static $fields = [
        'floors' => 'Количество этажей',
        'type' => 'Тип дома',
        'quarters' => 'Жилых помещений',
        'series' => 'Серия, тип постройки',
        'floor_type' => 'Тип перекрытий',
        'walls_material' => 'Материал несущих стен',
        'emergency' => 'Дом признан аварийным',
        'cadastral_number' => 'Кадастровый номер',
    ];

    /**
     * Получить информацию о домах региона
     * @param $region_url
     * @return null
     */
    public function actionHouses($region_url, $page, $limit)
    {
        $method = 'houses';
        $url = $this->baseUrl . '/' . $method;

        try {
            $client = new Client();
            $response = $client->createRequest()
                ->setMethod('POST')
                ->setUrl($url)
                ->setData([
                    'current' => $page,
                    'rowCount' => $limit,
                    'searchPhrase' => '',
                    'region_url' => $region_url
                ])
                ->send();

            if ($response->isOk && !empty($response->data['rows']) && !empty($response->data['total'])) {
                return [
                    'rows' => $response->data['rows'],
                    'total' => $response->data['total'],
                ];
            }
        } catch (\Exception $e) {
            return null;
        }

        return null;
    }

    public function parse($region_start, $region_end)
    {
        $query = House::find()
//            ->where(['>=', 'region_id', $region_start])
//            ->andWhere(['<=', 'region_id', $region_end])
            ->andWhere('updated_at IS NULL');

        $houses = $query->all();
        $count = $query->count();

        if (!empty($houses)) {
            foreach ($houses as $index => $house) {
                $info = static::getInfo($house);
                if (!empty($info)) {
                    $house->attributes = $info;
                    $house->updated_at = time();
                    if ($house->save()) {
                        echo "[$index / $count] - [$house->id] - $house->address - OK".PHP_EOL;
                    } else {
                        echo "[$index / $count] - [$house->id] - $house->address - ERROR!!!".PHP_EOL;
                        \Yii::info(" ID: $house->id", 'prizes_log');
                    }
                }
            }
        }
    }

    private static function getInfo(House $house)
    {
        try {
            $html = @file_get_contents('http://dom.mingkh.ru'.$house->url);
        } catch (\Exception $e) {
            return null;
        }

        if (empty($html)) {
            return null;
        }

        $crawler = new Crawler($html);
        $crawler = $crawler->filterXpath('//dl')->children();

        $items = [];
        if (!empty($crawler)) {
            $currentProperty = null;
            foreach ($crawler as $index => $item) {
                if ($item->attributes->length == 0) {
                    if ($field = array_search($item->nodeValue, static::$fields)) {
                        $currentProperty = $field;
                    } elseif (!empty($currentProperty)) {
                        $items[$currentProperty] = trim($item->nodeValue);
                        $currentProperty = null;
                    } else {
                        $currentProperty = null;
                    }
                }
            }
        }

        if (!empty($items['emergency'])) {
            $items['emergency'] = $items['emergency'] == 'Да' ? 1 : 0;
        }

        $items['floors'] = empty($items['floors']) ? 0 : intval($items['floors']);
        $items['quarters'] = empty($items['quarters']) ? 0 : intval($items['quarters']);

        return $items;
    }

}