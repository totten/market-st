<?php
use CRM_Marketst_ExtensionUtil as E;

class CRM_Marketst_Page_Zoo extends CRM_Core_Page {

  public function run() {
    CRM_Utils_System::setTitle(ts('Market St Zoo'));
    Civi::resources()->addBundle('bootstrap3');
    Civi::resources()->addBundle('bootstrap4');
    Civi::resources()->addBundle('bootstrap5');
    parent::run();
  }

}
