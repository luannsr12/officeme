<?php
namespace OfficeMe\Controllers\Pages\Admin;

class Customers
{
    /**
     * @throws \Pecee\Exceptions\InvalidArgumentException
     */
    public static function index() {
  
 
        return  view('admin.customers', [
            'pagename' => 'customers'
            ]);
    }
 
 
}