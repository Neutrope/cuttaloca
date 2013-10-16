<?php
App::uses('AppShell', 'Console/Command');

class BatchBaseShell extends AppShell {
    public function _welcome() { }
    
    public function log($message, $type = null) {
        if (empty($this->logfile)) {
            $this->logfile = $this->name . DS . date('Ymd');
            $dir_name = APP . DS . 'tmp' . DS . 'logs' . DS . $this->name;
            if (!file_exists($dir_name)) {
                mkdir($dir_name, 0777);
            }
        }
        parent::log($message, $this->logfile);
    }
}
