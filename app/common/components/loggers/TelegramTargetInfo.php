<?php

namespace common\components\loggers;

use common\components\Telegrammer;
use yii\log\FileTarget;

/**
 * Логгер в телеграм и файл
 */
class TelegramTargetInfo extends FileTarget
{
    public function export()
    {
        $text = $this->messages[0][0] . "\n";
        try {
            Telegrammer::sendMessageInfo($text);
        } catch (\Exception $e) {
            
        }

        parent::export();
    }

}