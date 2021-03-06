<?php

namespace AE\Tools1C\ClientBankExchange\Model;

use AE\Tools1C\ClientBankExchange\Component;

class RemainingsSection extends Component
{
    public static function fields()
    {
        return [
            'ДатаНачала',
            'ДатаКонца',
            'РасчСчет',
            'НачальныйОстаток',
            'ВсегоПоступило',
            'ВсегоСписано',
            'КонечныйОстаток',
        ];
    }

    public function __construct($data = [])
    {
        parent::__construct($data);

        foreach (['ДатаНачала', 'ДатаКонца'] as $k) {
            if ($this->data[$k]) {
                $this->data[$k] = $this->toDate($this->data[$k]);
            }
        }

        foreach (['НачальныйОстаток', 'ВсегоПоступило', 'ВсегоСписано', 'КонечныйОстаток'] as $k) {
            if ($this->data[$k]) {
                $this->data[$k] = $this->toFloat($this->data[$k]);
            }
        }
    }
}
