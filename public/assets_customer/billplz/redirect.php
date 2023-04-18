<?php
session_start();

require 'lib/API.php';
require 'lib/Connect.php';
require 'configuration.php';

include ('../dbconnect.php');

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

use Billplz\Minisite\API;
use Billplz\Minisite\Connect;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

$data = Connect::getXSignature($x_signature);
$connnect = (new Connect($api_key))->detectMode();
$billplz = new API($connnect);
list($rheader, $rbody) = $billplz->toArray($billplz->getBill($data['id']));

$customer = $_SESSION['username'];              // customer username

if ($rbody['paid']) {
    /***********************************************/
    // Include tracking code here (if any)
    /***********************************************/
    if (isset($_SESSION['username'])) {
        $date_paid = $data['paid_at'];                  // payment datetime
        $date_ordered = explode(" ", $date_paid)[0];    // order date
        $bill_id = $date_ordered."_".$data['id'];       // payment bill id
        
        $cust_detail = $conn->query("SELECT * FROM customer WHERE username = '$customer'") -> fetch_assoc();
        $cart_item = $conn->query("SELECT * FROM cart WHERE customer = '$customer'");  // pending change to temp cart
        $total_amount = 0.00;
        
        $message = "<html><body><table style='border:1px;'>";
        $message .= "<tr><td><b>Bill id</b></td><th>:</th><td>$bill_id</td></tr>";
        $message .= "<tr><td><b>Type</b></td><th>:</th><td>$cust_detail[type]</td></tr>";
        $message .= "<tr><td><b>Status</b></td><th>:</th><td>PAID</td></tr>";
        $message .= "<tr><td><b>Customer</b></td><th>:</th><td>$cust_detail[username]</td></tr>";
        $message .= "<tr><td><b>Contact</b></td><th>:</th><td>$cust_detail[contactNo]</td></tr>";
        if ($cust_detail['type'] == 'Self-pickup') {
            $message .= "<tr><td><b>Address</b></td><th>:</th><td>-</td></tr>";
        } else {
            $message .= "<tr><td><b>Address</b></td><th>:</th><td>$cust_detail[address]</td></tr>";
        }
        $message .= "</table><br><p><b>Order Details:</b></p><table style='border:1px solid black; padding:10px; border-collapse:collapse; text-align:center;'>";
        $message .= "<tr><th style='border:1px solid black; padding:10px; border-collapse:collapse; text-align:center; background-color:#feebdd;'>No.</th><th style='border:1px solid black; padding:10px; border-collapse:collapse; text-align:center; background-color:#feebdd;'>Product Name</th><th style='border:1px solid black; padding:10px; border-collapse:collapse; text-align:center; background-color:#feebdd;'>Variation</th><th style='border:1px solid black; padding:10px; border-collapse:collapse; text-align:center; background-color:#feebdd;'>Price (RM)</th><th style='border:1px solid black; padding:10px; border-collapse:collapse; text-align:center; background-color:#feebdd;'>Quantity</th><th style='border:1px solid black; padding:10px; border-collapse:collapse; text-align:center; background-color:#feebdd;'>Subtotal (RM)</th></tr>";

        $count = 0;
        while ($cart = $cart_item -> fetch_assoc()) {
            $count++;
            $food = $conn->query("SELECT * FROM product WHERE Id = $cart[ID]") -> fetch_assoc();
            $variation = $conn->query("SELECT * FROM variation WHERE variationId = $cart[variationId]") -> fetch_assoc();

            $sub_total = number_format((float)$variation['variationPrice'] * (int)$cart['quantity'], 2, '.', '');
            $t += (float)$sub_total;
            $total_amount = number_format((float)$t - $cust_detail['discount'], 2, '.', '');
            
            $message .= "<tr><td style='border:1px solid black; padding:10px; border-collapse:collapse; text-align:center;'>$count</td><td style='border:1px solid black; padding:10px; border-collapse:collapse;'>$food[name]</td><td style='border:1px solid black; padding:10px; border-collapse:collapse; text-align:center;'>$variation[variationName]</td><td style='border:1px solid black; padding:10px; border-collapse:collapse; text-align:center;'>$variation[variationPrice]</td><td style='border:1px solid black; padding:10px; border-collapse:collapse; text-align:center;'>$cart[quantity]</td><td style='border:1px solid black; padding:10px; border-collapse:collapse; text-align:center;'>$sub_total</td></tr>";

           $conn->query("INSERT INTO `order` (orderId, customer, date, item, variation, quantity, sub_total, status, address, contact, type, discount) VALUES ('$bill_id', '$cust_detail[email]', '$date_ordered', '$food[name]', '$variation[variationName]', '$cart[quantity]', '$sub_total', 'Processing', '$cust_detail[address]', '$cust_detail[contactNo]', '$cust_detail[type]', '$cust_detail[discount]')");
        }
        
        $sql = "SELECT * FROM payment WHERE bill_id = '$bill_id'";
        
        if ($conn -> query($sql) -> num_rows == 0) {
            $delivery = $conn -> query("SELECT * FROM deliveryfee") -> fetch_assoc();
            
            if ($total_amount < $delivery['min_purchase']) {
                if ($cust_detail['type'] == "Delivery") {
                    $address = $conn -> query("SELECT address FROM customer WHERE username = '$_SESSION[username]'") -> fetch_assoc()['address'];
                            
                    $alor_setar_postcode = array('05000', '05050', '05100', '05150', '05200', '05250', '05300', '05350', '05400', '05460', '05500', '05502', '05503', '05504', '05505', '05506', '05508', '05512', '05514', '05516', '05517', '05518', '05520', '05532', '05534', '05536', '05538', '05550', '05551', '05552', '05556', '05558', '05560', '05564', '05576', '05578', '05580', '05582', '05586', '05590', '05592', '05594', '05600', '05604', '05610', '05612', '05614', '05620', '05621', '05622', '05626', '05628', '05630', '05632', '05644', '05660', '05661', '05664', '05670', '05672', '05673', '05674', '05675', '05676', '05680', '05690', '05696', '05700', '05710', '05720', '05990', '06250', '06550', '06570', '06660');
                    
                    $fee = $delivery['deliveryfee'];
                                        
                    if ($address != "") {
                        if (strpos(strtolower($address), 'alor setar') || strpos(strtolower($address), 'alorsetar')) {
                            $fee = $delivery['deliveryfee_alor'];
                        }
                        
                        foreach ($alor_setar_postcode as $postcode) {
                            if (strpos($address, $postcode)) {
                                $fee = $delivery['deliveryfee_alor'];
                                break;
                            }
                        }
                    }
                    
                    $total_amount = number_format((float)$total_amount + $fee, 2, '.', '');
                    $message .= "<tr><td style='border:1px solid black; padding:10px; border-collapse:collapse; text-align:center;'></td><td style='border:1px solid black; padding:10px; border-collapse:collapse; text-align:center;'></td><td style='border:1px solid black; padding:10px; border-collapse:collapse; text-align:center;'></td><td style='border:1px solid black; padding:10px; border-collapse:collapse; text-align:center;'></td><td style='border:1px solid black; padding:10px; border-collapse:collapse; text-align:center;'><b>Delivery:</b></td><td style='border:1px solid black; padding:10px; border-collapse:collapse; text-align:center;'>$fee</td></tr>";
                } else {
                    $message .= "<tr><td style='border:1px solid black; padding:10px; border-collapse:collapse; text-align:center;'></td><td style='border:1px solid black; padding:10px; border-collapse:collapse; text-align:center;'></td><td style='border:1px solid black; padding:10px; border-collapse:collapse; text-align:center;'></td><td style='border:1px solid black; padding:10px; border-collapse:collapse; text-align:center;'></td><td style='border:1px solid black; padding:10px; border-collapse:collapse; text-align:center;'><b>Delivery:</b></td><td style='border:1px solid black; padding:10px; border-collapse:collapse; text-align:center;'>Free</td></tr>";
                }
            } else {
                $message .= "<tr><td style='border:1px solid black; padding:10px; border-collapse:collapse; text-align:center;'></td><td style='border:1px solid black; padding:10px; border-collapse:collapse; text-align:center;'></td><td style='border:1px solid black; padding:10px; border-collapse:collapse; text-align:center;'></td><td style='border:1px solid black; padding:10px; border-collapse:collapse; text-align:center;'></td><td style='border:1px solid black; padding:10px; border-collapse:collapse; text-align:center;'><b>Delivery:</b></td><td style='border:1px solid black; padding:10px; border-collapse:collapse; text-align:center;'>Free</td></tr>";
            }
            
            $total_amount = number_format((float)$total_amount, 2, '.', '');
            
            $message .= "<tr><td style='border:1px solid black; padding:10px; border-collapse:collapse; text-align:center;'></td><td style='border:1px solid black; padding:10px; border-collapse:collapse; text-align:center;'></td><td style='border:1px solid black; padding:10px; border-collapse:collapse; text-align:center;'></td><td style='border:1px solid black; padding:10px; border-collapse:collapse; text-align:center;'></td><td style='border:1px solid black; padding:10px; border-collapse:collapse; text-align:center;'><b>Grand Total:</b></td><td style='border:1px solid black; padding:10px; border-collapse:collapse; text-align:center;'>$total_amount</td></tr>";
            $message .= "</table></body></html>";
            
            $conn->query("INSERT INTO payment (bill_id, email, amount, date_ordered) VALUES ('$bill_id', '$cust_detail[email]', '$total_amount', '$date_paid')");
            $conn->query("DELETE FROM cart WHERE customer = '$customer'");
            
            if ($cust_detail['type'] == "Delivery") {
                send_mail("yct639@outlook.com", "Garden Order #$bill_id", $message, $bill_id);  ////////////////////////////////////
            } else {
                send_mail("yct639@outlook.com", "Garden Order #$bill_id", $message, $bill_id." ($cust_detail[type])");  ////////////////////////////////////
            }
        }
    }
    
    if (!empty($successpath)) {
        header('Location: ' . $successpath."&s");
    } else {
        header('Location: ' . $rbody['url']."?f");
    }
} else {
    $cart_item = $conn->query("SELECT * FROM cart WHERE customer = '$customer'");
    
    while ($cart = $cart_item -> fetch_assoc()) {
        $conn->query("UPDATE variation SET variationQuantity = variationQuantity + $cart[quantity] WHERE variationId = '$cart[variationId]'");
    }
    
    header('Location: ' . $rbody['url']."?f");
}

function send_mail($to, $subject, $message, $bill_id) {
	$mail = new PHPMailer(true);
	
	try {
	    //Server settings
	    $mail->SMTPDebug = 0;                                       // Enable verbose debug output
	    $mail->isSMTP();                                            // Set mailer to use SMTP
	    $mail->Host       = 'smtp.gmail.com;';  // Specify main and backup SMTP servers           ////////////////////////////////////////////////////////////////
	    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication   
	    $mail->Username   = 'cyuan639@gmail.com';                     // SMTP username          ////////////////////////////////////////////////////////////////
	    $mail->Password   = 'yuanc99123';                       // SMTP password         ////////////////////////////////////////////////////////////////
	    $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
	    $mail->Port       = 587;                                    // TCP port to connect to
        
	    $mail->setFrom('cyuan639@gmail.com', 'Garden Order #'.$bill_id);                         ///////////////////////////////////////////////////////////////
	    
	    //Recipients
	    $mail->addAddress($to);

	    // Content
	    $mail->isHTML(true);                                  // Set email format to HTML
	    $mail->CharSet="UTF-8";
	    $mail->Subject = $subject;
	    $mail->Body    = $message;

        $mail->send();
	} catch (Exception $e) {
	    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	}
}