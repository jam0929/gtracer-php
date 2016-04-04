<?php defined('BASEPATH') OR exit('No direct script access allowed');

use Aws\Common\Aws;

class Awslib {

    public $aws;

    function Awslib()
    {
        require_once dirname(__FILE__).'/aws.phar';       
        /*
        $this->aws = Aws::factory(array(
          'key' => 'AKIAJ7B5DSI4P2APOOXA',
          'secret' => '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',
          'region' => Region::AP_NORTHEAST_1
        ));
        */
        $this->aws = Aws::factory(array(
            'key'    => 'AKIAJOILFK5O6IE4F4MQ',
            'secret' => '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',
            'region' => 'us-east-1'
        ));
    }
}

/* End of file awslib.php */
/* Location: ./application/libraries/awslib.php */