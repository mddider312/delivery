<?php

namespace Billplz\Minisite;

class Connect
{
    private $api_key;
    private $x_signature_key;
    private $collection_id;

    private $process; //cURL or GuzzleHttp
    public $is_production;
    public $detect_mode = false;
    public $url;
    public $webhook_rank;

    public $header;

    const TIMEOUT = 10; //10 Seconds
    const PRODUCTION_URL = 'https://www.billplz.com/api/';
    const STAGING_URL = 'https://www.billplz-sandbox.com/api/';

    public function __construct($api_key)
    {
        $this->api_key = $api_key;


        if (\class_exists('\GuzzleHttp\Client') && \class_exists('\GuzzleHttp\Exception\ClientException')) {
            $this->process = new \GuzzleHttp\Client();
            $this->header = array(
                'auth' => [$this->api_key, ''],
                'verify' => false
            );
        } else {
            $this->process = curl_init();
            $this->header = $api_key . ':';
            curl_setopt($this->process, CURLOPT_HEADER, 0);
            curl_setopt($this->process, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($this->process, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($this->process, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($this->process, CURLOPT_TIMEOUT, self::TIMEOUT);
            curl_setopt($this->process, CURLOPT_USERPWD, $this->header);
        }
    }

    public function setMode($is_production = false)
    {
        $this->is_production = $is_production;
        if ($is_production) {
            $this->url = self::PRODUCTION_URL;
        } else {
            $this->url = self::STAGING_URL;
        }
    }

    public function detectMode()
    {
         
        $this->url = self::PRODUCTION_URL;
        $this->detect_mode = true;
        return $this;
    }

    public function getWebhookRank()
    {
        $url = $this->url . 'v4/webhook_rank';

        if ($this->process instanceof \GuzzleHttp\Client) {
            $return = $this->guzzleProccessRequest('GET', $url, $this->header);
        } else {
            curl_setopt($this->process, CURLOPT_URL, $url);
            curl_setopt($this->process, CURLOPT_POST, 0);
            $body = curl_exec($this->process);
            $header = curl_getinfo($this->process, CURLINFO_HTTP_CODE);
            $return = array($header,$body);
        }
        return $return;
    }

    public function getCollectionIndex($parameter = array())
    {
        $url = $this->url . 'v4/collections?'.http_build_query($parameter);

        if ($this->process instanceof \GuzzleHttp\Client) {
            $return = $this->guzzleProccessRequest('GET', $url, $this->header);
        } else {
            curl_setopt($this->process, CURLOPT_URL, $url);
            curl_setopt($this->process, CURLOPT_POST, 0);
            $body = curl_exec($this->process);
            $header = curl_getinfo($this->process, CURLINFO_HTTP_CODE);
            $return = array($header,$body);
        }
        return $return;
    }

    public function createCollection($title, $optional = array())
    {
        $url = $this->url . 'v4/collections';

        $body = http_build_query(['title' => $title]);
        if (isset($optional['split_header'])) {
            $split_header = http_build_query(array('split_header' => $optional['split_header']));
        }

        $split_payments = [];
        if (isset($optional['split_payments'])) {
            foreach ($optional['split_payments'] as $param) {
                $split_payments[] = http_build_query($param);
            }
        }

        if (!empty($split_payments)) {
            $body.= '&' . implode('&', $split_payments);

            if (!empty($split_header)) {
                $body.= '&' . $split_header;
            }
        }

        if ($this->process instanceof \GuzzleHttp\Client) {
            $header = $this->header;
            $header['query'] = $body;
            $return = $this->guzzleProccessRequest('POST', $url, $header);
        } else {
            curl_setopt($this->process, CURLOPT_URL, $url);
            curl_setopt($this->process, CURLOPT_POSTFIELDS, $body);
            $body = curl_exec($this->process);
            $header = curl_getinfo($this->process, CURLINFO_HTTP_CODE);
            $return = array($header,$body);
        }

        return $return;
    }

    public function createOpenCollection($parameter, $optional = array())
    {
        $url = $this->url . 'v4/open_collections';

        $body = http_build_query($parameter);
        if (isset($optional['split_header'])) {
            $split_header = http_build_query(array('split_header' => $optional['split_header']));
        }

        $split_payments = [];
        if (isset($optional['split_payments'])) {
            foreach ($optional['split_payments'] as $param) {
                $split_payments[] = http_build_query($param);
            }
        }

        if (!empty($split_payments)) {
            unset($optional['split_payments']);
            $body.= '&' . implode('&', $split_payments);
            if (!empty($split_header)) {
                unset($optional['split_header']);
                $body.= '&' . $split_header;
            }
        }

        if (!empty($optional)) {
            $body.= '&' . http_build_query($optional);
        }

        if ($this->process instanceof \GuzzleHttp\Client) {
            $header = $this->header;
            $header['query'] = $body;
            $return = $this->guzzleProccessRequest('POST', $url, $header);
        } else {
            curl_setopt($this->process, CURLOPT_URL, $url);
            curl_setopt($this->process, CURLOPT_POSTFIELDS, $body);
            $body = curl_exec($this->process);
            $header = curl_getinfo($this->process, CURLINFO_HTTP_CODE);
            $return = array($header,$body);
        }

        return $return;
    }

    public function getCollection($id)
    {
        $url = $this->url . 'v4/collections/'.$id;

        if ($this->process instanceof \GuzzleHttp\Client) {
            $return = $this->guzzleProccessRequest('GET', $url, $this->header);
        } else {
            curl_setopt($this->process, CURLOPT_URL, $url);
            curl_setopt($this->process, CURLOPT_POST, 0);
            $body = curl_exec($this->process);
            $header = curl_getinfo($this->process, CURLINFO_HTTP_CODE);
            $return = array($header,$body);
        }

        return $return;
    }

    public function getOpenCollection($id)
    {
        $url = $this->url . 'v4/open_collections/'.$id;
        if ($this->process instanceof \GuzzleHttp\Client) {
            $return = $this->guzzleProccessRequest('GET', $url, $this->header);
        } else {
            curl_setopt($this->process, CURLOPT_URL, $url);
            curl_setopt($this->process, CURLOPT_POST, 0);
            $body = curl_exec($this->process);
            $header = curl_getinfo($this->process, CURLINFO_HTTP_CODE);
            $return = array($header,$body);
        }

        return $return;
    }

    public function getOpenCollectionIndex($parameter = array())
    {
        $url = $this->url . 'v4/open_collections?'.http_build_query($parameter);

        if ($this->process instanceof \GuzzleHttp\Client) {
            $return = $this->guzzleProccessRequest('GET', $url, $this->header);
        } else {
            curl_setopt($this->process, CURLOPT_URL, $url);
            curl_setopt($this->process, CURLOPT_POST, 0);
            $body = curl_exec($this->process);
            $header = curl_getinfo($this->process, CURLINFO_HTTP_CODE);
            $return = array($header,$body);
        }
        return $return;
    }

    public function createMPICollection($title)
    {
        $url = $this->url . 'v4/mass_payment_instruction_collections';

        $data = ['title' => $title];

        if ($this->process instanceof \GuzzleHttp\Client) {
            $header = $this->header;
            $header['form_params'] = $data;
            $return = $this->guzzleProccessRequest('POST', $url, $header);
        } else {
            curl_setopt($this->process, CURLOPT_URL, $url);
            curl_setopt($this->process, CURLOPT_POSTFIELDS, http_build_query($data));
            $body = curl_exec($this->process);
            $header = curl_getinfo($this->process, CURLINFO_HTTP_CODE);
            $return = array($header,$body);
        }

        return $return;
    }

    public function getMPICollection($id)
    {
        $url = $this->url . 'v4/mass_payment_instruction_collections/'.$id;
        if ($this->process instanceof \GuzzleHttp\Client) {
            $return = $this->guzzleProccessRequest('GET', $url, $this->header);
        } else {
            curl_setopt($this->process, CURLOPT_URL, $url);
            curl_setopt($this->process, CURLOPT_POST, 0);
            $body = curl_exec($this->process);
            $header = curl_getinfo($this->process, CURLINFO_HTTP_CODE);
            $return = array($header,$body);
        }

        return $return;
    }

    public function createMPI($parameter, $optional = array())
    {
        $url = $this->url . 'v4/mass_payment_instructions';

        //if (sizeof($parameter) !== sizeof($optional) && !empty($optional)){
        //    throw new \Exception('Optional parameter size is not match with Required parameter');
        //}

        $data = array_merge($parameter, $optional);

        if ($this->process instanceof \GuzzleHttp\Client) {
            $header = $this->header;
            $header['form_params'] = $data;
            $return = $this->guzzleProccessRequest('POST', $url, $header);
        } else {
            curl_setopt($this->process, CURLOPT_URL, $url);
            curl_setopt($this->process, CURLOPT_POSTFIELDS, http_build_query($data));
            $body = curl_exec($this->process);
            $header = curl_getinfo($this->process, CURLINFO_HTTP_CODE);
            $return = array($header,$body);
        }

        return $return;
    }

    public function getMPI($id)
    {
        $url = $this->url . 'v4/mass_payment_instructions/'.$id;
        if ($this->process instanceof \GuzzleHttp\Client) {
            $return = $this->guzzleProccessRequest('GET', $url, $this->header);
        } else {
            curl_setopt($this->process, CURLOPT_URL, $url);
            curl_setopt($this->process, CURLOPT_POST, 0);
            $body = curl_exec($this->process);
            $header = curl_getinfo($this->process, CURLINFO_HTTP_CODE);
            $return = array($header,$body);
        }

        return $return;
    }

    public static function buildSourceString($data, $prefix = '')
    {
        uksort($data, function ($a, $b) {
            $a_len = strlen($a);
            $b_len = strlen($b);
            $result = strncasecmp($a, $b, min($a_len, $b_len));
            if ($result === 0) {
                $result = $b_len - $a_len;
            }
            return $result;
        });
        $processed = [];
        foreach ($data as $key => $value) {
            if ($key === 'x_signature') {
                continue;
            }
     
            if (is_array($value)) {
                $processed[] = self::buildSourceString($value, $key);
            } else {
                $processed[] = $prefix . $key . stripslashes($value);
            }
        }
        return implode('|', $processed);
    }

    public static function getXSignature($x_signature_key)
    {
        $data = array();

        if (isset($_GET['billplz']['x_signature'])) {
            $keys = array('id', 'paid_at', 'paid', 'transaction_id', 'transaction_status', 'x_signature');

            foreach ($keys as $key){
                if (isset($_GET['billplz'][$key])){
                    $data['billplz'][$key] = $_GET['billplz'][$key];
                }
            } 
            $type = 'redirect';
        } elseif (isset($_POST['x_signature'])) {
            $keys = array('amount', 'collection_id', 'due_at', 'email', 'id', 'mobile', 'name', 'paid_amount', 'transaction_id', 'transaction_status', 'paid_at', 'paid', 'state', 'url', 'x_signature');
            foreach ($keys as $key){
                if (isset($_POST[$key])){
                    $data[$key] = $_POST[$key];
                }
            }
            $type = 'callback';
        } else {
            throw new \Exception('X Signature on Payment Completion not activated.');
        }

        $signing = self::buildSourceString($data);

        if ($type == 'redirect'){
            $data = $data['billplz'];
        }

        /*
         * Convert paid status to boolean
         */
        $data['paid'] = $data['paid'] === 'true' ? true : false;

        $signed = hash_hmac('sha256', $signing, $x_signature_key);

        if ($data['x_signature'] === $signed) {
            $data['type'] = $type;
            return $data;
        }

        throw new \Exception('X Signature Calculation Mismatch!');
    }
    
    public function deactivateCollection($title, $option = 'deactivate')
    {
        $url = $this->url . 'v3/collections/'.$title.'/'.$option;

        $data = ['title' => $title];

        if ($this->process instanceof \GuzzleHttp\Client) {
            $header = $this->header;
            $header['form_params'] = array();
            $return = $this->guzzleProccessRequest('POST', $url, $header);
        } else {
            curl_setopt($this->process, CURLOPT_URL, $url);
            curl_setopt($this->process, CURLOPT_POST, 1);
            curl_setopt($this->process, CURLOPT_POSTFIELDS, http_build_query(array()));
            $body = curl_exec($this->process);
            $header = curl_getinfo($this->process, CURLINFO_HTTP_CODE);
            $return = array($header,$body);
        }

        return $return;
    }

    public function createBill($parameter, $optional = array())
    {
        $url = $this->url . 'v3/bills';

        //if (sizeof($parameter) !== sizeof($optional) && !empty($optional)){
        //    throw new \Exception('Optional parameter size is not match with Required parameter');
        //}

        $data = array_merge($parameter, $optional);

        if ($this->process instanceof \GuzzleHttp\Client) {
            $header = $this->header;
            $header['form_params'] = $data;
            $return = $this->guzzleProccessRequest('POST', $url, $header);
        } else {
            curl_setopt($this->process, CURLOPT_URL, $url);
            curl_setopt($this->process, CURLOPT_POSTFIELDS, http_build_query($data));
            $body = curl_exec($this->process);
            $header = curl_getinfo($this->process, CURLINFO_HTTP_CODE);
            $return = array($header,$body);
        }

        return $return;
    }

    public function getBill($id)
    {

        $url = $this->url . 'v3/bills/'.$id;

        if ($this->process instanceof \GuzzleHttp\Client) {
            $header = $this->header;
            $header['form_params'] = array();
            $return = $this->guzzleProccessRequest('GET', $url, $header);
        } else {
            curl_setopt($this->process, CURLOPT_URL, $url);
            curl_setopt($this->process, CURLOPT_POST, 0);
            $body = curl_exec($this->process);
            $header = curl_getinfo($this->process, CURLINFO_HTTP_CODE);
            $return = array($header,$body);
        }

        return $return;
    }

    public function deleteBill($id)
    {
        $url = $this->url . 'v3/bills/'.$id;

        if ($this->process instanceof \GuzzleHttp\Client) {
            $header = $this->header;
            $header['form_params'] = array();
            $return = $this->guzzleProccessRequest('DELETE', $url, $header);
        } else {
            curl_setopt($this->process, CURLOPT_URL, $url);
            curl_setopt($this->process, CURLOPT_CUSTOMREQUEST, "DELETE");
            $body = curl_exec($this->process);
            $header = curl_getinfo($this->process, CURLINFO_HTTP_CODE);
            $return = array($header,$body);
        }

        return $return;
    }

    public function bankAccountCheck($id)
    {
        $url = $this->url . 'v3/check/bank_account_number/'.$id;
        if ($this->process instanceof \GuzzleHttp\Client) {
            $return = $this->guzzleProccessRequest('GET', $url, $this->header);
        } else {
            curl_setopt($this->process, CURLOPT_URL, $url);
            curl_setopt($this->process, CURLOPT_POST, 0);
            $body = curl_exec($this->process);
            $header = curl_getinfo($this->process, CURLINFO_HTTP_CODE);
            $return = array($header,$body);
        }

        return $return;
    }

    public function getPaymentMethodIndex($id)
    {
        $url = $this->url . 'v3/collections/'.$id.'/payment_methods';
        if ($this->process instanceof \GuzzleHttp\Client) {
            $return = $this->guzzleProccessRequest('GET', $url, $this->header);
        } else {
            curl_setopt($this->process, CURLOPT_URL, $url);
            curl_setopt($this->process, CURLOPT_POST, 0);
            $body = curl_exec($this->process);
            $header = curl_getinfo($this->process, CURLINFO_HTTP_CODE);
            $return = array($header,$body);
        }

        return $return;
    }

    public function getTransactionIndex($id, $parameter)
    {
        $url = $this->url . 'v3/bills/'.$id.'/transactions?'.http_build_query($parameter);

        if ($this->process instanceof \GuzzleHttp\Client) {
            $return = $this->guzzleProccessRequest('GET', $url, $this->header);
        } else {
            curl_setopt($this->process, CURLOPT_URL, $url);
            curl_setopt($this->process, CURLOPT_POST, 0);
            $body = curl_exec($this->process);
            $header = curl_getinfo($this->process, CURLINFO_HTTP_CODE);
            $return = array($header,$body);
        }

        return $return;
    }

    public function updatePaymentMethod($parameter)
    {
        if (!isset($parameter['collection_id'])) {
            throw new \Exception('Collection ID is not passed on updatePaymethodMethod');
        }
        $url = $this->url . 'v3/collections/'.$parameter['collection_id'].'/payment_methods';

        unset($parameter['collection_id']);
        $data = $parameter;
        $header = $this->header;

        $body = [];
        foreach ($data['payment_methods'] as $param) {
            $body[] = http_build_query($param);
        }

        if ($this->process instanceof \GuzzleHttp\Client) {
            $header['query'] = implode('&', $body);

            $return = $this->guzzleProccessRequest('PUT', $url, $header);
        } else {
            curl_setopt($this->process, CURLOPT_URL, $url);
            curl_setopt($this->process, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($this->process, CURLOPT_POSTFIELDS, implode('&', $body));
            $body = curl_exec($this->process);
            $header = curl_getinfo($this->process, CURLINFO_HTTP_CODE);
            $return = array($header,$body);
        }

        return $return;
    }

    public function getBankAccountIndex($parameter)
    {
        if (!is_array($parameter['account_numbers'])) {
            throw new \Exception('Not valid account numbers.');
        }

        $parameter = http_build_query($parameter);
        $parameter = preg_replace('/%5B[0-9]+%5D/simU', '%5B%5D', $parameter);

        $url = $this->url . 'v3/bank_verification_services?'.$parameter;

        if ($this->process instanceof \GuzzleHttp\Client) {
            $return = $this->guzzleProccessRequest('GET', $url, $this->header);
        } else {
            curl_setopt($this->process, CURLOPT_URL, $url);
            curl_setopt($this->process, CURLOPT_POST, 0);
            $body = curl_exec($this->process);
            $header = curl_getinfo($this->process, CURLINFO_HTTP_CODE);
            $return = array($header,$body);
        }

        return $return;
    }

    public function getBankAccount($id)
    {
        $url = $this->url . 'v3/bank_verification_services/'.$id;
        if ($this->process instanceof \GuzzleHttp\Client) {
            $return = $this->guzzleProccessRequest('GET', $url, $this->header);
        } else {
            curl_setopt($this->process, CURLOPT_URL, $url);
            curl_setopt($this->process, CURLOPT_POST, 0);
            $body = curl_exec($this->process);
            $header = curl_getinfo($this->process, CURLINFO_HTTP_CODE);
            $return = array($header,$body);
        }

        return $return;
    }

    public function createBankAccount($parameter)
    {
        $url = $this->url . 'v3/bank_verification_services';

        if ($this->process instanceof \GuzzleHttp\Client) {
            $header = $this->header;
            $header['form_params'] = $parameter;
            $return = $this->guzzleProccessRequest('POST', $url, $header);
        } else {
            curl_setopt($this->process, CURLOPT_URL, $url);
            curl_setopt($this->process, CURLOPT_POSTFIELDS, http_build_query($paraparameter));
            $body = curl_exec($this->process);
            $header = curl_getinfo($this->process, CURLINFO_HTTP_CODE);
            $return = array($header,$body);
        }
        return $return;
    }

    public function getFpxBanks()
    {
        $url = $this->url . 'v3/fpx_banks';
        if ($this->process instanceof \GuzzleHttp\Client) {
            $return = $this->guzzleProccessRequest('GET', $url, $this->header);
        } else {
            curl_setopt($this->process, CURLOPT_URL, $url);
            curl_setopt($this->process, CURLOPT_POST, 0);
            $body = curl_exec($this->process);
            $header = curl_getinfo($this->process, CURLINFO_HTTP_CODE);
            $return = array($header,$body);
        }

        return $return;
    }

    private function guzzleProccessRequest($requestType, $url, $header)
    {
        try {
            $response = $this->process->request($requestType, $url, $header);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
        } finally {
            $return = $response->getBody()->getContents();
        }
        return array($response->getStatusCode(),$return);
    }

    public function closeConnection()
    {
        if ($this->process instanceof \GuzzleHttp\Client) {
            // Do nothing
        } else {
            curl_close($this->process);
        }
    }

    public function toArray($json)
    {
        return array($json[0], \json_decode($json[1], true));
    }
}
