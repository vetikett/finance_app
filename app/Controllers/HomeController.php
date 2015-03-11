<?php namespace App\Controllers;


use App\Models\MonitoredStock;
use Core\BaseClasses\View;

class HomeController {

    public $stocks = [];

    public function __construct() {
        $monitoredStock = new MonitoredStock();
        if ( count($monitoredStock->all()) > 0) {
            $this->stocks = $this->getStocksBySymbol($monitoredStock->all());
        }
    }

    public function home() {
        $stocks = $this->stocks;

        if ( isset($_POST['search']) ) {
            $stocks = $this->searchStocks($_POST['search_input']);
        }


        return View::render('home', compact('stocks'));
    }

    private function searchStocks($search_input) {
        $search = $search_input;

        $requestUrl = 'http://dev.markitondemand.com/Api/v2/Lookup/json?input='.$search;

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

}