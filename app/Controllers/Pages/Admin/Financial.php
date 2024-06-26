<?php
namespace OfficeMe\Controllers\Pages\Admin;

use OfficeMe\Model\CampaignsModel;
use OfficeMe\Model\UserModel;
use OfficeMe\Model\OptionsModel;

class Financial
{
    /**
     * @throws \Pecee\Exceptions\InvalidArgumentException
     */
    public static function index() {
  
 
        return  view('admin.financial', [
              'pagename' => 'financial'
            ]);
    }
 
 
}