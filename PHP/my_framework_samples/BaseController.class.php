<?php
class BaseController {

    public $action;
    public $globalConfig;
    public $globalDb;
    protected $myViewPath;
    protected $templum;
    protected $logThis;
    protected $logData;

    function __construct() {
        global $config;
        global $dB;

        $this->action = isset($_REQUEST['a']) ? $_REQUEST['a'] : 'main';
        $this->globalConfig = &$config;
        $this->globalDb = &$dB;
        $logThis=false;
        $logData = NULL;
    }

    public function isValidRequest() {
        return method_exists($this, $this->action);
    }

    public function run() {
        if($this->isValidRequest()) {
            $method=$this->action;
            $output = $this->${'method'}();
            if ($this->logThis) {
                if ($this->logData != NULL) {
                    $this->logEvent($this->action,$this->logData);
                } else {
                    $this->logEvent($this->action,$_POST);
                }
            }
            return $output;
        } else {
            notFoundError();
        }
    }

    protected function logEvent($fName, $eventData=NULL) {
        global $eventTypes;
        $this->logThis($eventTypes[$fName], $eventData);
    }

    protected function logThis($eventType, $eventData=NULL) {
        $collection = $this->globalDb->log;
        $eventInfo['sub_id'] = isset($_SESSION['subid']) ? $_SESSION['subid'] : 'N/A';
        $eventInfo['subscribername'] = isset($_SESSION['fullname']) ? $_SESSION['fullname'] : 'N/A' ;
        $eventInfo['email'] = isset($_SESSION['email']) ? $_SESSION['email'] : 'N/A';
        $eventInfo['ip_addr'] = $_SERVER['REMOTE_ADDR'];
        $eventInfo['date_time'] = date("Y-m-d H:i:s");
        $eventInfo['eventtype'] = $eventType;
        $eventInfo['eventdata'] = $eventData;
        $result = $collection->save($eventInfo);
    }

    protected function profileThis() {
    }
}
?>
