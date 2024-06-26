<?php
namespace OfficeMe\Controllers\Pages\Admin;

class Plataforms
{
    /**
     * @throws \Pecee\Exceptions\InvalidArgumentException
     */
    public static function index() {
  
 
        return view('admin.plataforms', [
              'pagename' => 'plataforms'
            ]);
    }
     

}