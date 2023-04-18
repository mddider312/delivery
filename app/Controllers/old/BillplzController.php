<?php

namespace App\Controllers;
use App\Models\TopupModel;
//connect api
require_once APPPATH.'/lib/API.php';
require_once APPPATH.'/lib/Connect.php'; 
//require_once APPPATH .'/lib/Configuration.php';

use Billplz\Minisite\API;
use Billplz\Minisite\Connect;

class BillplzController extends BaseController{
    
    public function __construct(){
        $this->db = \Config\Database::connect();
    }
    
    public function index(){
        $uid = session('user_id');
        
        helper(['url','form','utility']);
        
        // For Testing Use
        $this->api_key = '6c4b86d5-1d59-47ed-bd11-d6327ce2d49d';
        $this->collection_id = 'ggovpepb';
        $this->x_signature = 'S-9kk1EEfmwCQLLme8otR7vQ';
        
        // For Live Use
        /*
        $this->api_key = 'd77ab6d4-2468-4bae-a65e-13b58b1ab1ea';
        $this->collection_id = 'tkpjakyu';
        $this->x_signature = 'S-gz8kc5hafMmact_cS3mRBw';
        */
        
        $this->websiteurl = "<?= base_url() ?>/BillplzController/redirect";
        $this->successpath = "<?= base_url() ?>/BillplzController/redirect";
        $this->fallbackurl = ''; 
        $this->reference_1_label = '';
        $this->reference_2_label = '';
        
        $topupModel = new TopupModel();
        
        $uid = session('user_id');
        
        $db = db_connect();
        $query = $db->query("SELECT * FROM users Where id=$uid LIMIT 1");
        $data = [
			'result' => $query->getRow(),
		];
		$user_name=$data['result']->user_name;
		$user_contact=$data['result']->user_contact ?? "0123456789";
		$credit=$data['result']->credit;
		$amount=$this->request->getpost('amount'); 
		$session = session();
        $session->set([
            'topup_amount'=> $amount
        ]);
		$amount2 = $amount * 100;
		$datetime = date("Y-m-d h:i:s");
		//$_SESSION['topup_amount'] = $amount;
        //////////////////////////////////////////////////////////////////////////////////////////////////
        
        $parameter = array(
            'collection_id' => $this->collection_id,
            'email' => 'noreply@billplz.com',
            'mobile' => $user_contact,
            'name' => $user_name,
            'amount' => $amount2,
            'callback_url'=> "Admin/dashboard",
            'description' => 'Top Up',
        );

        $optional = array(
            'redirect_url' => $this->websiteurl,
            // 'reference_1_label' => isset($reference_1_label) ? $reference_1_label : $_REQUEST['reference_1_label'],
            'reference_1' => $this->request->getPost('reference'),
            // 'reference_1_label' => $this->request->getPost('point'),
            // 'reference_2_label' => $this->request->getPost('default_address'),
            // 'reference_2_label' => isset($reference_2_label) ? $reference_2_label : $_REQUEST['reference_2_label'],
            'reference_2' => $this->request->getPost('default_address'),
            // 'reference_2' => isset($_REQUEST['email']) ? $_REQUEST['email'] : '',
            'deliver' => 'false'
        );

        if (empty($parameter['mobile']) && empty($parameter['email'])) {
            $parameter['email'] = 'noreply@billplz.com';
        }
    
        if (!filter_var($parameter['email'], FILTER_VALIDATE_EMAIL)) {
            $parameter['email'] = 'noreply@billplz.com';
        }

        $connnect = (new Connect($this->api_key))->detectMode();
        $billplz = new API($connnect);
        list($rheader, $rbody) = $billplz->toArray($billplz->createBill($parameter, $optional));
    
        //Handling errors
        if(isset($rbody['error'])){
            echo 'Error type: ' . $rbody['error']['type'];
            print_r($rbody['error']['message']);
            // die();
        }

        /***********************************************/
        // Include tracking code here
        /***********************************************/
        if ($rheader !== 200) {
            if (defined('DEBUG')) {
                echo '<pre>' . print_r($rbody, true) . '</pre>';
            }
            if (!empty($this->fallbackurl)) {
                return redirect()->to($this->fallbackurl);
            }
        } else if ($rheader == 200) {
            $query = $db->query("INSERT INTO topup (user_id, user_name, amount, status, created_at) VALUES ('$uid', '$user_name', '$amount', 'Failed', '$datetime')");
        }
        return redirect()->to($rbody['url']);
    }

    public function redirect(){
        $uid = session('user_id');
        $topup_amount = session('topup_amount');
        $datetime = date("Y-m-d h:i:s");
        $db = db_connect();

        if (strpos($_SERVER['REQUEST_URI'] ,'=true') !== false) {
            $query = $db->query("UPDATE topup SET status = 'Success' WHERE user_id = '$uid' ORDER BY topup_id DESC");
            $query2 = $db->query("UPDATE users SET credit = credit + $topup_amount WHERE id = '$uid'");
            $query3 = $db->query("INSERT transaction_history (user_id, amount, description, datetime) VALUES ('$uid', '$topup_amount', 'topup', '$datetime')");
            return redirect()->to('Admin/dashboard?topup_completion');
        } else {
            return redirect()->to('Admin/topup?topup_failed');
        }
    }

    public function callback(){
        return redirect()->to('Admin/topup?topup_failed');
    }
}
?>