<?php
  require_once('./sample-config.php');

  $token  = $_POST['stripeToken'];
  $email  = $_POST['stripeEmail'];

  try {  
        $customer = \Stripe\Customer::create(array(
            'email' => $email,
            'source'  => $token,
            'name' => 'Yogesh',
            'address' => [
            'line1' => 'test line no',
            'postal_code' => '0000',
            'city' => 'your_city',
            'state' => 'MH',
            'country' => 'IN',],
            'shipping' => [
              'name' => 'Yogesh shipping address',
              'address' => [
              'line1' => 'line 1',
              'postal_code' => '0000',
              'city' => 'your_city',
              'state' => 'state',
              'country' => 'your_country_code',
          ],
        ],
        ));
    }catch(Exception $e) {  
        $api_error = $e->getMessage();  
    } 

  try {  
      $charge = \Stripe\Charge::create(array(
      'customer' => $customer->id,
      'amount'   => 5000,
      'currency' => 'usd',
      'description' => 'Example charge'
  ));
        }catch(Exception $e) {  
            $api_error = $e->getMessage();  
        } 

 if(empty($api_error) && $charge){ 

        // Retrieve charge details 
            $chargeJson = $charge->jsonSerialize(); 

            // Check whether the charge is successful 
            if($chargeJson['amount_refunded'] == 0 && empty($chargeJson['failure_code']) && $chargeJson['paid'] == 1 && $chargeJson['captured'] == 1){ 
                // Transaction details  
                $transactionID = $chargeJson['balance_transaction']; 
                $paidAmount = $chargeJson['amount']; 
                $paidAmount = ($paidAmount/100); 
                $paidCurrency = $chargeJson['currency']; 
                $payment_status = $chargeJson['status']; 

                 // If the order is successful 
                if($payment_status == 'succeeded'){ 
                    $ordStatus = 'success'; 
                    $statusMsg = 'Your Payment has been Successful!'; 
                }else{ 
                    $statusMsg = "Your Payment has Failed!"; 
                } 
            }else{ 
                $statusMsg = "Transaction has been failed!"; 
            } 
        }
  

  echo '<h1>Successfully charged ' . $paidAmount . '!</h1>';
?>

<div class="container">
    <div class="status">
        <?php if(!empty($payment_id)){ ?>
            <h1 class="<?php echo $ordStatus; ?>"><?php echo $statusMsg; ?></h1>
      
            <h4>Payment Information</h4>
            <p><b>Reference Number:</b> <?php echo $payment_id; ?></p>
            <p><b>Transaction ID:</b> <?php echo $transactionID; ?></p>
            <p><b>Paid Amount:</b> <?php echo $paidAmount.' '.$paidCurrency; ?></p>
            <p><b>Payment Status:</b> <?php echo $payment_status; ?></p>
      
            
        <?php }else{ ?>
            <h1 class="error">Your Payment has Failed</h1>
        <?php } ?>
    </div>
    <a href="index.php" class="btn-link">Back to Payment Page</a>
</div>
