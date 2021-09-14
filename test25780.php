<?php

if (!defined('_PS_VERSION_')) {
    exit;
}


class Test25780 extends Module {

    private $output_file = __DIR__.'/hook_debug.txt';
    private $call = 0;

    public function __construct()
    {
        $this->name = 'test25780';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'yo7hli';
        $this->need_instance = 0;


        parent::__construct();

        $this->displayName = $this->l('test25780');
        $this->description = $this->l('test module for prestashop#25780 issue');

        $this->ps_versions_compliancy = array('min' => '1.7.8', 'max' => _PS_VERSION_);
      
    }

    public function install() {

      return parent::install() &&
        $this->registerHook('actionCategoryUpdate');
    }

    public function uninstall() {

        return parent::uninstall();
    }

    /**
     * Load the configuration form
     */
    public function getContent() {
        return;
    }

    public function hookActionCategoryUpdate($params) {
        $this->call++;
        $trace = '';
        foreach (debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 18) as $t) {
          $trace .= sprintf("%s:%s\n", $t['file'], $t['line']);
        }

        $out = sprintf("Call %d\n=======\n%s\n",$this->call, $trace);
        $fh = fopen($this->output_file,'a');
        fwrite($fh, $out);
        fclose($fh);
    }


}


?>
