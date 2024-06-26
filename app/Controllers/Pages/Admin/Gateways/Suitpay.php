<?php
namespace OfficeMe\Controllers\Pages\Gateways;

class Suitpay
{
    /**
     * @throws \Pecee\Exceptions\InvalidArgumentException
     */
    public static function index() {
  
 
        return  view('gateways.list', [
                 'pagename' => 'gateways'
            ]);
    }
 

    public static function edit_gateway(string $gateway_name) {
  
 
        return  view('gateways.' . $gateway_name, [
                 'pagename' => 'gateways_edit',
                 'gateway'  => $gateway_name
            ]);
    }
 
}