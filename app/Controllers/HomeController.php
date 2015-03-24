<?php namespace App\Controllers;


use App\Models\MonitoredStock;
use Core\BaseClasses\View;

class HomeController {
    public $stocks = [];
    public $monitoredStocks = [];

    public function __construct() {
        $monitoredStock = new MonitoredStock();
        if ( count($monitoredStock->all()) > 0) {
            $this->monitoredStocks = $this->getMonitoredStocksBySymbol($monitoredStock->all());
        }
    }

    public function home() {

        $data = [];
        $data['stocks'] = [];
        $data['monitoredStocks'] = $this->monitoredStocks;
        if ( isset($_POST['search']) ) {
            $stocks = $this->searchStocks($_POST['search_input']);
            $data['stocks'] = $stocks;
        }



        return View::render('home', compact('data'));
    }

    public function watchAction() {

    }

    private function searchStocks($search_input) {
        $search = $search_input;

        $requestUrl = 'http://dev.markitondemand.com/Api/v2/Lookup/json?input='.urlencode($search);

        $searchResults = json_decode(file_get_contents($requestUrl));

        return $this->getStocksBySymbol($searchResults);

    }

    private function getStocksBySymbol($stocks) {
        foreach( $stocks as $stock ) {
            if ( isset($stock->symbol) ) {
                $stock->Symbol = $stock->symbol;
                unset($stock->symbol);
            }

            $requestUrlForDetails = 'http://dev.markitondemand.com/Api/v2/Quote/json/?symbol='.$stock->Symbol;

            $stockDetails = json_decode(@file_get_contents($requestUrlForDetails));

            if ( isset($stockDetails->Volume)) {
                if ( $stockDetails->Volume != 0 ) {
                    array_unshift($this->stocks, $stockDetails);
                }
            }

        }

        return $this->stocks;

    }

    private function getMonitoredStocksBySymbol($stocks) {
        foreach( $stocks as $stock ) {
            if ( isset($stock->symbol) ) {
                $stock->Symbol = $stock->symbol;
                unset($stock->symbol);
            }

            $requestUrlForDetails = 'http://dev.markitondemand.com/Api/v2/Quote/json/?symbol='.$stock->Symbol;

            $stockDetails = json_decode(@file_get_contents($requestUrlForDetails));

            if ( isset($stockDetails->Volume)) {
                if ( $stockDetails->Volume != 0 ) {
                    array_unshift($this->monitoredStocks, $stockDetails);
                }
            }

        }

        return $this->monitoredStocks;

    }

}