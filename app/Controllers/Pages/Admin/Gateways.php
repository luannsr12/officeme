<?php
namespace OfficeMe\Controllers\Pages\Admin;

class Gateways
{
    /**
     * @throws \Pecee\Exceptions\InvalidArgumentException
     */
    public static function index() {
  
 
        return  view('admin.gateways.list', [
                 'pagename' => 'gateways'
            ]);
    }
 

    public static function edit_gateway(string $gateway_name) {
  
 
        return  view('admin.gateways.' . $gateway_name, [
                 'pagename' => 'gateways_edit',
                 'gateway'  => $gateway_name
            ]);
    }
 
}