<?php

declare(strict_types=1);

namespace adRespect\Controllers;

use adRespect\Exceptions\ApiException;
use adRespect\Exceptions\AppException;
use adRespect\Exceptions\CalculatorException;
use adRespect\Models\{ApiNBPModel, CurrencyCalculatorModel, CurrencyModel};
use adRespect\Rules\CurrencyCalculatorRules;
use adRespect\View\{View, Router};

final class PageController extends AbstractController
{
    readonly View $view;
    readonly array $queryUrl;

    /**
     * @param View $view The class responsible for downloading view templates.
     * @param Router $route Route processing class.
     * @throws AppException
     */
    public function __construct(View $view, Router $route)
    {
        $this->view = $view;
        $this->queryUrl = $route->queryUrl();

        $this->action = $this->queryUrl['action'] ?? '';

        $this->view->setHTMLData(['action' => $this->action]);

        $method = $this->defineMethod();

        $this->view->renderHTML('main', 'base/');
        $this->$method();
        $this->view->renderHTML('footer', 'base/');
    }

    /**
     * @description Generates a basic view.
     * @throws AppException
     */
    public function home(): void
    {
        $currency = new CurrencyModel();

        $this->view->renderHTML('home', 'page/', [
            'currency'            => $currency->getNames(),
            'calculated_exchange' => $currency->getCalculatedExchange(),
        ]);
    }

    /**
     * @description Generates a calculator view.
     * @throws AppException
     */
    public function calculation(): void
    {
        $calculation = null;
        $message = [];
        $request = '';
        $currency = new CurrencyModel();

        try {

            $request = CurrencyCalculatorRules::validation($_POST);

            $rate = [
                'from' => $currency->getExchangeRate($request['currency']['from']),
                'for'  => $currency->getExchangeRate($request['currency']['for']),
            ];

            $calculationModel = new CurrencyCalculatorModel($rate, $request['amount']);
            $calculation = $calculationModel->calculate();

            $currency->setCalculatedExchange($calculation, $request['amount'], $request, $rate['for']);

            $calculation = number_format($calculation, 2, ',', '');

        } catch (CalculatorException $e) {

            $message[] = $e->getMessage();

        } finally {

            $this->view->renderHTML('home', 'page/', [
                'currency'            => $currency->getNames(),
                'message'             => $message,
                'calculation_result'  => $calculation,
                'calculated_exchange' => $currency->getCalculatedExchange(),
                'request'             => $request,
            ]);
        }
    }

    /**
     * @description Creates entries to the database of values retrieved from the API.
     * @return void
     * @throws AppException
     */
    private function updateCurses(): void
    {
        $response = [];
        $currency = new CurrencyModel();

        try {

            $api = new ApiNBPModel();
            $tableA = $api->getTableA();
            $tableB = $api->getTableB();

            $response[] = 'Tabela A: ' . $currency->create($tableA);
            $response[] = 'Tabela B: ' . $currency->create($tableB);

        } catch (ApiException $e) {

            $status = $e->getStatus();
            $response[] = $status['message'] . ': ' . $status['http'];

        } finally {

            $this->view->renderHTML('home', 'page/', [
                'currency'            => $currency->getNames(),
                'message'             => $response,
                'calculated_exchange' => $currency->getCalculatedExchange(),
            ]);
        }
    }
}