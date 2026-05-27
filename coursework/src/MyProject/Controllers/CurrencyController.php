<?php

namespace MyProject\Controllers;

use MyProject\View\View;

class CurrencyController
{
    private $view;

    private const SUPPORTED = [
        'USD' => 'Доллар США',
        'EUR' => 'Евро',
        'GBP' => 'Британский фунт',
        'JPY' => 'Японская иена',
        'CNY' => 'Китайский юань',
        'TRY' => 'Турецкая лира',
    ];

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../../templates');
    }

    public function view()
    {
        $rates = $this->fetchRates();
        $result = null;
        $error = null;

        $currency = isset($_GET['currency']) && array_key_exists($_GET['currency'], self::SUPPORTED)
            ? $_GET['currency']
            : null;
        $amount = isset($_GET['amount']) ? (float) $_GET['amount'] : 1.0;

        if ($currency !== null && isset($rates[$currency])) {
            $rate = $rates[$currency];
            $result = [
                'currency'     => $currency,
                'label'        => self::SUPPORTED[$currency],
                'amount'       => $amount,
                'rub'          => round($amount * $rate['value'] / $rate['nominal'], 2),
                'rate'         => round($rate['value'] / $rate['nominal'], 4),
            ];
        } elseif ($currency !== null) {
            $error = 'Не удалось получить курс для выбранной валюты.';
        }

        $this->view->renderHtml('currency/view.php', [
            'currencies' => self::SUPPORTED,
            'rates'      => $rates,
            'selected'   => $currency,
            'amount'     => $amount,
            'result'     => $result,
            'error'      => $error,
        ]);
    }

    private function fetchRates(): array
    {
        $xml = @\file_get_contents('https://www.cbr.ru/scripts/XML_daily.asp');
        if ($xml === false) {
            return [];
        }

        $parsed = @\simplexml_load_string($xml);
        if ($parsed === false) {
            return [];
        }

        $rates = [];
        foreach ($parsed->Valute as $valute) {
            $charCode = (string) $valute->CharCode;
            if (array_key_exists($charCode, self::SUPPORTED)) {
                $rates[$charCode] = [
                    'nominal' => (int) $valute->Nominal,
                    'value'   => (float) str_replace(',', '.', (string) $valute->Value),
                    'name'    => (string) $valute->Name,
                ];
            }
        }

        return $rates;
    }
}
