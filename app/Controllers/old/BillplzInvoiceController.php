<?php

namespace App\Controllers;

use App\Models\ParentModel;
use App\Models\InvoicePaymentModel;
//connect api
require_once APPPATH.'/lib/API.php';
require_once APPPATH.'/lib/Connect.php'; 
//require_once APPPATH .'/lib/Configuration.php';


use Billplz\Minisite\API;
use Billplz\Minisite\Connect;

class BillplzInvoiceController extends BaseController{

    public function __construct(){
        helper(['url','form','utility']);
        $this->api_key = 'b126ad5d-35a7-4ee8-b41a-25f70cc23953';
        $this->collection_id = 'ui8l3ig7';
        $this->x_signature = 'S-P_yaogmYlpR1Zh_eGNE4Pw';
        $this->websiteurl = "http://edu.ztoo.cf/billplz_manage/invoice";
        $this->successpath = "http://edu.ztoo.cf/parent_notification/invoice_issued";
        $this->fallbackurl = ''; 
        $this->reference_1_label = '';
        $this->reference_2_label = '';
    }

    public function bill(){

        //dd(1234);


       $parameter = array(
        'collection_id' => $this->collection_id,
        'email' => 'noreply@billplz.com',
        'mobile' => $this->request->getPost('default_phone'), //null
        'name' => $this->request->getPost('parent_name'),
        'amount' => $this->request->getPost('amount_paid'),
        'callback_url'=> "http://edu.localhost/billplz-invoice/callback",
        'invoice_id' => $this->request->getPost('invoice_id'),
        'description' => $this->request->getPost('invoice_name'),
    );

     //dd($parameter);

       $optional = array(
        'redirect_url' => $this->websiteurl,
    //         'reference_1_label' => isset($reference_1_label) ? $reference_1_label : $_REQUEST['reference_1_label'],
        'reference_1' => $this->request->getPost('invoice_id'),       
    //         'reference_2_label' => isset($reference_2_label) ? $reference_2_label : $_REQUEST['reference_2_label'],
        'reference_2' => $this->request->getPost('parent_id'),
    //         'reference_2' => isset($_REQUEST['email']) ? $_REQUEST['email'] : '',
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
    }
    return redirect()->to($rbody['url']);

}


public function redirect(){
        $parentModel = new ParentModel();
		$loggedParentID = session() ->get('loggedParent');
		$parentInfo = $parentModel -> find($loggedParentID);
	
    $data = Connect::getXSignature($this->x_signature); 
    $connnect = (new Connect($this->api_key))->detectMode();
    $billplz = new API($connnect);
    list($rheader, $rbody) = $billplz->toArray($billplz->getBill($data['id']));
    
    $invoicePaymentModel = new \App\Models\InvoicePaymentModel();
    
    if ($rbody['paid']) {

        if (!empty($this->successpath)) {

            date_default_timezone_set('Asia/Kuala_Lumpur');

            $invoice_id = $rbody['reference_1'];
            $parent_id = $parentInfo['parent_id'];
            
            $billplz_id = $data['id'];
            $amount_temp = $rbody['amount'];
            
            $date = date("Y-m-d h:i:sa");
            $payment =  $amount_temp / 100.00;

            $data = [

             'parent_id'=> $parent_id,
             'invoice_id'=> $invoice_id,
             'payment_date'=> date("Y-m-d h:i:sa"),
             'status' => 'Processing',
             'billplz_id' => $billplz_id,
              'amount' => $payment,
         ];


         $status = 'Paid';
          
         $db = \Config\Database::connect(); 
         $query  = $db->query("UPDATE invoice SET status='$status' where invoice_id = '$invoice_id' ");
          
         if($query){
      
          $invoicePaymentModel->save($data);
         // return redirect()->to($this->successpath)->with('status','Make Payment Successfully!');
            $query   = $db->query("SELECT * FROM invoice where parent_id = '$parent_id' ");
	     	$results = $query->getResultArray();

		$data = [
			'parentInfo' => $parentInfo,
			'invoice' => $results

		];

		return view('Parent/parent_invoice_list',$data);


      }


  } else {
    /*Do something here if payment has not been made*/

}



} else {

    return redirect()->to($rbody['url']);
}
}

public function callback(){

        // dd('Billplz no pass here');

}

}

?>