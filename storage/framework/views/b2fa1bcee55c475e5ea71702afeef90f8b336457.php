<?php $__env->startSection('content'); ?>

<script type="text/javascript">
    $(document).ready(function(){
        $("#frmid").submit();
    });
</script>

<style>
    section.buyonecls {
        margin-top: 120px;
        margin-bottom: 30px;
    }
</style>

<?php

$fname = Session::get('fname'); 
$lname = Session::get('lname');
$company = Session::get('company');
$address = Session::get('address');
$email = Session::get('email');
$phone = Session::get('phone');
$shipid = Session::get('shipid');
$pro_name = Session::get('pro_name');
$pro_price = Session::get('pro_price')  * 100 ;


?>

<main id="main">
    <section class="buyonecls">

        <?php             
                              
        $SECURE_SECRET = "4909A17C80CE5DC3720092C7D2D1A18A";    
        $appendAmp = 0;
        $vpcURL = "";
        $newHash = "";

        // if the form is submitted undergo the below procedures
        if (isset($_POST['accessCode']))
        {

            ksort($_POST);
            $md5HashData = $SECURE_SECRET;        
            foreach($_POST as $key => $value) 
            {
                // create the md5 input and URL leaving out any fields that have no value
                if (strlen($value) > 0 && ($key == 'accessCode' || $key == 'merchTxnRef' || $key == 'merchant' || $key == 'orderInfo' || $key == 'amount' || $key == 'returnURL')) {
                   // print 'Key: '.$key.'  Value: '.$value."<br>";
                    // this ensures the first paramter of the URL is preceded by the '?' char
                    if ($appendAmp == 0) 
                    {
                        $vpcURL .= urlencode($key) . '=' . urlencode($value);
                        $appendAmp = 1;
                    } else {
                        $vpcURL .= '&' . urlencode($key) . "=" . urlencode($value);
                    }
                    $md5HashData .= $value;         
                }
            }   
            //  echo '<prE>';print_r($md5HashData);exit;
            // $this->load->model('Orders_m');
            // $id= array( "id" => $_POST['orderInfo']);
            //            $newdata = array(
            //                  "merchantid" => $md5HashData,
            //                   );
            // $this->Orders_m->update_by($id,$newdata);
                //  echo $this->db->last_query();exit;

            $newHash .= $vpcURL."&vpc_SecureHash=" . strtoupper(md5($md5HashData));
            //  echo $newHash;exit;
            echo "<script language=\"javascript\">top.location.href='https://onlinepayment.areeba.com/TPGWeb/payment/prepayment.action?$newHash'</script>";
            //exit;
        }

        ?>

        <!-- The "Pay Now!" button submits the form, transferring control to the page detailed below -->
        <div class="arrebapaymentpaypage">
            <div class="container"> 
                <form action="" method="post" id="frmid">
                    <div class="paymentdiv">
                        <table border="0" cellpadding='0' cellspacing='0' align="center">   
                            <tr>           
                              <td><input type="hidden" name="accessCode" value="B6C9518A" size="20" maxlength="8"/></td>     
                            </tr>

                            <tr class="shade">        
                                <td><input type="hidden" name="merchTxnRef" value="<?php echo time();?>" size="20" maxlength="40"/></td>
                            </tr>

                            <tr>      
                                <td><input type="hidden" name="merchant" value="TEST222202048001"  size="20" maxlength="16"/></td>
                            </tr>

                            <tr class="shade">  
                                <td><input type="hidden" name="orderInfo" value="<?php echo $shipid;?>" size="20" maxlength="34"/></td>
                            </tr>

                            <tr>
                              <td><input type="hidden"  name="amount" value="<?php echo $pro_price; ?>" maxlength="10"/></td>     
                            </tr>                        

                            <tr class="shade">      
                                <td><input type="hidden"  name="returnURL" size="65" value="<?php echo e(url('/paymentsuccess?action=py')); ?>" maxlength="250"/></td>
                            </tr>

                           <!--  <tr class="newshade">
                                <td >Client name:</td>
                                <td><?php echo $fname.' '.$lname?></td>        
                            </tr>  

                             <tr class="newshade">
                                <td>Order id: </td>
                                <td><?php echo $shipid; ?></td>       
                            </tr>

                             <tr class="newshade">
                              <td>Pay amount: </td>
                                <td>$ <?php echo $pro_price; ?></td>                        
                            </tr> 

                            <tr class="newshade">
                                <td >Date: </td>
                                <td><?php echo  date("d/m/Y h:i:s") ?></td>       
                            </tr>   -->

                            <tr class="newshade">
                                <td colspan="2" ><input type="submit" NAME="SubButL" value="Pay Now!"></td>
                            </tr>                
                        </table>
                    </div>
                </form>
            </div>
        </div>

<?php

//check if this page is being redirected from payment client thus carrying the field vpc_TxnResponseCode
if (isset($_GET['vpc_TxnResponseCode']))
{
    //function to map each response code number to a text message   
    function getResponseDescription($responseCode) 
    {
        switch ($responseCode) {
            case "0" : $result = "Transaction Successful"; break;
            case "?" : $result = "Transaction status is unknown"; break;
            case "1" : $result = "Unknown Error"; break;
            case "2" : $result = "Bank Declined Transaction"; break;
            case "3" : $result = "No Reply from Bank"; break;
            case "4" : $result = "Expired Card"; break;
            case "5" : $result = "Insufficient funds"; break;
            case "6" : $result = "Error Communicating with Bank"; break;
            case "7" : $result = "Payment Server System Error"; break;
            case "8" : $result = "Transaction Type Not Supported"; break;
            case "9" : $result = "Bank declined transaction (Do not contact Bank)"; break;
            case "A" : $result = "Transaction Aborted"; break;
            case "C" : $result = "Transaction Cancelled"; break;
            case "D" : $result = "Deferred transaction has been received and is awaiting processing"; break;
            case "E" : $result = "Invalid Credit Card"; break;
            case "F" : $result = "3D Secure Authentication failed"; break;
            case "I" : $result = "Card Security Code verification failed"; break;
            case "G" : $result = "Invalid Merchant"; break;
            case "L" : $result = "Shopping Transaction Locked (Please try the transaction again later)"; break;
            case "N" : $result = "Cardholder is not enrolled in Authentication scheme"; break;
            case "P" : $result = "Transaction has been received by the Payment Adaptor and is being processed"; break;
            case "R" : $result = "Transaction was not processed - Reached limit of retry attempts allowed"; break;
            case "S" : $result = "Duplicate SessionID (OrderInfo)"; break;
            case "T" : $result = "Address Verification Failed"; break;
            case "U" : $result = "Card Security Code Failed"; break;
            case "V" : $result = "Address Verification and Card Security Code Failed"; break;
            case "X" : $result = "Credit Card Blocked"; break;
            case "Y" : $result = "Invalid URL"; break;                
            case "B" : $result = "Transaction was not completed"; break;                
            case "M" : $result = "Please enter all required fields"; break;                
            case "J" : $result = "Transaction already in use"; break;
            case "BL" : $result = "Card Bin Limit Reached"; break;                
            case "CL" : $result = "Card Limit Reached"; break;                
            case "LM" : $result = "Merchant Amount Limit Reached"; break;                
            case "Q" : $result = "IP Blocked"; break;                
            case "R" : $result = "Transaction was not processed - Reached limit of retry attempts allowed"; break;                
            case "Z" : $result = "Bin Blocked"; break;

            default  : $result = "Unable to be determined"; 
        }
        return $result;
    }
    
    //function to display a No Value Returned message if value of field is empty
    function null2unknown($data) 
    {
        if ($data == "") 
            return "No Value Returned";
         else 
            return $data;
    }       
    //get secure hash value of merchant 
    //get the secure hash sent from payment client
    $vpc_Txn_Secure_Hash = addslashes($_GET["vpc_SecureHash"]);
    unset($_GET["vpc_SecureHash"]); 
    ksort($_GET);
    // set a flag to indicate if hash has been validated
    $errorExists = false;
    //check if the value of response code is valid
    if (strlen($SECURE_SECRET) > 0 && addslashes($_GET["vpc_TxnResponseCode"]) != "7" && addslashes($_GET["vpc_TxnResponseCode"]) != "No Value Returned") 
    {
        //creat an md5 variable to be compared with the passed transaction secure hash to check if url has been tampered with or not
        $md5HashData = $SECURE_SECRET;

        //creat an md5 variable to be compared with the passed transaction secure hash to check if url has been tampered with or not
        $md5HashData_2 = $SECURE_SECRET;

        // sort all the incoming vpc response fields and leave out any with no value
        foreach($_GET as $key => $value) 
        {
            if ($key != "vpc_SecureHash" && strlen($value) > 0 && $key != 'action' ) 
            {
                
                $md5HashData_2 .= str_replace(" ",'+',$value);
                $md5HashData .= $value;
                
            }
        }

        //if transaction secure hash is the same as the md5 variable created 
        if ((strtoupper($vpc_Txn_Secure_Hash) == strtoupper(md5($md5HashData)) || strtoupper($vpc_Txn_Secure_Hash) == strtoupper(md5($md5HashData_2))))
        {
            $hashValidated = "<b>CORRECT</b>";
        } 
        else 
        {
            $hashValidated = "<b>INVALID HASH</b>";
            $errorExists = true;
        }
    } 
    else 
    {
        $hashValidated = "<FONT color='orange'><b>Not Calculated - No 'SECURE_SECRET' present.</b></FONT>";
    }
    //the the fields passed from the url to be displayed
    $amount          = null2unknown(addslashes($_GET["amount"])/100);
    $locale          = null2unknown(addslashes($_GET["vpc_Locale"]));
    $batchNo         = null2unknown(addslashes($_GET["vpc_BatchNo"]));
    $command         = null2unknown(addslashes($_GET["vpc_Command"]));
    $message         = null2unknown(addslashes($_GET["vpc_Message"]));
    $version         = null2unknown(addslashes($_GET["vpc_Version"]));
    $cardType        = null2unknown(addslashes($_GET["vpc_Card"]));
    $orderInfo       = null2unknown(addslashes($_GET["orderInfo"]));
    $receiptNo       = null2unknown(addslashes($_GET["vpc_ReceiptNo"]));
    $merchantID      = null2unknown(addslashes($_GET["merchant"]));
    $authorizeID     = null2unknown(addslashes($_GET["vpc_AuthorizeId"]));
    $merchTxnRef     = null2unknown(addslashes($_GET["merchTxnRef"]));
    $transactionNo   = null2unknown(addslashes($_GET["vpc_TransactionNo"]));
    $acqResponseCode = null2unknown(addslashes($_GET["vpc_AcqResponseCode"]));
    $txnResponseCode = null2unknown(addslashes($_GET["vpc_TxnResponseCode"]));
    
    // Show 'Error' in title if an error condition
    $errorTxt = "";
    
    // Show this page as an error page if vpc_TxnResponseCode equals '7'
    if ($txnResponseCode == "7" || $txnResponseCode == "No Value Returned" || $errorExists) {
        $errorTxt = "Error ";
    }
    // This is the display title for 'Receipt' page 
    ?>
            <!-- end branding table -->
            <!-- End Branding Table -->
            <table width="85%" align="center" cellpadding="5" border="0">
                <tr>
                    <td align="right"><b>Hash Validity:</b></td>
                    <td class="errorMsg"><?php echo $hashValidated?></td>
                </tr>
            
                <tr>
                    <td align="right"><b>Merchant Transaction Reference: </b></td>
                    <td><?php echo $merchTxnRef?></td>
                </tr>
                <tr>
                    <td align="right"><b>Merchant ID: </b></td>
                    <td><?php echo $merchantID?></td>
                </tr>
                <tr>
                    <td align="right"><b>Order Information: </b></td>
                    <td><?php echo $orderInfo?></td>
                </tr>
                <tr>
                    <td align="right"><b>Purchase Amount: </b></td>
                    <td><?php echo $amount?></td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                    <hr />
                    </td>
                </tr>
                
                <tr>
                    <td colspan="2" align="center">
                        Fields above are the request values returned.<br>
                        Fields below are the response fields for a Standard Transaction.<br>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                    <hr />
                    </td>
                </tr>            
                <tr>
                    <td align="right"><b>VPC Transaction Response Code: </b></td>
                    <td><?php echo $txnResponseCode?></td>
                </tr>
                <tr>
                    <td align="right"><b>Transaction Response Code Description:</b></td>
                    <td class="errorMsg"><?php echo getResponseDescription($txnResponseCode)?></td>
                </tr>
                <tr>
                    <td align="right"><b>Message: </b></td>
                    <td><?php echo $message?></td>
                </tr>
                <?php
                    // only display the following fields if not an error condition
                    if ($txnResponseCode != "7" && $txnResponseCode != "No Value Returned") 
                    { 
                ?>
                <tr>
                    <td align="right"><b>Receipt Number: </b></td>
                    <td><?php echo $receiptNo?></td>
                </tr>
                <tr>
                    <td align="right"><b>Transaction Number: </b></td>
                    <td><?php echo $transactionNo?></td>
                </tr>
                <tr>
                    <td align="right"><b>Acquirer Response Code: </b></td>
                    <td><?php echo $acqResponseCode?></td>
                </tr>
                <tr>
                    <td align="right"><b>Bank Authorization ID: </b></td>
                    <td><?php echo $authorizeID?></td>
                </tr>
                <tr>
                    <td align="right"><b>Batch Number: </b></td>
                    <td><?php echo $batchNo?></td>
                </tr>
                <tr>
                    <td align="right"><b>Card Type: </b></td>
                    <td><?php echo $cardType?></td>
                </tr>   
                <tr>
                    <td colspan="2"><HR /></td>
                </tr>
                    <?php 
                    } 
                    ?>    
            </table>
            <?php
            }
            ?>
    </section>  
 




<?php $__env->stopSection(); ?> 


<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>