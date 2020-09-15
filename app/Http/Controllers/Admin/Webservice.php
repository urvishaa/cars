<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(0);
/*ob_start();
include 'twillio/vendor/autoload.php';*/
// Use the REST API Client to make requests to the Twilio REST API
//use Twilio\Rest\Client;
// Your Account SID and Auth Token from twilio.com/console

class Webservice extends CI_Controller 
{
    function __construct()
    {
        
        // Construct the parent class
        parent::__construct();
        $this->load->model('Activity_m');
		$this->load->model('Customers_m');
		$this->load->model('Devicetoken_m');
		$this->load->model('Categories_m');
		$this->load->model('Products_m');
		$this->load->model('Categories_products_m');
		$this->load->model('OTP_m');
		$this->load->model('Setting_m');
		$this->load->model('Wishlist_m');
		$this->load->model('Cart_m');
		$this->load->model('Order_option_m');
		$this->load->model('Options_m');
		$this->load->model('Language_m');
		$this->load->model('Address_m');
		$this->load->model('Customer_address_m');
		$this->load->model('Country_m');
		$this->load->model('State_m');
		$this->load->model('Order_m');
		$this->load->model('Currency_m');
		$this->load->model('Order_history_m');
		$this->load->model('Order_product_m');
		$this->load->model('Order_total_m');
		$this->load->model('Order_status_m');
		$this->load->model('Couponcode_m');
		$this->load->model('Stripe_order_m');
		$this->load->model('Coupon_history_m');
		$this->load->model('Taxrate_m');
		$_SERVER['HTTP_HOST']=$_SERVER['HTTP_HOST'].'';
    }



    public function socialLogin()
    {	
    	$input = file_get_contents('php://input');
		$post = json_decode($input, true);

		//$posts = $this->input->post();
		//echo '<pre>';print_r($post);exit;

		//Local
		/*{"device": "1","deviceToken": "","phone": "8401549108","password": "123","sessionId" : ""}*/

		//Live
		/*{"device": "2","deviceToken": "c6Z0aktOeOU:APA91bGG89cMWdthEbyw8Bw-0mNF8384dox4pKbZd96gSoYONviRJOhIVjL4-47Qz6AesDvPFNSxBQljm3RqQsL3TMJuqBfflSTEgxy2HOm8SO5bQ0dgZi7RnFXjwc6qmu2oJUKlBwAX","phone": "","password": "","sessionId": "","isSocial": "1","isFacebook": "0","sociald": "107101870440985247324","socialImage": "https://lh3.googleusercontent.com/-eU3CctI1HEY/AAAAAAAAAAI/AAAAAAAAAN4/fMK-f_pWPYo/s96-c/photo.jpg","firstName": "Paras","lastName": "Andani","email": "paraspatel507@gmail.com"}*/


		try
		{
			if((!isset($post['device'])) || (!isset($post['deviceToken'])) || (!isset($post['password'])) || (!isset($post['sessionId'])) || (!isset($post['isSocial'])) || (!isset($post['isFacebook'])) || (!isset($post['socialId'])) || (!isset($post['email'])) || (!isset($post['languageCode'])))
			{
				throw new Exception("Please fill in all the required fields.");
			}

			if($post['languageCode'] == 'en'){
				$language = $this->Language_m->get_by(array('name'=>'English'));
				$this->lang->load('Webservice', 'english');
			}
			elseif($post['languageCode'] == 'ar'){
				$language = $this->Language_m->get_by(array('name'=>'Arabic'));
			}
			elseif($post['languageCode'] == 'es'){
						$language = $this->Language_m->get_by(array('code'=>'es-es'));
					$this->lang->load('Webservice', 'spanish');
				}
			elseif($post['languageCode'] == 'ru'){
						$language = $this->Language_m->get_by(array('code'=>'ru-ru'));
					$this->lang->load('Webservice', 'russian');
				}

					if($language == '')
						$language = 1;
					else
						$language = $language->language_id;


			if($post['device'] == '' || $post['device'] == '0')
			{
				throw new Exception($this->lang->line("Error in post data"));
			}

			if($post['isFacebook'] == '1')
			{
				$userRec = $this->Customers_m->get_by(array( 'fbId' => $post['socialId']));

				if($userRec == '')
				{
					$insertdata = array(
		    			"customer_group_id"	=> "1", 
						"language_id" 		=> "1", 
						"firstname"  		=> $post['firstName'], 
						"lastname" 			=> $post['lastName'],
						"email" 			=> $post['email'],
						"ip"				=> "127.0.0.1",
						"status"			=> "1",
						"date_added"		=> date('Y-m-d H:i:s'),
						"fbId" 			=> $post['socialId']
						
					);
					$this->Customers_m->insert($insertdata);

					$insert_id = $this->db->insert_id();
					if($insert_id)
					{	
						$userRec = $this->Customers_m->get_by(array( 'fbId' => $post['socialId']));

						$this->Cart_m->update_by(array('session_id'=> $post['sesssionId']),array('customer_id'=>$userRec->customer_id));

						$count = $this->Devicetoken_m->count_by(array( 'customerId' => $userRec->customer_id,'deviceAccess'=>$post['device']));

						if($count > 0)
						{
							$this->Devicetoken_m->update_by(array('customerId'=>$userRec->customer_id),array('deviceToken' => $post['deviceToken'],'deviceAccess'=>$post['device']));
						}
						else
						{
							$this->Devicetoken_m->insert(array('deviceToken' => $post['deviceToken'],'deviceAccess'=>$post['device'],'customerId'=>$userRec->customer_id));
						}

						$response['result'] = array(
								"userId"	 	=> $userRec->customer_id, 
								"name" 			=> $userRec->firstname.' '.$userRec->lastname,
								"firstName" 	=> $userRec->firstname,
								"lastName" 		=> $userRec->lastname,
								"email" 		=> $userRec->email, 
								"sessionId"		=> $post['sessionId'],
								"phone"			=> "",
								"registerDate"  => (string)strtotime($userRec->date_added), 
								"badgeCount" 	=> "1"
							);
						$response['success'] = 1;
						$response['message'] = $this->lang->line("Congratulations! You are successfully registered");

						
						echo json_encode($response);exit;
					} 
					else
					{
						echo json_encode(array("success" => 0, "message" => $this->lang->line("Something went wrong. Please try again") ));exit;
					}
				}
				else
				{
					$badgeCount= $this->getUnreadCount($userRec->customer_id);
					$response['success'] = 1;
						$response['message'] = $this->lang->line("You are successfully logged in");
					$response['result'] = array(
						"userId"	 	=> $userRec->customer_id, 
						"name" 			=> $userRec->firstname.' '.$userRec->lastname,
						"firstName" 	=> $userRec->firstname,
						"lastName" 		=> $userRec->lastname, 
						"email" 		=> $userRec->email, 
						"phone" 		=> $userRec->telephone,
						"sessionId"		=> $sessionId,
						"registerDate"  => (string)strtotime($userRec->date_added),
						"badgeCount" 	=> (string)$badgeCount
					);
					echo json_encode($response);exit;
				}
			}
			else
			{
				$userRec = $this->Customers_m->get_by(array( 'gmailId' => $post['socialId']));

				if($userRec == '')
				{
					$insertdata = array(
		    			"customer_group_id"	=> "1", 
						"language_id" 		=> "1", 
						"firstname"  		=> $post['firstName'], 
						"lastname" 			=> $post['lastName'],
						"email" 			=> $post['email'],
						"ip"				=> "127.0.0.1",
						"status"			=> "1",
						"date_added"		=> date('Y-m-d H:i:s'),
						"gmailId" 			=> $post['socialId']
						
					);
					$this->Customers_m->insert($insertdata);

					$insert_id = $this->db->insert_id();
					if($insert_id)
					{	
						$userRec = $this->Customers_m->get_by(array( 'gmailId' => $post['socialId']));

						$this->Cart_m->update_by(array('session_id'=> $post['sesssionId']),array('customer_id'=>$userRec->customer_id));

						$count = $this->Devicetoken_m->count_by(array( 'customerId' => $userRec->customer_id,'deviceAccess'=>$post['device']));

						if($count > 0)
						{
							$this->Devicetoken_m->update_by(array('customerId'=>$userRec->customer_id),array('deviceToken' => $post['deviceToken'],'deviceAccess'=>$post['device']));
						}
						else
						{
							$this->Devicetoken_m->insert(array('deviceToken' => $post['deviceToken'],'deviceAccess'=>$post['device'],'customerId'=>$userRec->customer_id));
						}

						$response['result'] = array(
								"userId"	 	=> $userRec->customer_id, 
								"name" 			=> $userRec->firstname.' '.$userRec->lastname,
								"firstName" 	=> $userRec->firstname,
								"lastName" 		=> $userRec->lastname,
								"email" 		=> $userRec->email, 
								"sessionId"		=> $post['sessionId'],
								"phone"			=> "",
								"registerDate"  => (string)strtotime($userRec->date_added), 
								"badgeCount" 	=> "1"
							);
						$response['success'] = 1;
						$response['message'] = $this->lang->line("Congratulations! You are successfully registered");

						
						echo json_encode($response);exit;
					} 
					else
					{
						echo json_encode(array("success" => 0, "message" => $this->lang->line("Something went wrong. Please try again") ));exit;
					}
				}
				else
				{
					$badgeCount= $this->getUnreadCount($userRec->customer_id);
					$response['success'] = 1;
						$response['message'] = $this->lang->line("You are successfully logged in");
					$response['result'] = array(
						"userId"	 	=> $userRec->customer_id, 
						"name" 			=> $userRec->firstname.' '.$userRec->lastname,
						"firstName" 	=> $userRec->firstname,
						"lastName" 		=> $userRec->lastname, 
						"email" 		=> $userRec->email, 
						"phone" 		=> $userRec->telephone,
						"sessionId"		=> $sessionId,
						"registerDate"  => (string)strtotime($userRec->date_added),
						"badgeCount" 	=> (string)$badgeCount
					);
					echo json_encode($response);exit;
				}
			}
		}
		catch(Exception $e)
		{
			$response = array();
			$response['success'] = 0;
			$response['message'] = $e->getMessage();
			echo json_encode($response);exit;
		}	
	}	

 	public function login()
    {	
    	$input = file_get_contents('php://input');
		$post = json_decode($input, true);

		//$posts = $this->input->post();
		//echo '<pre>';print_r($post);exit;

		//Local
		/*{"device": "1","deviceToken": "","phone": "8401549108","password": "123","sessionId" : ""}*/

		//Live
		/*{"device": "1","deviceToken": "","phone": "+918401549107","password": "123","sessionId" : ""}*/


		try
		{
			if((!isset($post['device'])) || (!isset($post['deviceToken'])) || (!isset($post['email'])) || (!isset($post['password'])) || (!isset($post['sessionId'])) || (!isset($post['languageCode'])))
			{
				throw new Exception("Please fill in all the required fields.");
			}

			if($post['languageCode'] == 'en'){
				$language = $this->Language_m->get_by(array('name'=>'English'));
				$this->lang->load('Webservice', 'english');
			}
			elseif($post['languageCode'] == 'ar'){
				$language = $this->Language_m->get_by(array('name'=>'Arabic'));
			}
			elseif($post['languageCode'] == 'es'){
						$language = $this->Language_m->get_by(array('code'=>'es-es'));
					$this->lang->load('Webservice', 'spanish');
				}
			elseif($post['languageCode'] == 'ru'){
						$language = $this->Language_m->get_by(array('code'=>'ru-ru'));
					$this->lang->load('Webservice', 'russian');
				}

					if($language == '')
						$language = 1;
					else
						$language = $language->language_id;

			if($post['device'] == '' || $post['device'] == '0' || $post['email'] == '' || $post['email'] == '0' || $post['password'] == '')
			{
				throw new Exception($this->lang->line("Error in post data"));
			}
			
			if($_SERVER['HTTP_HOST'] == '192.168.1.101')
			{
				$server = $_SERVER['HTTP_HOST'].'/opencart';
			}
			else
			{
				$server = $_SERVER['HTTP_HOST'];
			}
			$userRec = $this->Customers_m->get_by(array( 'email' => $post['email']));
           
			if(isset($userRec->customer_id))
			{
				$userRec = $this->Customers_m->get_by(array( 'email' => $post['email']));
				$userSessionId = '';
				if($post['sessionId'] != '')
				{
					$userCartList = $this->Cart_m->get_many_by(array( 'customer_id' => $userRec->customer_id));
					
					for($k=0;$k<count($userCartList);$k++)
					{
						$array1 = "'".$userCartList[$k]->option."'";
						$userSessionId = $userCartList[$k]->session_id;
						$sessionCartList = $this->Cart_m->get_many_by(array( 'session_id' => $post['sessionId']));
						for($l=0;$l<count($sessionCartList);$l++)
						{
							$finalQuanitity = $userCartList[$k]->quantity + $sessionCartList[$l]->quantity;

							$newproption = "'".$sessionCartList[$l]->option."'";

							$strcmmp = strcmp($array1,$newproption);
							if($strcmmp == '0')
							{
								//$newtestt = 1;
								$this->Cart_m->update_by(array('cart_id'=>$userCartList[$l]->cart_id),array('quantity' => $finalQuanitity));
								$this->Cart_m->delete_by(array('cart_id'=>$sessionCartList[$l]->cart_id));
								break;
							}
						}
					}
					if($userSessionId == '')
					{
						$userSessionId = $post['sessionId'];
					}
					$this->Cart_m->update_by(array('session_id'=> $post['sessionId']),array('customer_id'=>$userRec->customer_id,'session_id'=>$userSessionId));
				}
				else
				{
					$userCartList = $this->Cart_m->get_many_by(array( 'customer_id' => $userRec->customer_id));
					
					$userSessionId = $userCartList[0]->session_id;
				}
				//echo $this->db->last_query();
				//exit;

				$userRec = $this->Customers_m->get_by(array( 'email' => $post['email'], "password" => sha1($userRec->salt . sha1($userRec->salt . sha1($post['password'])))));
			//echo $userRec->customer_id;exit;
				
				if(isset($userRec->customer_id))
				{
					$count = $this->Devicetoken_m->count_by(array( 'customerId' => $userRec->customer_id,'deviceAccess'=>$post['device']));

					if($count > 0)
					{
						$this->Devicetoken_m->update_by(array('customerId'=>$userRec->customer_id),array('deviceToken' => $post['deviceToken'],'deviceAccess'=>$post['device']));
					}
					else
					{
						$this->Devicetoken_m->insert(array('deviceToken' => $post['deviceToken'],'deviceAccess'=>$post['device'],'customerId'=>$userRec->customer_id));
					}
					$dataar = array();
					$dataar['customer_id'] = $userRec->customer_id;
					$dataar['name'] = $userRec->firstname.' '.$userRec->lastname;
					$datan = json_encode($dataar);
					$datead = date('Y-m-d H:i:s');
					$this->Activity_m->insert(array('customer_id' => $userRec->customer_id,'key'=>'login','data'=>$datan,'ip'=>$_SERVER['REMOTE_ADDR'],'date_added'=>$datead));

					$response['success'] = 1;
					$response['message'] = $this->lang->line("You are successfully logged in");

					/*if($userRec->createDate != ''){
						//$date = explode(' ', $userRec->createDate);
						$date =gmdate('d-m-Y h:i:s');
					}*/
					//echo $userSessionId;exit;
					if($userSessionId != '')
					{
						//$cartDetail = $this->Cart_m->get_by(array('customer_id'=>$userRec->customer_id));
						$sessionId = $userSessionId;
					}
					else
					{
						$sessionId = $post['sessionId'];
					}




					if($userRec->profileImage == '')
					{
						$profileImageResp = $profileImageResp = (isset($_SERVER['HTTPS']) ? "https://" : "http://").$server.'/image/profile.png';
						$thumbImageRes =$profileImageResp = (isset($_SERVER['HTTPS']) ? "https://" : "http://").$server.'/image/profile.png';
					}
					else
					{
						if (strpos($userRec->profileImage, 'https://platform-lookaside.fbsbx.com') !== false) 
						{
							$profileImageResp = $userRec->profileImage;
							$thumbImageRes = $userRec->thumbImage;
						}
						elseif(strpos($userRec->profileImage, 'graph.facebook.com') !== false)
						{
							$profileImageResp = $userRec->profileImage;
							$thumbImageRes = $userRec->thumbImage;
						}
						elseif(strpos($userRec->profileImage, 'googleusercontent.com') !== false) {
							$profileImageResp = $userRec->profileImage;
							$thumbImageRes = $userRec->thumbImage;
						}
						else
						{
							$profileImageResp = (isset($_SERVER['HTTPS']) ? "https://" : "http://").$server.'/image/'.$userRec->profileImage;
							$thumbImageRes = (isset($_SERVER['HTTPS']) ? "https://" : "http://").$server.'/image/'.$userRec->thumbImage;
						}

						
					}

					$badgeCount= $this->getUnreadCount($userRec->customer_id);
					$response['result'] = array(
							"userId"	 	=> $userRec->customer_id, 
							"name" 			=> $userRec->firstname.' '.$userRec->lastname,
							"firstName" 	=> $userRec->firstname,
							"lastName" 		=> $userRec->lastname, 
							"email" 		=> $userRec->email, 
							"phone" 		=> $userRec->telephone,
							"sessionId"		=> $sessionId,
							"registerDate"  => (string)strtotime($userRec->date_added),
							"profileImage"	=> $profileImageResp, 
							"thumbImage"	=> $thumbImageRes,
							"badgeCount" 	=> (string)$badgeCount
						);
					echo json_encode($response);exit;
				} 
				else
				{
					echo json_encode(array("success" => 0, "message" => $this->lang->line("The email or password you entered is not correct. Please try again") ));exit;
				}
			}
			else
			{
				echo json_encode(array("success" => 0, "message" => $this->lang->line("The email or password you entered is not correct. Please try again") ));exit;
			}
		}
		catch(Exception $e)
		{
			$response = array();
			$response['success'] = 0;
			$response['message'] = $e->getMessage();
			echo json_encode($response);exit;
		}	
	}

	public function register()
    {	
        
    	$input = file_get_contents('php://input');
		$post = json_decode($input, true);
		//echo '<pre>';print_r($post);exit;


		//Local
		/*{ "device": "1","deviceToken": "","name": "Firstname lastname","firstName":"Firstname","lastName":"lastName","email": "test@gmail.com","phone": "9898801234","password": "123456","sessionId" : ""}*/

		//Live
		/*{ "device": "1","deviceToken": "","name": "Firstname lastname","firstName":"Firstname","lastName":"lastName","email": "test@gmail.com","phone": "9898801234","password": "123456","sessionId" : ""}*/
		
		
		try
		{
			if((!isset($post['device'])) || (!isset($post['deviceToken'])) || (!isset($post['phone'])) || (!isset($post['password'])) || (!isset($post['firstName'])) || (!isset($post['lastName'])) || (!isset($post['email'])) || (!isset($post['sessionId'])) || (!isset($post['languageCode'])))
			{
				throw new Exception("Please fill in all the required fields.");
			}

			if($post['languageCode'] == 'en'){
				$language = $this->Language_m->get_by(array('name'=>'English'));
				$this->lang->load('Webservice', 'english');
			}
			elseif($post['languageCode'] == 'ar'){
				$language = $this->Language_m->get_by(array('name'=>'Arabic'));
			}
			elseif($post['languageCode'] == 'es'){
						$language = $this->Language_m->get_by(array('code'=>'es-es'));
					$this->lang->load('Webservice', 'spanish');
				}
			elseif($post['languageCode'] == 'ru'){
						$language = $this->Language_m->get_by(array('code'=>'ru-ru'));
					$this->lang->load('Webservice', 'russian');
				}

					if($language == '')
						$language = 1;
					else
						$language = $language->language_id;

			if($post['email'] == '' || $post['email'] == '0' || $post['device'] == '' || $post['device'] == '0' || $post['phone'] == '' || $post['phone'] == '0' || $post['password'] == '' || $post['firstName'] == '0' || $post['lastName'] == ''|| $post['firstName'] == '' || $post['lastName'] == '0')
			{
				throw new Exception($this->lang->line("Error in post data"));
			}
			

			$wheres = " key ='shipping_flat_cost' OR key='config_invoice_prefix' OR key='config_name' OR key='config_logo' OR key='config_email' ";
			$settings = $this->Setting_m->get_many_by($wheres);

			for($i=0;$i<count($settings);$i++)
			{
				if($settings[$i]->key == 'config_name')
				{
					$storename = $settings[$i]->value;
				}
				elseif($settings[$i]->key == 'config_invoice_prefix')
				{
					$invoiceprefix = $settings[$i]->value;
				}
				elseif($settings[$i]->key == 'shipping_flat_cost')
				{
					$shippingflatcost = $settings[$i]->value;
				}
				elseif($settings[$i]->key == 'config_logo')
				{
					$logo = $settings[$i]->value;
				}
				elseif($settings[$i]->key == 'config_email')
				{
					$storeemail = $settings[$i]->value;
					
				}
			}


			$where = " telephone ='".$post['phone']."' OR email ='".$post['email']."'";
			$userRec = $this->Customers_m->get_by($where);
			if(isset($userRec->customer_id))
			{
				echo json_encode(array("success" => 0, "message" => $this->lang->line("The mobile number or email already exists") ));exit;
			}
			else
			{
				$salt = $this->token(9);
				$insertdata = array(
			    			"customer_group_id"	=> "3", 
							"language_id" 		=> "1", 
							"firstname"  		=> $post['firstName'], 
							"lastname" 			=> $post['lastName'],
							"email" 			=> $post['email'],
							"telephone"  	 	=> $post['phone'],
							"password"  		=> sha1($salt . sha1($salt . sha1($post['password']))),
							"salt"				=> $salt,
							"ip"				=> "127.0.0.1",
							"status"			=> "1",
							"date_added"		=> date('Y-m-d H:i:s')
						);
				$this->Customers_m->insert($insertdata);
				//echo $this->db->last_query();exit;
				$insert_id = $this->db->insert_id();
				if($insert_id)
				{	
					$userRec = $this->Customers_m->get_by(array( 'telephone' => $post['phone']));

					$this->Cart_m->update_by(array('session_id'=> $post['sesssionId']),array('customer_id'=>$userRec->customer_id));

					$count = $this->Devicetoken_m->count_by(array( 'customerId' => $userRec->customer_id,'deviceAccess'=>$post['device']));

					if($count > 0)
					{
						$this->Devicetoken_m->update_by(array('customerId'=>$userRec->customer_id),array('deviceToken' => $post['deviceToken'],'deviceAccess'=>$post['device']));
					}
					else
					{
						$this->Devicetoken_m->insert(array('deviceToken' => $post['deviceToken'],'deviceAccess'=>$post['device'],'customerId'=>$userRec->customer_id));
					}

					$dataar = array();
					$dataar['customer_id'] = $userRec->customer_id;
					$dataar['name'] = $userRec->firstname.' '.$userRec->lastname;
					$datan = json_encode($dataar);
					$datead = date('Y-m-d H:i:s');
					$this->Activity_m->insert(array('customer_id' => $userRec->customer_id,'key'=>'register','data'=>$datan,'ip'=>$_SERVER['REMOTE_ADDR'],'date_added'=>$datead));


					$html = '<html>
				<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body>';
					$html .='<p>'.sprintf($this->lang->line('text_welcome'), $storename).'</p>';
				
					$html .='<p>'.$this->lang->line('text_approval').'</p>';
					$html .='<p>http://posudacity161.ru/index.php?route=account/login</p>';
					$html .='<p>'.$this->lang->line('text_thanks').'</p>';
					$html .='<p>'.$storename.'</p></body></html>';
					

					$to      = $userRec->email;
					$subject = (sprintf($this->lang->line('text_subject'), $storename));
			        $message = $html;
			        $headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
			        $headers .= 'From: '.$storeemail. "\r\n" .
			            'Reply-To: ' .$storeemail. "\r\n" .
			            'MIME-Version: 1.0' . "\r\n".
			        'X-Mailer: PHP/' . phpversion();

			        mail($to, $subject, $message, $headers);


			        $html2 = '<html>
				<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body>';
					$html2 .='<p>'.$this->lang->line('text_signup').'</p>';
				
					$html2 .='<p>'.$this->lang->line('text_firstname').' '.$userRec->firstname.'</p>';
					$html2 .='<p>'.$this->lang->line('text_lastname').' '.$userRec->lastname.'</p>';
					$html2 .='<p>'.$this->lang->line('text_customer_group').' оптовая</p>';
					$html2 .='<p>'.$this->lang->line('text_email').' '.$userRec->email.'</p>';
					$html2 .='<p>'.$this->lang->line('text_telephone').' '.$post['phone'].'</p>';
					$html2 .='<p>'.$this->lang->line('text_thanks').'</p>';
					$html2 .='<p>'.$storename.'</p></body></html>';
					

					$to2      = $storeemail;
					$subject2 = $this->lang->line('text_new_customer');
			        $message2 = $html2;
			        $headers2  = 'MIME-Version: 1.0' . "\r\n";
					$headers2 .= 'Content-type: text/html; charset=utf-8' . "\r\n";
			        $headers2 .= 'From: '.$storeemail. "\r\n" .
			            'Reply-To: ' .$userRec->email. "\r\n" .
			            'MIME-Version: 1.0' . "\r\n".
			        'X-Mailer: PHP/' . phpversion();

			        mail($to2, $subject2, $message2, $headers2);

					$response['result'] = array(
							"userId"	 	=> $userRec->customer_id, 
							"name" 			=> $userRec->firstname.' '.$userRec->lastname,
							"email" 		=> $userRec->email, 
							"phone" 		=> $userRec->telephone,
							"sessionId"		=> $post['sessionId'],
							"profileImage"	=> "",
							"registerDate"  => (string)strtotime($userRec->date_added), 
							"badgeCount" 	=> "1"
						);
					$response['success'] = 1;
					$response['message'] = $this->lang->line("Congratulations! You are successfully registered");

					
					echo json_encode($response);exit;
				} 
				else
				{
					echo json_encode(array("success" => 0, "message" => $this->lang->line("Something went wrong. Please try again") ));exit;
				}
			}
		}
		catch(Exception $e)
		{
			$response = array();
			$response['success'] = 0;
			$response['message'] = $e->getMessage();
			echo json_encode($response);exit;
		}		
	}

	public function staticPages()
	{
		$input = file_get_contents('php://input');
		$post = json_decode($input, true);

		//{ "languageCode":"en"}

		try
		{
			if((!isset($post['languageCode'])))
			{
				throw new Exception("Please fill in all the required fields.");
			}

			if($post['languageCode'] == '' || $post['languageCode'] == '0')
			{
				throw new Exception("Error in post data.");
			}
			$this->load->model('Information_m');
			$pageData = $this->Information_m->get_many_by(array('language_id'=>1));
			$page = array();
			if($_SERVER['HTTP_HOST'] == '192.168.1.101')
			{
				$server = $_SERVER['HTTP_HOST'].'/opencart';
			}
			else
			{
				$server = $_SERVER['HTTP_HOST'];
			}

			for($i=0;$i<count($pageData);$i++)
			{
				$innerarr = array();
				$innerarr['title'] = str_replace("amp;","",$pageData[$i]->title);
				if($post['languageCode'] == 'en')
				{
					$innerarr['url'] = (isset($_SERVER['HTTPS']) ? "https://" : "http://").$server.'/API/index.php/StaticPages/'.$pageData[$i]->information_id.'/1';
				}
				elseif($post['languageCode'] == 'ar')
				{
					$innerarr['url'] = (isset($_SERVER['HTTPS']) ? "https://" : "http://").$server.'/API/index.php/StaticPages/'.$pageData[$i]->information_id.'/2';
				}
				$page[] = $innerarr;
			}

			$response['success'] = 1;
			$response['result'] = $page;
			echo json_encode($response);exit;
		}
		catch(Exception $e)
		{
			$response = array();
			$response['success'] = 0;
			$response['message'] = $e->getMessage();
			echo json_encode($response);exit;
		}	
	}

	public function updateProfile()
	{	
		/*global $HTTP_RAW_POST_DATA;
		$json_content = $_POST;
		$post = json_decode($json_content['json_content'], true);*/

		//print_r($post);exit;
		
		$post = $_REQUEST;

		//echo '<pre>';print_r($_FILES);exit;
		//Local
		/*$post['device'] = '1';
		$post['phone'] = '8401549108';
		$post['firstName'] = 'Khalid';
		$post['lastName'] = 'Chauhan';
		$post['email'] = 'khalid@gmail.com';
		$post['userId'] = '3';
		$post['sessionId'] = '';*/

		//Live
		/*$post['device'] = '1';
		$post['phone'] = '+918401549107';
		$post['firstName'] = 'Khalid';
		$post['lastName'] = 'Chauhan';
		$post['email'] = 'khalid@harmistechnology.com';
		$post['userId'] = '44';
		$post['sessionId'] = '';*/

		try
		{
			if((!isset($post['device'])) || (!isset($post['phone'])) || (!isset($post['firstName'])) || (!isset($post['lastName'])) || (!isset($post['email'])) || (!isset($post['userId'])) || (!isset($post['sessionId'])) || (!isset($post['languageCode'])))
			{
				throw new Exception("Please fill in all the required fields.");
			}

			if($post['languageCode'] == 'en'){
				$language = $this->Language_m->get_by(array('name'=>'English'));
				$this->lang->load('Webservice', 'english');
			}
			elseif($post['languageCode'] == 'ar'){
				$language = $this->Language_m->get_by(array('name'=>'Arabic'));
			}
			elseif($post['languageCode'] == 'es'){
						$language = $this->Language_m->get_by(array('code'=>'es-es'));
					$this->lang->load('Webservice', 'spanish');
				}
			elseif($post['languageCode'] == 'ru'){
						$language = $this->Language_m->get_by(array('code'=>'ru-ru'));
					$this->lang->load('Webservice', 'russian');
				}

			if($language == '')
				$language = 1;
			else
				$language = $language->language_id;

			if($post['email'] == '' || $post['email'] == '0' || $post['device'] == '' || $post['device'] == '0' || $post['phone'] == '' || $post['phone'] == '0' || $post['firstName'] == '0' || $post['lastName'] == ''|| $post['firstName'] == '' || $post['lastName'] == '0')
			{
				throw new Exception($this->lang->line("Error in post data"));
			}

			if($_SERVER['HTTP_HOST'] == '192.168.1.101')
			{
				$server = $_SERVER['HTTP_HOST'].'/opencart';
			}
			else
			{
				$server = $_SERVER['HTTP_HOST'];
			}


			$target_dir = '../image';
			$name = "";
			if(isset($_FILES['profileImage']['name']) && $_FILES['profileImage']['name'] != '')
			{
				$name = $_FILES['profileImage']['name'];
			}
			
			$userRec = $this->Customers_m->get_by(array( 'customer_id' => $post['userId']));
			if($userRec == '')
			{
				throw new Exception($this->lang->line("Something went wrong. Please try again"));
			}

			if( isset($_FILES['profileImage']) && $name != "")
			{  
				$config['upload_path']    = $target_dir;
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $_FILES['file']['name']  = time().$_FILES['profileImage']['name'];
                $_FILES['file']['type']   = $_FILES['profileImage']['type'];
                $_FILES['file']['tmp_name']= $_FILES['profileImage']['tmp_name'];
                $_FILES['file']['error']  = $_FILES['profileImage']['error'];
                $_FILES['file']['size']   = $_FILES['profileImage']['size'];
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
				
				$profileImagename = $_FILES['file']['name'];
                if ($this->upload->do_upload('file'))
				{

			        $data     = $this->upload->data();

                    $imagname = $target_dir.'/'.$data['file_name'];
					$sorceFile = $data['file_path'].$data['file_name'];
					$config['image_library'] = 'gd2';
                    $config['source_image'] = $sorceFile;
                    $config['create_thumb'] = TRUE;
                    $config['maintain_ratio'] = TRUE;
                    $config['width']         = 150;
                    $config['height']       = 150;
                    $config['new_image'] = $target_dir;
					$config['thumb_marker'] = '_thumb';
                    $this->load->library('image_lib', $config);

                    if (!$this->image_lib->resize()) 
                    {
				        echo $this->image_lib->display_errors();
				    }

                    $this->image_lib->clear();
                    $imgarr = explode('.', $data['file_name']);
                    $thumbimagename = $imgarr[0].'_thumb'.'.'.$imgarr[1];
                    $imagethumbpath = $target_dir.'/'.$imgarr[0].'_thumb'.'.'.$imgarr[1];
                    
                    $thumbImage = base_url().$imagethumbpath;
                    $uploaded_file_url = base_url().$imagname;

			        if($userRec->profileImage != '')
			        {
						unlink('../image/'.$userRec->profileImage);
						unlink('../image/'.$userRec->thumbImage);
			        }
				}
				else
				{
					 throw new Exception(strip_tags($this->upload->display_errors()));
				} 
				
			}
			else
			{
				
				$profileImagename = $userRec->profileImage;
				$thumbimagename = $userRec->thumbImage;
			}


			
			$this->Customers_m->update_by(array('customer_id'=>$post['userId']),array('firstname' => $post['firstName'],'lastname'=>$post['lastName'],'email'=>$post['email'],'telephone'=>$post['phone'],'profileImage'=>$profileImagename,'thumbImage'=>$thumbimagename));

			$userRec = $this->Customers_m->get_by(array( 'customer_id' => $post['userId']));



			if($post['sessionId'] == '' || $post['sessionId'] == '0')
			{
				$cartDetail = $this->Cart_m->get_by(array('customer_id'=>$userRec->customer_id));
				$sessionId = $cartDetail->session_id;
			}
			else
			{
				$sessionId = $post['sessionId'];
			}


			if($profileImagename == '')
			{
				$profileImageResp = '';
				$thumbImageRes ='';
			}
			else
			{

				if (strpos($userRec->profileImage, 'https://platform-lookaside.fbsbx.com') !== false) 
				{
					$profileImageResp = $userRec->profileImage;
					$thumbImageRes = $userRec->thumbImage;
				}
				elseif(strpos($userRec->profileImage, 'graph.facebook.com') !== false)
				{
					$profileImageResp = $userRec->profileImage;
					$thumbImageRes = $userRec->thumbImage;
				}
				elseif(strpos($userRec->profileImage, 'googleusercontent.com') !== false) {
					$profileImageResp = $userRec->profileImage;
					$thumbImageRes = $userRec->thumbImage;
				}
				else
				{
					$profileImageResp = (isset($_SERVER['HTTPS']) ? "https://" : "http://").$server.'/image/'.$userRec->profileImage;
					$thumbImageRes = (isset($_SERVER['HTTPS']) ? "https://" : "http://").$server.'/image/'.$userRec->thumbImage;
				}
				//$profileImageResp = (isset($_SERVER['HTTPS']) ? "https://" : "http://").$server.'/image/'.$userRec->profileImage;
				//$thumbImageRes = (isset($_SERVER['HTTPS']) ? "https://" : "http://").$server.'/image/'.$userRec->thumbImage;
			}

			$badgeCount= $this->getUnreadCount($userRec->customer_id);

			$response['result'] = array(
					"userId"	 	=> $userRec->customer_id, 
					"name" 			=> $userRec->firstname.' '.$userRec->lastname,
					"firstName" 	=> $userRec->firstname,
					"lastName" 		=> $userRec->lastname,
					"email" 		=> $userRec->email, 
					"phone" 		=> $userRec->telephone,
					"profileImage"  => $profileImageResp,
					"thumbImage"    => $thumbImageRes,
					"sessionId"		=> $sessionId,
					"registerDate"  => (string)strtotime($userRec->date_added),
					"badgeCount" 	=> (string)$badgeCount
				);
			$response['success'] = 1;
			$response['message'] = $this->lang->line("Profile updated successfully");
			echo json_encode($response);exit;

		}
		catch(Exception $e)
		{
			$response = array();
			$response['success'] = 0;
			$response['message'] = $e->getMessage();
			echo json_encode($response);exit;
		}
	}

	public function changePassword()
	{
		$input = file_get_contents('php://input');
		$post = json_decode($input, true);

		//{"phone": "8401549108","password":"123456"}

		try
		{
			if((!isset($post['phone'])) || (!isset($post['password'])) || (!isset($post['languageCode'])))
			{
				throw new Exception("Please fill in all the required fields.");
			}

			if($post['languageCode'] == 'en'){
				$language = $this->Language_m->get_by(array('name'=>'English'));
				$this->lang->load('Webservice', 'english');
			}
			elseif($post['languageCode'] == 'ar'){
				$language = $this->Language_m->get_by(array('name'=>'Arabic'));
			}
			elseif($post['languageCode'] == 'es'){
						$language = $this->Language_m->get_by(array('code'=>'es-es'));
					$this->lang->load('Webservice', 'spanish');
				}
			elseif($post['languageCode'] == 'ru'){
						$language = $this->Language_m->get_by(array('code'=>'ru-ru'));
					$this->lang->load('Webservice', 'russian');
				}

			if($language == '')
				$language = 1;
			else
				$language = $language->language_id;

			if($post['phone'] == '' || $post['phone'] == '0' || $post['password'] == '')
			{
				throw new Exception($this->lang->line("Error in post data"));
			}
			
			$userRec = $this->Customers_m->get_by(array('telephone'=>$post['phone']));

			if(isset($userRec->customer_id))
			{
				$salt = $userRec->salt;
				$this->Customers_m->update_by(array('customer_id'=>$userRec->customer_id),array('password' => sha1($salt . sha1($salt . sha1($post['password'])))));
				$response['success'] = 1;
				$response['message'] = $this->lang->line("Congratulations! Your password reset successfully");
				echo json_encode($response);exit;
			}
			else
			{
				echo json_encode(array("success" => 0, "message" => $this->lang->line("Something went wrong. Please try again") ));exit;
			}
		}
		catch(Exception $e)
		{
			$response = array();
			$response['success'] = 0;
			$response['message'] = $e->getMessage();
			echo json_encode($response);exit;
		}		
	}

	public function userDetails()
	{
		$input = file_get_contents('php://input');
		$post = json_decode($input, true);

		//Local
		// {"device": "1","deviceToken": "","userId": "3","sessionId" : ""}
		//Live 
		// {"device": "1","deviceToken": "","userId": "44","sessionId" : ""}
        
		try
		{
			if((!isset($post['device'])) || (!isset($post['deviceToken'])) || (!isset($post['userId'])) || (!isset($post['sessionId'])) || (!isset($post['languageCode'])))
			{
				throw new Exception("Please fill in all the required fields.");
			}

			if($post['languageCode'] == 'en'){
				$language = $this->Language_m->get_by(array('name'=>'English'));
				$this->lang->load('Webservice', 'english');
			}
			elseif($post['languageCode'] == 'ar'){
				$language = $this->Language_m->get_by(array('name'=>'Arabic'));
			}
			elseif($post['languageCode'] == 'es'){
						$language = $this->Language_m->get_by(array('code'=>'es-es'));
					$this->lang->load('Webservice', 'spanish');
				}
			elseif($post['languageCode'] == 'ru'){
						$language = $this->Language_m->get_by(array('code'=>'ru-ru'));
					$this->lang->load('Webservice', 'russian');
				}

			if($language == '')
				$language = 1;
			else
				$language = $language->language_id;

			if($post['device'] == '' || $post['device'] == '0' || $post['userId'] == '' || $post['userId'] == '0')
			{
				throw new Exception($this->lang->line("Error in post data"));
			}
			
			if($_SERVER['HTTP_HOST'] == '192.168.1.101')
			{
				$server = $_SERVER['HTTP_HOST'].'/opencart';
			}
			else
			{
				$server = $_SERVER['HTTP_HOST'];
			}

			$userRec = $this->Customers_m->get_by(array( 'customer_id' => $post['userId']));
		
			if(isset($userRec->customer_id))
			{
				$response['success'] = 1;

				if($post['sessionId'] == '' || $post['sessionId'] == '0')
				{
					$cartDetail = $this->Cart_m->get_by(array('customer_id'=>$userRec->customer_id));
					$sessionId = $cartDetail->session_id;
				}
				else
				{
					$sessionId = $post['sessionId'];
				}

				if($userRec->profileImage == '')
				{
					$profileImageResp = '';
					$thumbImageRes ='';
				}
				else
				{
					if (strpos($userRec->profileImage, 'https://platform-lookaside.fbsbx.com') !== false) 
					{
						$profileImageResp = $userRec->profileImage;
						$thumbImageRes = $userRec->thumbImage;
					}
					elseif(strpos($userRec->profileImage, 'graph.facebook.com') !== false)
					{
						$profileImageResp = $userRec->profileImage;
						$thumbImageRes = $userRec->thumbImage;
					}
					elseif(strpos($userRec->profileImage, 'googleusercontent.com') !== false) {
						$profileImageResp = $userRec->profileImage;
						$thumbImageRes = $userRec->thumbImage;
					}
					else
					{
						$profileImageResp = (isset($_SERVER['HTTPS']) ? "https://" : "http://").$server.'/image/'.$userRec->profileImage;
						$thumbImageRes = (isset($_SERVER['HTTPS']) ? "https://" : "http://").$server.'/image/'.$userRec->thumbImage;
					}

					//$profileImageResp = (isset($_SERVER['HTTPS']) ? "https://" : "http://").$server.'/image/'.$userRec->profileImage;
					//$thumbImageRes = (isset($_SERVER['HTTPS']) ? "https://" : "http://").$server.'/image/'.$userRec->thumbImage;
				}

				$badgeCount= $this->getUnreadCount($userRec->customer_id);
				$response['result'] = array(
						"userId"	 	=> $userRec->customer_id, 
						"name" 			=> $userRec->firstname.' '.$userRec->lastname,
						"firstName" 	=> $userRec->firstname,
						"lastName" 		=> $userRec->lastname,
						"email" 		=> $userRec->email, 
						"phone" 		=> $userRec->telephone,
						"sessionId"		=> $sessionId,
						"registerDate"  => (string)strtotime($userRec->date_added),
						"profileImage"	=> $profileImageResp, 
						"thumbImage"	=> $thumbImageRes,
						"badgeCount" 	=> (string)$badgeCount
					);
				echo json_encode($response);exit;
			} 
			else
			{
				echo json_encode(array("success" => 0, "message" => $this->lang->line("User detail not found") ));exit;
			}
		}
		catch(Exception $e)
		{
			$response = array();
			$response['success'] = 0;
			$response['message'] = $e->getMessage();
			echo json_encode($response);exit;
		}	
	}

	public function getBanners()
	{
		$input = file_get_contents('php://input');
		$post = json_decode($input, true);
		
		//echo '<pre>';print_r($post);exit;
		
		$this->load->model('Banners_m');
        
		try
		{
			$bannerRec = $this->Banners_m->get_by(array('banner_id'=>'9'));


			if(isset($bannerRec->banner_id))
			{
				$bannerImage = $this->Banners_m->getBanners($bannerRec->banner_id,$post['languageCode']);

				$response['success'] = 1;

				$bannerarray = array();
				if($_SERVER['HTTP_HOST'] == '192.168.1.101')
						{
							$server = $_SERVER['HTTP_HOST'].'/opencart';
						}
						else
						{
							$server = $_SERVER['HTTP_HOST'];
						}
				for($i=0;$i<count($bannerImage);$i++)
				{
					$innerarr['title'] = $bannerImage[$i]->title;
					$innerarr['image'] = (isset($_SERVER['HTTPS']) ? "https://" : "http://") .$server.'/image/'.$bannerImage[$i]->image;
                    $innerarr['productId'] = $bannerImage[$i]->link;
					$bannerarray[] = $innerarr;
				}

				$response['result'] = $bannerarray;
				echo json_encode($response);exit;
			} 
			else
			{
				echo json_encode(array("success" => 0, "message" => "Something went wrong. Please try again." ));exit;
			}
		}
		catch(Exception $e)
		{
			$response = array();
			$response['success'] = 0;
			$response['message'] = $e->getMessage();
			echo json_encode($response);exit;
		}
	}

	public function getProductDetails()
	{
		$input = file_get_contents('php://input');
		$post = json_decode($input, true);	


		//{ "userId":"4","device": "1","languageCode" : "en","productId" : "42"}
	

		try
		{	
			if((!isset($post['languageCode'])) || (!isset($post['productId'])) || (!isset($post['userId'])) )
			{
				throw new Exception("Please fill in all the required fields.");
			}
			if( $post['languageCode'] == '' || $post['languageCode'] == '0' || $post['productId'] == '' || $post['productId'] == '0')
			{
				throw new Exception("Error in post data.");
			}

			if($_SERVER['HTTP_HOST'] == '192.168.1.101')
			{
				$server = $_SERVER['HTTP_HOST'].'/opencart';
			}
			else
			{
				$server = $_SERVER['HTTP_HOST'];
			}
			$response['success'] = 1;
			$innerarr = array();

			if($post['languageCode'] == 'en'){
				$language = $this->Language_m->get_by(array('name'=>'English'));
				$this->lang->load('Webservice', 'english');
			}
			elseif($post['languageCode'] == 'ar'){
				$language = $this->Language_m->get_by(array('name'=>'Arabic'));
			}
			elseif($post['languageCode'] == 'es'){
						$language = $this->Language_m->get_by(array('code'=>'es-es'));
					$this->lang->load('Webservice', 'spanish');
				}
			elseif($post['languageCode'] == 'ru'){
						$language = $this->Language_m->get_by(array('code'=>'ru-ru'));
					$this->lang->load('Webservice', 'russian');
				}

			if($language == '')
				$language = 1;
			else
				$language = $language->language_id;

			$productDetail = $this->Products_m->getProductDetail($post['productId'],$language);

			$wherecon = "key ='config_currency'";
			$settings = $this->Setting_m->get_by($wherecon);
			

			$currencydetail = $this->Currency_m->get_by(array('code'=>$settings->value,'status'=>1));
			//echo '<pre>';print_r($currencydetail);exit;
			if($productDetail != '')
			{					
				$innerarr['productId'] = $post['productId'];
				$innerarr['name'] = $productDetail->name;

				if($post['userId'] != "")
				{
					$prodCount = $this->Wishlist_m->Count_by(array( 'customer_id' => $post['userId'],'product_id'=> $post['productId']));
					$innerarr['isFavourite'] = $prodCount;
				}
				else
				{
					$innerarr['isFavourite'] = 0;
				}

				$productImages = $this->Products_m->getProductImages($post['productId']);
				$mainimagear = array();
                                $innerimgarr['product_image_id'] = "0";
				$innerimgarr['image'] = (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $server.'/image/'.$productDetail->image;
				$mainimagear[] = $innerimgarr;

				for($k=0;$k<count($productImages);$k++)
				{		
					 		
					$innerimgarr['product_image_id'] = $productImages[$k]->product_image_id;
					$innerimgarr['image'] = (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $server.'/image/'.$productImages[$k]->image;

					$mainimagear[] = $innerimgarr;
				}
				$productPriceF  = $this->Products_m->getProductPrice($post['productId'], $post['userId']);

					$productPrice = $productPriceF->price;
				$description = html_entity_decode($productDetail->description);
				$innerarr['images'] = $mainimagear;
				$innerarr['description'] = strip_tags($description);
				$innerarr['model'] = $productDetail->model;
				$innerarr['currencyCode'] = $currencydetail->symbol_left;
				$innerarr['orginalPrice'] = number_format((float)$productPrice, 2, '.', '');
				$innerarr['discountPrice'] = number_format((float)$productDetail->extax, 2, '.', '');
				$innerarr['minQuantity'] = $productDetail->minimum;
				$innerarr['minQuantityDesc'] = "This product has a minimum quantity of ".$productDetail->minimum;
				$innerarr['shareUrl'] = (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $server.'/index.php?route=product/product&product_id='.$post['productId'];


				if($productDetail->quantity >= $productDetail->minimum && $productDetail->quantity != '0')
				{
					$innerarr['inStock'] = "1";
				}
				else
				{
					$innerarr['inStock'] = "0";
				}

				if($post['userId'] != "" || $post['sessionId']!='')
				{
					//Cart array start
					if($post['userId'] != '' && $post['userId'] != '0')
					{
						
						$cartDetail = $this->Cart_m->get_many_by(array( 'customer_id' => $post['userId'],'product_id'=> $post['productId']));
					}
					elseif($post['sessionId'] != '' && $post['sessionId'] != '0')
					{
						
						$cartDetail = $this->Cart_m->get_many_by(array( 'customer_id' => $post['userId'],'product_id'=> $post['productId']));
					}
							

					
					if(!empty($cartDetail))
					{
						$cartarray = array();
						$qunt = 0;
						$sum = 0;
						for($l=0;$l<count($cartDetail);$l++){
							//$productPriceF  = $this->Products_m->getProductPrice($post['productId']);
							
							$mainoptionarr = array();
						$data = json_decode($cartDetail[$l]->option);

						//echo '<pre>';print_r($data);
						foreach($data as $key=>$value) 
						{
							
							if(is_array($value) && $key!=_empty_)
							{	
								$inneroparr = array();
								
								$inneritemarrmultiple = array();
								for($z=0;$z<count($value);$z++)
								{
									$result = $this->Cart_m->getCartOptionDetail($key,$value[$z]);
									
									if($result->type == 'checkbox')
									{
										
											$inneritemarr = array();
											
										$productPrice = $productPrice + $result->price;
										
									}
								}
								
							}
							else
							{
                                if($value!='' && $key!=_empty_){
                                	$inneroparr = array();
								$result = $this->Cart_m->getCartOptionDetail($key,$value);
                            
								if($result->type == 'radio' || $result->type == 'select')
								{
									
									$productPrice = $productPrice + $result->price;
								}
								$mainoptionarr[] = $inneroparr;
								}
							}
							
						}
						$qunt = $qunt+$cartDetail[$l]->quantity;
						$price = number_format((float)$productPrice, 2, '.', '');
						$originalPrice = number_format((float)$productPrice, 2, '.', '');
						
						$sum = $sum+$productPrice * $cartDetail[$l]->quantity;
						//$total = $total + $sum;
						//$total = number_format((float)$total, 2, '.', '');

							
						}
						$where = " key ='shipping_flat_cost'";
						$settings = $this->Setting_m->get_by($where);
						//$shipping = number_format((float)$settings->value, 2, '.', '');
							$total = number_format((float)$sum, 2, '.', '');
							if($total != 0)
							{
								//$netTotal =  $shipping + $total;
								$netTotal = number_format((float)$total, 2, '.', '');
							}
							else
							{
								$netTotal = 0.00;
							}
						$cartarray['quantity'] = $qunt;
						$cartarray['currencyCode'] = $currencydetail->symbol_left;
						$cartarray['price'] =(string)$netTotal;
						
					}
					else
					{
						$cartarray = array();
						$cartarray['quantity'] = "0";
						$cartarray['currencyCode'] = $currencydetail->symbol_left;
						$cartarray['price'] = "0.00";
					}
				}
				else
				{
					$cartarray = array();
					$cartarray['quantity'] = "0";
					$cartarray['currencyCode'] = $currencydetail->symbol_left;
					$cartarray['price'] = "0.00";
				}

				$innerarr['cart'] = $cartarray;
				// Cart array ends here

				//Extrafield array start here
				$extrafield = array();
				$subarray = array();
				$subarray['placeholder'] = 'Ex Tax:';
				$subarray['value'] = $currencydetail->symbol_left.number_format((float)$productDetail->extax, 2, '.', '');
				$extrafield[] = $subarray;

				$subarray1 = array();
				$subarray1['placeholder'] = 'Price in reward points:';
				$subarray1['value'] = $productDetail->points;
				$extrafield[] = $subarray1;

				$innerarr['extraFields'] = $extrafield;
				//Extrafield array ends here


				//Offers array start here

				$productDiscounts = $this->Products_m->getProductDiscounts($post['productId']);
				$offers = array();

				for($k=0;$k<count($productDiscounts);$k++)
				{		
					//$innerdiscarr['product_discount_id'] = $productDiscounts[$k]->product_discount_id;
					$innerdiscarr['value'] = $productDiscounts[$k]->quantity.' or more $'.number_format((float)$productDiscounts[$k]->price, 2, '.', '');
					//$innerdiscarr['price'] = $productDiscounts[$k]->price;
					$offers[] = $innerdiscarr;
				}

				$innerarr['offers'] = $offers;
				//Offers array ends here

				//Properties array starts here
				$property = array();

				$subarray2 = array();
				$subarray2['placeholder'] = $this->lang->line('Brands');
				$subarray2['value'] = $productDetail->manufacturename;
				$property[] = $subarray2;

				$subarray3 = array();
				$subarray3['placeholder'] = $this->lang->line('Product Code');
				$subarray3['value'] = $productDetail->model;
				$property[] = $subarray3;

				$subarray4 = array();
				$subarray4['placeholder'] = $this->lang->line('Reward Points');
				$subarray4['value'] = $productDetail->rewardPoints;
				$property[] = $subarray4;

				$innerarr['properties'] = $property;
				
						
				$productOptions = $this->Products_m->getProductOptions($post['productId']);
				//echo '<pre>';print_r($productOptions);exit;
				$mainoptionarr = array();

				for($m=0;$m<count($productOptions);$m++)
				{
					if($productOptions[$m]->type == 'radio' || $productOptions[$m]->type == 'checkbox' || $productOptions[$m]->type == 'select')
					{
						if($productOptions[$m]->type == 'radio')
						{
							$optype = '0';
						}
						elseif($productOptions[$m]->type == 'checkbox')
						{
							$optype = '1';
						}
						elseif($productOptions[$m]->type == 'select')
						{
							$optype = '2';
						}
					
						$inneroparr['productOptionId'] = $productOptions[$m]->product_option_id;
						//$inneroparr['option_id'] = $productOptions[$m]->option_id;
						//$inneroparr['value'] = $productOptions[$m]->value;
						$inneroparr['isMandatory'] = $productOptions[$m]->required;
						$inneroparr['type'] = $optype;
						$inneroparr['title'] = html_entity_decode($productOptions[$m]->name);

						$productSubOptions = $this->Products_m->getProductSubOptions($productOptions[$m]->product_option_id);
						//echo '<pre>';print_r($productSubOptions);exit;
						$mainsuboptionarr = array();

						for($k=0;$k<count($productSubOptions);$k++)
						{
							$subOptionTitle = $this->Products_m->getSubOptionTitle($productSubOptions[$k]->option_value_id);
							$innersuboparr['optionId'] = $productSubOptions[$k]->product_option_value_id;
							$innersuboparr['value'] = $subOptionTitle->name." (".$productSubOptions[$k]->price_prefix.$currencydetail->symbol_left.number_format((float)$productSubOptions[$k]->price, 2, '.', '').")";
							$mainsuboptionarr[] = $innersuboparr;
						}
						$inneroparr['items'] = $mainsuboptionarr;
						
						$mainoptionarr[] = $inneroparr;
					}
				}
				$innerarr['options'] = $mainoptionarr;

				$relatedProducts = $this->Products_m->getRelatedProducts($post['productId']);
				$mainrelatedprodarr = array();

				for($k=0;$k<count($relatedProducts);$k++)
				{	
					if($post['languageCode'] == 'en'){
				$language = $this->Language_m->get_by(array('name'=>'English'));
				$this->lang->load('Webservice', 'english');
			}
			elseif($post['languageCode'] == 'ar'){
				$language = $this->Language_m->get_by(array('name'=>'Arabic'));
			}
			elseif($post['languageCode'] == 'es'){
						$language = $this->Language_m->get_by(array('code'=>'es-es'));
					$this->lang->load('Webservice', 'spanish');
				}
			elseif($post['languageCode'] == 'ru'){
						$language = $this->Language_m->get_by(array('code'=>'ru-ru'));
					$this->lang->load('Webservice', 'russian');
				}

					if($language == '')
						$language = 1;
					else
						$language = $language->language_id;

					$productDetail = $this->Products_m->getProductDetail($relatedProducts[$k]->related_id,$language);

					if($productDetail != '')
					{					
						if($productDetail->extax != 0 && $productDetail->extax != '')
						{
							$discountPrice = number_format((float)$productDetail->extax, 2, '.', '');
						}
						else
						{
							$discountPrice = "0.00";
						}
						$innerrelarr['productId'] = $relatedProducts[$k]->related_id;
						$innerrelarr['name'] = $productDetail->name;
						//$innerrelarr['model'] = $productDetail->model;
						$innerrelarr['discountPrice'] = $productDetail->extax;
						//$innerrelarr['availability'] = $productDetail->availability;
						$innerrelarr['currencyCode'] = $currencydetail->symbol_left;
						$innerrelarr['price'] = number_format((float)$productDetail->price, 2, '.', '');
						$innerrelarr['minQuantity'] = $productDetail->minimum;
						$innerrelarr['minQuantityDesc'] = "This product has a minimum quantity of ".$productDetail->minimum;

						if($post['userId'] != "")
						{
							$prodCount = $this->Wishlist_m->Count_by(array( 'customer_id' => $post['userId'],'product_id'=>  $relatedProducts[$k]->related_id));

							$innerrelarr['isfavourite'] = (string)$prodCount;
						}
						else
						{
							$innerrelarr['isfavourite'] = "0";
						}

						if($productDetail->image == '')
						{
							$innerrelarr['thumbImage'] =  "";
						}
						else
						{
							$innerrelarr['thumbImage'] = (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $server.'/image/'.$productDetail->image;
						}
						$innerrelarr['shareUrl'] = (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $server.'/index.php?route=product/product&product_id='.$relatedProducts[$k]->related_id;

						$mainrelatedprodarr[] = $innerrelarr;
					}
				}

				$innerarr['relatedProducts'] = $mainrelatedprodarr;

				$response['result'] = $innerarr;
				$response = $this->convertNullToString($response);
				echo json_encode($response);exit;	
			}
			else
			{
				echo json_encode(array("success" => 0, "message" => $this->lang->line('No details found')));exit;
			}
		}
		catch(Exception $e)
		{
			$response = array();
			$response['success'] = 0;
			$response['message'] = $e->getMessage();
			echo json_encode($response);exit;
		}	
	}

	public function testAPI()
	{
		$finalCart = $this->Cart_m->get_many_by(array( 'customer_id' => 3 , 'product_id'=> 42));
		$data = json_decode($finalCart[0]->option);
		foreach($data as $key=>$value) {
			if(is_array($value))
			{
				for($z=0;$z<count($value);$z++)
				{
					$result = $this->Cart_m->getCartOptionDetail($key,$value[$z]);
				}
			}
			else
			{
				$result = $this->Cart_m->getCartOptionDetail($key,$value);
			}
			echo '<pre>';print_r($result);
		}
	}

	public function updateCart()
	{
		$input = file_get_contents('php://input');
		$post = json_decode($input, true);
		//echo '<pre>';print_r($post);exit;
		try
		{
			if((!isset($post['productId'])) || (!isset($post['userId'])) || (!isset($post['languageCode'])) || (!isset($post['sessionId'])) || (!isset($post['action'])))
			{
				throw new Exception("Please fill in all the required fields.");
			}

			if($post['languageCode'] == 'en'){
				$language = $this->Language_m->get_by(array('name'=>'English'));
				$this->lang->load('Webservice', 'english');
			}
			elseif($post['languageCode'] == 'ar'){
				$language = $this->Language_m->get_by(array('name'=>'Arabic'));
			}
			elseif($post['languageCode'] == 'es'){
						$language = $this->Language_m->get_by(array('code'=>'es-es'));
					$this->lang->load('Webservice', 'spanish');
				}
			elseif($post['languageCode'] == 'ru'){
						$language = $this->Language_m->get_by(array('code'=>'ru-ru'));
					$this->lang->load('Webservice', 'russian');
				}

					if($language == '')
						$language = 1;
					else
						$language = $language->language_id;

			if($post['productId'] == '' || $post['productId'] == '0' ||  $post['languageCode'] == '' || $post['languageCode'] == '0' ||  $post['action'] == '' || $post['action'] == '0')
			{
				throw new Exception($this->lang->line("Error in post data"));
			}
			//$proption = '';
			if($post['referenceId'] != 0 && $post['action'] == 2)
			{
				$cartDetail = $this->Cart_m->get_by(array('cart_id' => $post['referenceId']));
				$quantity = $cartDetail->quantity - $post['quantity'];

				$this->Cart_m->update_by(array('cart_id'=>$post['referenceId']),array('quantity' => $quantity));
			}
			elseif($post['userId'] != '' && $post['userId'] != '0')
			{
				if($post['sessionId'] != '' && $post['sessionId'] != '0')
				{
					if(count($post['options']) > 0)
					{
						for($i=0;$i<count($post['options']);$i++)
						{
							if($post['options'][$i]['type'] == 0)
							{
								/*$selected = $this->Cart_m->getSelectedOption($post['options'][$i]['productOptionId'],$post['options'][$i]['items'][0]['optionId']);
								$proption[$post['options'][$i]['productOptionId']] = $selected->product_option_value_id;*/
								$proption[$post['options'][$i]['productOptionId']] = $post['options'][$i]['items'][0]['optionId'];
							}
							elseif($post['options'][$i]['type'] == 1)
							{
								for($k=0;$k<count($post['options'][$i]['items']);$k++)
								{
									/*$selected = $this->Cart_m->getSelectedOption($post['options'][$i]['productOptionId'],$post['options'][$i]['items'][$k]['optionId']);
									$selecheck[$k] = $selected->product_option_value_id;*/
									$selecheck[$k] = "".$post['options'][$i]['items'][$k]['optionId']."";
								}
								
								$proption[$post['options'][$i]['productOptionId']] = $selecheck;
							}
							elseif($post['options'][$i]['type'] == 2)
							{
								/*$selected = $this->Cart_m->getSelectedOption($post['options'][$i]['productOptionId'],$post['options'][$i]['items'][0]['optionId']);
								$proption[$post['options'][$i]['productOptionId']] = $selected->product_option_value_id;*/
								$proption[$post['options'][$i]['productOptionId']] = $post['options'][$i]['items'][0]['optionId'];
							}
						}
						$proption = json_encode($proption);
					}
					else
					{
						$proption = '[]';
					}

					$cartDetail = $this->Cart_m->get_many_by(array( 'customer_id' => $post['userId'],'product_id'=> $post['productId']));
					
					if(count($cartDetail)>0)
					{
						$newtestt = 0;
						for($k=0;$k<count($cartDetail);$k++)
						{
							$random = $cartDetail[$k]->session_id;
							if($post['action'] == 1)
							{
								$quantity = $cartDetail[$k]->quantity + $post['quantity'];
							}
							elseif($post['action'] == 2)
							{
								$quantity = $cartDetail[$k]->quantity - 1;
							}
							$array1 = "'".$cartDetail[$k]->option."'";
							$newproption = "'".$proption."'";

							$strcmmp = strcmp($array1,$newproption);
							if($strcmmp == '0')
							{
								$newtestt = 1;
								$this->Cart_m->update_by(array('cart_id'=>$cartDetail[$k]->cart_id),array('quantity' => $quantity));
								break;
							}
						}
						if($newtestt == 0)
						{
							$random = $post['sessionId'];
							$this->Cart_m->insert(array('api_id'=>0,'customer_id'=>$post['userId'],'session_id' => $random,'product_id'=>$post['productId'],'recurring_id'=>0,'option'=>$proption,'quantity'=>$post['quantity'],'date_added'=>date('Y-m-d H:i:s')));
						}
					}
					else
					{
						$random = $post['sessionId'];

						if($proption == '""')
						{
							$proption = '[]';
						}

						$this->Cart_m->insert(array('api_id'=>0,'customer_id'=>$post['userId'],'session_id' => $random,'product_id'=>$post['productId'],'recurring_id'=>0,'option'=>$proption,'quantity'=>$post['quantity'],'date_added'=>date('Y-m-d H:i:s')));
					}
				}
				else
				{

					if(count($post['options']) > 0)
					{
						//echo "<pre>";print_r($post['options']);exit();
						for($i=0;$i<count($post['options']);$i++)
						{
							if($post['options'][$i]['type'] == 0)
							{
								/*$selected = $this->Cart_m->getSelectedOption($post['options'][$i]['productOptionId'],$post['options'][$i]['items'][0]['optionId']);
								$proption[$post['options'][$i]['productOptionId']] = $selected->product_option_value_id;*/
								$proption[$post['options'][$i]['productOptionId']] = $post['options'][$i]['items'][0]['optionId'];
							}
							if($post['options'][$i]['type'] == 1)
							{
								for($k=0;$k<count($post['options'][$i]['items']);$k++)
								{
									/*$selected = $this->Cart_m->getSelectedOption($post['options'][$i]['productOptionId'],$post['options'][$i]['items'][$k]['optionId']);
									$selecheck[$k] = $selected->product_option_value_id;*/
									$selecheck[$k] = "".$post['options'][$i]['items'][$k]['optionId']."";
								}
								
								$proption[$post['options'][$i]['productOptionId']] = $selecheck;
							}
							if($post['options'][$i]['type'] == 2)
							{
								/*$selected = $this->Cart_m->getSelectedOption($post['options'][$i]['productOptionId'],$post['options'][$i]['items'][0]['optionId']);
								$proption[$post['options'][$i]['productOptionId']] = $selected->product_option_value_id;*/
								$proption[$post['options'][$i]['productOptionId']] = $post['options'][$i]['items'][0]['optionId'];
							}
						}
						//echo "<pre>";print_r($proption);exit();
						$proption = json_encode($proption);
					}
					else
					{
						$proption = '[]';
					}

					$cartDetail = $this->Cart_m->get_many_by(array( 'customer_id' => $post['userId'],'product_id'=> $post['productId']));
					//echo '<pre>';print_r($cartDetail);exit;
					
					if(count($cartDetail)>0)
					{
						$newtestt = 0;
						for($m=0;$m<count($cartDetail);$m++)
						{
							$array1 = "'".$cartDetail[$m]->option."'";

							$random = $cartDetail[$m]->session_id;
							if($post['action'] == 1)
							{
								$quantity = $cartDetail[$m]->quantity + $post['quantity'];
							}
							elseif($post['action'] == 2)
							{
								$quantity = $cartDetail[$m]->quantity - 1;
							}

							
							$newproption = "'".$proption."'";

							$strcmmp = strcmp($array1,$newproption);
							if($strcmmp == '0')
							{
								$newtestt = 1;
								$this->Cart_m->update_by(array('cart_id'=>$cartDetail[$m]->cart_id),array('quantity' => $quantity));
								break;
							}
							
						}
						if($proption == '')
						{
							$proption = '[]';
						}
						if($newtestt == 0)
						{
							$random = $this->token(26);
							$this->Cart_m->insert(array('api_id'=>0,'session_id' => $random,'customer_id' => $post['userId'],'product_id'=>$post['productId'],'recurring_id'=>0,'option'=>$proption,'quantity'=>$post['quantity'],'date_added'=>date('Y-m-d H:i:s')));
						}
					}
					else
					{
						if(count($post['options'])==0)
						{
							$proption = '[]';
						}
						$random = $this->token(26);
						$this->Cart_m->insert(array('api_id'=>0,'session_id' => $random,'customer_id' => $post['userId'],'product_id'=>$post['productId'],'recurring_id'=>0,'option'=>$proption,'quantity'=>$post['quantity'],'date_added'=>date('Y-m-d H:i:s')));
					}
				}
			}
			elseif($post['sessionId'] != '' && $post['sessionId'] != '0')
			{

				if(count($post['options'])>0)
				{
					for($i=0;$i<count($post['options']);$i++)
					{
						if($post['options'][$i]['type'] == 0)
						{
							/*$selected = $this->Cart_m->getSelectedOption($post['options'][$i]['productOptionId'],$post['options'][$i]['items'][0]['optionId']);
							$proption[$post['options'][$i]['productOptionId']] = $selected->option_value_id;*/
							$proption[$post['options'][$i]['productOptionId']] = $post['options'][$i]['items'][0]['optionId'];
						}
						if($post['options'][$i]['type'] == 1)
						{
							for($k=0;$k<count($post['options'][$i]['items']);$k++)
							{
								/*$selected = $this->Cart_m->getSelectedOption($post['options'][$i]['productOptionId'],$post['options'][$i]['items'][$k]['optionId']);
								$selecheck[$k] = $selected->option_value_id;*/
								$selecheck[$k] = "".$post['options'][$i]['items'][$k]['optionId']."";
							}
							
							$proption[$post['options'][$i]['productOptionId']] = $selecheck;
						}
						if($post['options'][$i]['type'] == 2)
						{
							/*$selected = $this->Cart_m->getSelectedOption($post['options'][$i]['productOptionId'],$post['options'][$i]['items'][0]['optionId']);
							$proption[$post['options'][$i]['productOptionId']] = $selected->option_value_id;*/
							$proption[$post['options'][$i]['productOptionId']] = $post['options'][$i]['items'][0]['optionId'];
						}
					}
					$proption = json_encode($proption);
				}
				else
				{
					$proption = '[]';
				}

				$cartDetail = $this->Cart_m->get_many_by(array('session_id' => $post['sessionId'],'product_id'=> $post['productId']));

				if(count($cartDetail)>0)
				{
					$newtestt = 0;
					for($m=0;$m<count($cartDetail);$m++)
					{
						$random = $cartDetail[$m]->session_id;
						
						if($post['action'] == 1)
						{
							$quantity = $cartDetail[$m]->quantity + $post['quantity'];
						}
						elseif($post['action'] == 2)
						{
							$quantity = $cartDetail[$m]->quantity - 1;
						}
						$array1 = "'".$cartDetail[$m]->option."'";
						$newproption = "'".$proption."'";

						$strcmmp = strcmp($array1,$newproption);
						if($strcmmp == '0')
						{
							$newtestt = 1;
							$this->Cart_m->update_by(array('cart_id'=>$cartDetail[$m]->cart_id),array('quantity' => $quantity));
							break;
						}
					}
					if($newtestt == 0)
					{
						$random = $post['sessionId'];
						$this->Cart_m->insert(array('api_id'=>0,'session_id' => $random,'product_id'=>$post['productId'],'recurring_id'=>0,'option'=>$proption,'quantity'=>$post['quantity'],'date_added'=>date('Y-m-d H:i:s')));
					}
				}
				else
				{
					$random = $post['sessionId'];

					//$minimumQty = $this->Products_m->getMinQty($post['productId']);
					$this->Cart_m->insert(array('api_id'=>0,'session_id' => $random,'product_id'=>$post['productId'],'recurring_id'=>0,'option'=>$proption,'quantity'=>$post['quantity'],'date_added'=>date('Y-m-d H:i:s')));
				}
			}
			else
			{
				$random = $this->token(26);
				$proption = '';
				for($i=0;$i<count($post['options']);$i++)
				{
					if($post['options'][$i]['type'] == 0)
					{
						//$selected = $this->Cart_m->getSelectedOption($post['options'][$i]['productOptionId'],$post['options'][$i]['items'][0]['optionId']);
						//$proption[$post['options'][$i]['productOptionId']] = $selected->product_option_value_id;
						$proption[$post['options'][$i]['productOptionId']] = $post['options'][$i]['items'][0]['optionId'];
					}
					if($post['options'][$i]['type'] == 1)
					{
						for($k=0;$k<count($post['options'][$i]['items']);$k++)
						{
							//$selected = $this->Cart_m->getSelectedOption($post['options'][$i]['productOptionId'],$post['options'][$i]['items'][$k]['optionId']);
							//$selecheck[$k] = $selected->product_option_value_id;
							$selecheck[$k] = "".$post['options'][$i]['items'][$k]['optionId']."";
						}
						
						$proption[$post['options'][$i]['productOptionId']] = $selecheck;
					}
					if($post['options'][$i]['type'] == 2)
					{
						//$selected = $this->Cart_m->getSelectedOption($post['options'][$i]['productOptionId'],$post['options'][$i]['items'][0]['optionId']);
						//$proption[$post['options'][$i]['productOptionId']] = $selected->product_option_value_id;
						$proption[$post['options'][$i]['productOptionId']] = $post['options'][$i]['items'][0]['optionId'];
					}
				}
				$proption = json_encode($proption);
				
				if($proption == '""')
				{
					$proption = '[]';
				}
				
				//$minimumQty = $this->Products_m->getMinQty($post['productId']);
				$this->Cart_m->insert(array('api_id'=>0,'session_id' => $random,'product_id'=>$post['productId'],'recurring_id'=>0,'option'=>$proption,'quantity'=>$post['quantity'],'date_added'=>date('Y-m-d H:i:s')));
			}

			$wherecon = "key ='config_currency'";
			$settings = $this->Setting_m->get_by($wherecon);
			

			$currencydetail = $this->Currency_m->get_by(array('code'=>$settings->value,'status'=>1));

			if($post['userId'] != '' && $post['userId'] != '0')
			{
				$finalCart = $this->Cart_m->get_many_by(array( 'customer_id' => $post['userId']));
			}
			elseif($post['sessionId'] != '' && $post['sessionId'] != '0')
			{
				$finalCart = $this->Cart_m->get_many_by(array( 'session_id' => $post['sessionId']));
			}
			else
			{
				$finalCart = $this->Cart_m->get_many_by(array( 'session_id' => $random));
			}

			$total = 0;
			$mainProdArr = array();
			$quantityTotal = 0;
			for($i=0;$i<count($finalCart);$i++)
			{
				$productDetail = $this->Products_m->get_by(array('product_id'=>$finalCart[$i]->product_id));
				//$sum = $productDetail->price * $finalCart[$i]->quantity;
				$quantityTotal = $quantityTotal + $finalCart[$i]->quantity;
				//$productPriceF  = $this->Products_m->getProductPrice($finalCart[$i]->product_id);
				$productPriceF  = $this->Products_m->getProductPrice($finalCart[$i]->product_id, $post['userId']);

				$productPrice = $productPriceF->price;

				$innerarr = array();
				if($productDetail != '')
				{				
					if($_SERVER['HTTP_HOST'] == '192.168.1.101')
					{
						$server = $_SERVER['HTTP_HOST'].'/opencart';
					}
					else
					{
						$server = $_SERVER['HTTP_HOST'];
					}	
					$innerarr['referenceId'] = $finalCart[$i]->cart_id;
					$innerarr['productId'] = $finalCart[$i]->product_id;

					

					$productName = $this->Products_m->getProductName($finalCart[$i]->product_id,$language);
					$innerarr['name'] = $productName->name;
					
					$innerarr['quantity'] = $finalCart[$i]->quantity;
					$innerarr['currencyCode'] = $currencydetail->symbol_left;
					
					$innerarr['minQuantity'] = $productDetail->minimum;
					$innerarr['minQuantityDesc'] = "This product has a minimum quantity of ".$productDetail->minimum;

					$productReward = $this->Products_m->getProductReward($finalCart[$i]->product_id);
					$innerarr['rewardPoints'] = $productReward->points;
					if($productDetail->image == '')
					{
						$innerarr['thumbImage'] =  "";
					}
					else
					{
						$innerarr['thumbImage'] = (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $server.'/image/'.$productDetail->image;
					}

					$mainoptionarr = array();
					$data = json_decode($finalCart[$i]->option);
					//echo "<pre>";;print_r($data);
					if(isset($data))
					{
						
						foreach($data as $key=>$value) 
						{
							
							if(is_array($value) && $key!=_empty_)
							{	

								$inneroparr = array();
								$inneritemarrmultiple = array();

								for($z=0;$z<count($value);$z++)
								{
									if($value[$z]!=''){
									$result = $this->Cart_m->getCartOptionDetail($key,$value[$z]);
									//echo '<pre>';print_r($result);exit;
									if($result->type == 'checkbox')
									{
										if($z == 0)
										{
											$optype = '1';
											$inneroparr['productOptionId'] = $key;
											$inneroparr['isMandatory'] = $result->required;
											$inneroparr['type'] = $optype;
											$inneroparr['title'] = html_entity_decode($result->optionname);
										}
											$inneritemarr = array();
											$inneritemarr['optionId'] =$value[$z];
											//$inneritemarr['value'] = $result->optionvalname." (".$result->price_prefix.'$'.number_format((float)$result->price, 2, '.', '').")";
											$inneritemarr['value'] = $result->optionvalname;
											$productPrice = $productPrice + $result->price;
											$inneritemarrmultiple[] = $inneritemarr;
										
									}
									}
								}
								$inneroparr['items'] = $inneritemarrmultiple;
								$mainoptionarr[] = $inneroparr;
							}
							else
							{
								
								if($value!='' && $key!=_empty_){

									$inneroparr = array();
								$result = $this->Cart_m->getCartOptionDetail($key,$value);
								//echo '<pre>';print_($result);exit;
								if($result->type == 'radio' || $result->type == 'select')
								{
									if($result->type == 'radio')
									{
										$optype = '0';
									}
									elseif($result->type == 'select')
									{
										$optype = '2';
									}
									$inneroparr['productOptionId'] = $key;
									$inneroparr['isMandatory'] = $result->required;
									$inneroparr['type'] = $optype;
									$inneroparr['title'] = html_entity_decode($result->optionname);
										$inneritemarr = array();
										$inneritemarr['optionId'] = $value;
										//$inneritemarr['value'] = $result->optionvalname." (".$result->price_prefix.'$'.number_format((float)$result->price, 2, '.', '').")";
										$inneritemarr['value'] = $result->optionvalname;
									$inneroparr['items'][] = $inneritemarr;
									$productPrice = $productPrice + $result->price;
								}
									$mainoptionarr[] = $inneroparr;
								}
							}
							//echo '<pre>';print_r($inneroparr);exit;
							
						} 
					}
					

					$sum = $productPrice * $finalCart[$i]->quantity;
					$total = $total + $sum;

					$innerarr['total'] = number_format((float)$sum, 2, '.', '');
					$innerarr['price'] = number_format((float)$productPrice, 2, '.', '');
					$innerarr['options']=$mainoptionarr;
				}
				$mainProdArr[] = $innerarr;
			}

			$where = " key ='shipping_flat_cost'";
			$settings = $this->Setting_m->get_by($where);
			
			$shipping = number_format((float)$settings->value, 2, '.', '');
			$total = number_format((float)$total, 2, '.', '');
			$netTotal =  $shipping + $total;
			$netTotal = number_format((float)$netTotal, 2, '.', '');

			$response['success'] = 1;
			$response['message'] = $this->lang->line("Cart updated successfully");
			$response['sessionId'] = (string)$random;
			$response['quantity'] = (string)$quantityTotal;
			$response['totalItem'] = (string)count($finalCart);
			$response['subTotal'] = (string)$total;
			$response['total'] = (string)$netTotal;
			$response['currencyCode'] = $currencydetail->symbol_left;
			$response['shippingCharge'] = $shipping;
			$response['products'] = $mainProdArr;
			echo json_encode($response);exit;
		}
		catch(Exception $e)
		{
			$response = array();
			$response['success'] = 0;
			$response['message'] = $e->getMessage();
			echo json_encode($response);exit;
		}	
	}

	public function getCart()
	{
		$input = file_get_contents('php://input');
		$post = json_decode($input, true);

		// {"userId":"4","coupanCode":"10DISC","device": "1","sessionId":"adasdasdf123456","languageCode" : "en" }

		try
		{
			if((!isset($post['userId'])) || (!isset($post['languageCode'])) || (!isset($post['sessionId'])))
			{
				throw new Exception("Please fill in all the required fields.");
			}

			if($post['languageCode'] == '' || $post['languageCode'] == '0')
			{
				throw new Exception("Error in post data.");
			}
			$temp = 0;
			if($post['userId'] != '' && $post['userId'] != '0')
			{
				$temp = 1;
				$finalCart = $this->Cart_m->get_many_by(array( 'customer_id' => $post['userId']));
			}
			elseif($post['sessionId'] != '' && $post['sessionId'] != '0')
			{
				$temp = 1;
				$finalCart = $this->Cart_m->get_many_by(array( 'session_id' => $post['sessionId']));
			}
			//echo '<pre>';print_r($finalCart);exit;
			
			if($temp == 0)
			{
				throw new Exception("Error in post data.");
			}

			$wherecon = "key ='config_currency'";
			$settings = $this->Setting_m->get_by($wherecon);
			

			$currencydetail = $this->Currency_m->get_by(array('code'=>$settings->value,'status'=>1));

			$total = 0;
			$sum = 0;
			$mainProdArr = array();
			$quantityTotal = 0;
		
			if(count($finalCart)>0)
			{
				for($i=0;$i<count($finalCart);$i++)
				{
					$productDetail = $this->Products_m->get_by(array('product_id'=>$finalCart[$i]->product_id));
					
					//$productPriceF  = $this->Products_m->getProductPrice($finalCart[$i]->product_id);
					$productPriceF  = $this->Products_m->getProductPrice($finalCart[$i]->product_id, $post['userId']);

					$productPrice = $productPriceF->price;
					$quantityTotal = $quantityTotal + $finalCart[$i]->quantity;
					$random = $finalCart[$i]->session_id;
					$innerarr = array();
					if($productDetail != '')
					{				
						if($_SERVER['HTTP_HOST'] == '192.168.1.101')
						{
							$server = $_SERVER['HTTP_HOST'].'/opencart';
						}
						else
						{
							$server = $_SERVER['HTTP_HOST'];
						}	
						$innerarr['referenceId'] = $finalCart[$i]->cart_id;
						$innerarr['productId'] = $finalCart[$i]->product_id;

						if($post['languageCode'] == 'en'){
				$language = $this->Language_m->get_by(array('name'=>'English'));
				$this->lang->load('Webservice', 'english');
			}
			elseif($post['languageCode'] == 'ar'){
				$language = $this->Language_m->get_by(array('name'=>'Arabic'));
			}
			elseif($post['languageCode'] == 'es'){
						$language = $this->Language_m->get_by(array('code'=>'es-es'));
					$this->lang->load('Webservice', 'spanish');
				}
			elseif($post['languageCode'] == 'ru'){
						$language = $this->Language_m->get_by(array('code'=>'ru-ru'));
					$this->lang->load('Webservice', 'russian');
				}

						if($language == '')
							$language = 1;
						else
							$language = $language->language_id;

						$productName = $this->Products_m->getProductName($finalCart[$i]->product_id,$language);
						$productReward = $this->Products_m->getProductReward($finalCart[$i]->product_id);
						$productCategory = $this->Categories_products_m->get_by(array('product_id'=>$finalCart[$i]->product_id));
						
						if($productCategory != '')
						{
							$categoryDetail = $this->Categories_m->getCategoryDetail($productCategory->category_id,$language);
							
							$innerarr['category'] = $categoryDetail->name;
						}
						else
						{
							$innerarr['category'] = '';
						}

						//echo '<pre>';print_r($category);exit;
						$innerarr['name'] = $productName->name;
						
						$innerarr['quantity'] = $finalCart[$i]->quantity;
						$innerarr['currencyCode'] = $currencydetail->symbol_left;
						$innerarr['rewardPoints'] = $productReward->points;
						$innerarr['minQuantity'] = $productDetail->minimum;
						$innerarr['model'] = $productDetail->model;
						$innerarr['minQuantityDesc'] = "This product has a minimum quantity of ".$productDetail->minimum;
						//$innerarr['category'] = $category;
						if($productDetail->image == '')
						{
							$innerarr['thumbImage'] =  "";
						}
						else
						{
							$innerarr['thumbImage'] = (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $server.'/image/'.$productDetail->image;
						}

						$mainoptionarr = array();
						$data = json_decode($finalCart[$i]->option);

						//echo '<pre>';print_r($data);exit;
						foreach($data as $key=>$value) 
						{
							
							if(is_array($value) && $key!=_empty_)
							{	
								
								$inneroparr = array();
								$inneritemarrmultiple = array();
								for($z=0;$z<count($value);$z++)
								{
									$result = $this->Cart_m->getCartOptionDetail($key,$value[$z]);
									
									if($result->type == 'checkbox')
									{
										if($z == 0)
										{
											$optype = '1';
											$inneroparr['productOptionId'] = $key;
											$inneroparr['isMandatory'] = $result->required;
											$inneroparr['type'] = $optype;
											$inneroparr['title'] = html_entity_decode($result->optionname);
										}
											$inneritemarr = array();
											//$selected = $this->Cart_m->getRevSelectedOption($key,$value[$z]);
											//$inneritemarr['optionId'] =$selected->option_value_id;
											$inneritemarr['optionId'] = $value[$z];
											$inneritemarr['value'] = $result->optionvalname;
										$inneritemarrmultiple[] = $inneritemarr;
										$productPrice = $productPrice + $result->price;
										
									}
								}
								$inneroparr['items'] = $inneritemarrmultiple;
								$mainoptionarr[] = $inneroparr;
							}
							else
							{
                                if($value!='' && $key!=_empty_){
                                	$inneroparr = array();
								$result = $this->Cart_m->getCartOptionDetail($key,$value);
                             
								if($result->type == 'radio' || $result->type == 'select')
								{
									if($result->type == 'radio')
									{
										$optype = '0';
									}
									elseif($result->type == 'select')
									{
										$optype = '2';
									}
									$inneroparr['productOptionId'] = $key;
									$inneroparr['isMandatory'] = $result->required;
									$inneroparr['type'] = $optype;
									$inneroparr['title'] = html_entity_decode($result->optionname);
									$inneritemarr = array();
									$inneritemarr['optionId'] = $value;
									//$selected = $this->Cart_m->getRevSelectedOption($key,$value);
									//$inneritemarr['optionId'] =$selected->option_value_id;
									$inneritemarr['value'] = $result->optionvalname;
									$inneroparr['items'][] = $inneritemarr;
									$productPrice = $productPrice + $result->price;
								}
								$mainoptionarr[] = $inneroparr;
								}
							}
							
						}
					
						$innerarr['price'] = number_format((float)$productPrice, 2, '.', '');
						$innerarr['originalPrice'] = number_format((float)$productPrice, 2, '.', '');
						$sum = $productPrice * $finalCart[$i]->quantity;
						$total = $total + $sum;
						$innerarr['total'] = number_format((float)$sum, 2, '.', '');
					
						$innerarr['options']=$mainoptionarr;
					
					}
					$mainProdArr[] = $innerarr;
				}

				$where = " key ='shipping_flat_cost'";
				$settings = $this->Setting_m->get_by($where);

				$shipping = number_format((float)$settings->value, 2, '.', '');
				$total = number_format((float)$total, 2, '.', '');
				if($total != 0)
				{
					$netTotal =  $shipping + $total;
					$netTotal = number_format((float)$netTotal, 2, '.', '');
				}
				else
				{
					$netTotal = 0.00;
				}

			 
				$response['success'] = 1;
				$response['sessionId'] = (string)$random;
				$response['quantity'] = (string)$quantityTotal;
				$response['totalItem'] = (string)count($finalCart);
				$response['subTotal'] = (string)$total;
				$response['total'] = (string)$netTotal;
				$response['currencyCode'] = $currencydetail->symbol_left;
				$response['shippingCharge'] = (string)$shipping;
				$response['products'] = $mainProdArr;
				echo json_encode($response);exit;
			}
			else
			{
				$response['success'] = 0;
				$response['message'] = $this->lang->line("No Product Available in your cart.");
				echo json_encode($response);exit;
			}

		}	
		catch(Exception $e)
		{
			$response = array();
			$response['success'] = 0;
			$response['message'] = $e->getMessage();
			echo json_encode($response);exit;
		}	
	}

	public function deleteProduct()
	{
		$input = file_get_contents('php://input');
		$post = json_decode($input, true);

		//Local
		// { "userId":"3","device": "1","sessionId":"adasdasdf123456","languageCode" : "en","productId" : "123","referenceId":"2"}
		//Live
		// { "userId":"44","device": "1","sessionId":"adasdasdf123456","languageCode" : "en","productId" : "42","referenceId":"2"}

		try
		{
			if((!isset($post['productId'])) || (!isset($post['userId'])) || (!isset($post['languageCode'])) || (!isset($post['sessionId'])) || (!isset($post['referenceId'])))
			{
				throw new Exception("Please fill in all the required fields.");
			}

			if($post['productId'] == '' || $post['productId'] == '0' ||  $post['languageCode'] == '' || $post['languageCode'] == '0' ||  $post['referenceId'] == '' || $post['referenceId'] == '0')
			{
				throw new Exception("Error in post data.");
			}

			$temp = 0;
			if($post['userId'] != '' || $post['userId'] != '0')
			{
				$temp = 1;
				$this->Cart_m->delete_by(array( 'customer_id' => $post['userId'],'product_id'=>$post['productId'],'cart_id'=>$post['referenceId']));
			}
			elseif($post['sessionId'] != '' || $post['sessionId'] != '0')
			{
				$temp = 1;
				$this->Cart_m->delete_by(array( 'session_id' => $post['sessionId'],'product_id'=>$post['productId'],'cart_id'=>$post['referenceId']));
			}

			if($temp == 0)
			{
				throw new Exception("Error in post data.");
			}


			if($post['userId'] != '' || $post['userId'] != '0')
			{
				$temp = 1;
				$finalCart = $this->Cart_m->get_many_by(array( 'customer_id' => $post['userId']));
			}
			elseif($post['sessionId'] != '' || $post['sessionId'] != '0')
			{
				$temp = 1;
				$finalCart = $this->Cart_m->get_many_by(array( 'session_id' => $post['sessionId']));
			}

			$wherecon = "key ='config_currency'";
			$settings = $this->Setting_m->get_by($wherecon);
			

			$currencydetail = $this->Currency_m->get_by(array('code'=>$settings->value,'status'=>1));

			$total = 0;
			$mainProdArr = array();
			$quantityTotal = 0;
			for($i=0;$i<count($finalCart);$i++)
			{
				
				$productDetail = $this->Products_m->get_by(array('product_id'=>$finalCart[$i]->product_id));
				//$productPriceF  = $this->Products_m->getProductPrice($finalCart[$i]->product_id);
				$productPriceF  = $this->Products_m->getProductPrice($finalCart[$i]->product_id, $post['userId']);

				$productPrice = $productPriceF->price;
				//$sum = $productDetail->price * $finalCart[$i]->quantity;
				$quantityTotal = $quantityTotal + $finalCart[$i]->quantity;
				//$total = $total + $sum;


				$innerarr = array();
				if($productDetail != '')
				{				
					if($_SERVER['HTTP_HOST'] == '192.168.1.101')
					{
						$server = $_SERVER['HTTP_HOST'].'/opencart';
					}
					else
					{
						$server = $_SERVER['HTTP_HOST'];
					}	
					$innerarr['referenceId'] = $finalCart[$i]->cart_id;
					$innerarr['productId'] = $finalCart[$i]->product_id;

					if($post['languageCode'] == 'en'){
				$language = $this->Language_m->get_by(array('name'=>'English'));
				$this->lang->load('Webservice', 'english');
			}
			elseif($post['languageCode'] == 'ar'){
				$language = $this->Language_m->get_by(array('name'=>'Arabic'));
			}
			elseif($post['languageCode'] == 'es'){
						$language = $this->Language_m->get_by(array('code'=>'es-es'));
					$this->lang->load('Webservice', 'spanish');
				}
			elseif($post['languageCode'] == 'ru'){
						$language = $this->Language_m->get_by(array('code'=>'ru-ru'));
					$this->lang->load('Webservice', 'russian');
				}

					if($language == '')
						$language = 1;
					else
						$language = $language->language_id;

					$productName = $this->Products_m->getProductName($finalCart[$i]->product_id,$language);
					$innerarr['name'] = $productName->name;
					
					$innerarr['quantity'] = $finalCart[$i]->quantity;
					$innerarr['currencyCode'] = $currencydetail->symbol_left;
					
					$innerarr['minQuantity'] = $productDetail->minimum;
					$innerarr['minQuantityDesc'] = "This product has a minimum quantity of ".$productDetail->minimum;
					$productReward = $this->Products_m->getProductReward($finalCart[$i]->product_id);
					$innerarr['rewardPoints'] = $productReward->points;
					if($productDetail->image == '')
					{
						$innerarr['thumbImage'] =  "";
					}
					else
					{
						$innerarr['thumbImage'] = (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $server.'/image/'.$productDetail->image;
					}

					$mainoptionarr = array();
					$data = json_decode($finalCart[$i]->option);
					
					foreach($data as $key=>$value) 
					{
						$inneroparr = array();
						if(is_array($value) && $key!=_empty_)
						{	
							$inneritemarrmultiple = array();
							for($z=0;$z<count($value);$z++)
							{
								$result = $this->Cart_m->getCartOptionDetail($key,$value[$z]);
								
								if($result->type == 'checkbox')
								{
									if($z == 0)
									{
										$optype = '1';
										$inneroparr['productOptionId'] = $key;
										$inneroparr['isMandatory'] = $result->required;
										$inneroparr['type'] = $optype;
										$inneroparr['title'] = html_entity_decode($result->optionname);
									}
										$inneritemarr = array();
										$inneritemarr['optionId'] =$value[$z];
										//$inneritemarr['value'] = $result->optionvalname." (".$result->price_prefix.'$'.number_format((float)$result->price, 2, '.', '').")";
										$inneritemarr['value'] = $result->optionvalname;

										$inneritemarrmultiple[] = $inneritemarr;	
										$productPrice = $productPrice + $result->price;	
								}
							}
							$inneroparr['items'] = $inneritemarrmultiple;
						}
						else
						{
							if($value!='' && $key!=_empty_){
							$result = $this->Cart_m->getCartOptionDetail($key,$value);
							//echo '<pre>';print_($result);exit;
							if($result->type == 'radio' || $result->type == 'select')
							{
								if($result->type == 'radio')
								{
									$optype = '0';
								}
								elseif($result->type == 'select')
								{
									$optype = '2';
								}
								$inneroparr['productOptionId'] = $key;
								$inneroparr['isMandatory'] = $result->required;
								$inneroparr['type'] = $optype;
								$inneroparr['title'] = html_entity_decode($result->optionname);
									$inneritemarr = array();
									$inneritemarr['optionId'] = $value;
								
									$inneritemarr['value'] = $result->optionvalname;
								$inneroparr['items'][] = $inneritemarr;
								$productPrice = $productPrice + $result->price;
							}
							}
						}
						//echo '<pre>';print_r($inneroparr);exit;
						$mainoptionarr[] = $inneroparr;
					}
					$innerarr['price'] = number_format((float)$productPrice, 2, '.', '');
					$innerarr['options']=$mainoptionarr;
					$sum = $productPrice * $finalCart[$i]->quantity;
					$innerarr['total'] = number_format((float)$sum, 2, '.', '');
					$total = $total + $sum;
				}
				$mainProdArr[] = $innerarr;
			}

			$where = " key ='shipping_flat_cost'";
			$settings = $this->Setting_m->get_by($where);

			$shipping = number_format((float)$settings->value, 2, '.', '');
			$total = number_format((float)$total, 2, '.', '');
			$netTotal =  $shipping + $total;
			$netTotal = number_format((float)$netTotal, 2, '.', '');
	
			$response['success'] = 1;
			$response['message'] = $this->lang->line('Product removed successfully from your cart.');
			$response['sessionId'] = $post['sessionId'];
			$response['quantity'] = (string)$quantityTotal;
			if($quantityTotal!=0){
			$response['totalItem'] = (string)count($finalCart);
			$response['subTotal'] = (string)$total;
			$response['total'] = (string)$netTotal;
			$response['shippingCharge'] = $shipping;
			} else{
			$response['totalItem'] = "0.00";
			$response['subTotal'] = '0.00';
			$response['total'] = '0.00';
			$response['shippingCharge'] = '0.0';
			}
			$response['currencyCode'] = $currencydetail->symbol_left;
			
			$response['products'] = $mainProdArr;
			echo json_encode($response);exit;
		}
		catch(Exception $e)
		{
			$response = array();
			$response['success'] = 0;
			$response['message'] = $e->getMessage();
			echo json_encode($response);exit;
		}	
	}

	public function myOrders()
	{
		$input = file_get_contents('php://input');
		$post = json_decode($input, true);

		//Local
		//{ "userId":"3","device": "1","languageCode" : "ar","offset" : "0"}
		//Live
		//{ "userId":"44","device": "1","languageCode" : "ar","offset" : "0"}
		try
		{
			if((!isset($post['userId'])) || (!isset($post['offset'])) || (!isset($post['languageCode'])))
			{
				throw new Exception("Please fill in all the required fields.");
			}

			if($post['userId'] == '' || $post['userId'] == '0' || $post['offset'] == '' || $post['languageCode'] == '0' || $post['languageCode'] == '')
			{
				throw new Exception("Error in post data.");
			}

			$where = " customer_id ='".$post['userId']."' ORDER BY order_id DESC LIMIT ".$post['offset'].",10";
			$orderList = $this->Order_m->get_many_by($where);

			$totalOrder = $this->Order_m->count_by(array('customer_id'=>$post['userId']));


			if(count($orderList)>0)
			{
				$result = array();
				for($i=0;$i<count($orderList);$i++)
				{
					$innerOrder = array();
					$innerOrder['orderNo'] = $orderList[$i]->order_id;
					$innerOrder['totalPrice'] = number_format((float)$orderList[$i]->total, 2, '.', '');
					$innerOrder['invoice'] = $orderList[$i]->invoice_prefix.$orderList[$i]->invoice_no;

					$orderProducts = $this->Order_product_m->get_many_by(array('order_id'=>$orderList[$i]->order_id));
					
					$quantity = 0;
					for($k=0;$k<count($orderProducts);$k++)
					{
						$quantity = $quanity + $orderProducts[$k]->quantity;
					}

					$innerOrder['quantity'] = (string)$quantity;
					$innerOrder['statusId'] = (string)$orderList[$i]->order_status_id;


					if($post['languageCode'] == 'en'){
				$language = $this->Language_m->get_by(array('name'=>'English'));
				$this->lang->load('Webservice', 'english');
			}
			elseif($post['languageCode'] == 'ar'){
				$language = $this->Language_m->get_by(array('name'=>'Arabic'));
			}
			elseif($post['languageCode'] == 'es'){
						$language = $this->Language_m->get_by(array('code'=>'es-es'));
					$this->lang->load('Webservice', 'spanish');
				}
			elseif($post['languageCode'] == 'ru'){
						$language = $this->Language_m->get_by(array('code'=>'ru-ru'));
					$this->lang->load('Webservice', 'russian');
				}

					if($language == '')
						$language = 1;
					else
						$language = $language->language_id;

					$orderStatus = $this->Order_status_m->get_by(array('order_status_id'=>$orderList[$i]->order_status_id,'language_id'=>$language));
					$innerOrder['statusName'] = (string)$orderStatus->name;

					
						if($orderList[$i]->order_status_id == '1')
						{
							$innerOrder['statusText'] = $this->lang->line("Placed on");
							$innerOrder['statusColor'] = "#D3D3D3";
						}
						elseif($orderList[$i]->order_status_id == '2')
						{
							$innerOrder['statusText'] = $this->lang->line("Processed on");
							$innerOrder['statusColor'] = "#FFA500";
						}
						elseif($orderList[$i]->order_status_id == '3')
						{
							$innerOrder['statusText'] = $this->lang->line("Shipped on");
							$innerOrder['statusColor'] = "#ADD8E6";
						}
						elseif($orderList[$i]->order_status_id == '5')
						{
							$innerOrder['statusText'] = $this->lang->line("Delivered on");
							$innerOrder['statusColor'] = "#008000";
						}
						elseif($orderList[$i]->order_status_id == '7')
						{
							$innerOrder['statusText'] = $this->lang->line("Cancelled on");
							$innerOrder['statusColor'] = "#FF0000";
						}
						elseif($orderList[$i]->order_status_id == '8')
						{
							$innerOrder['statusText'] = $this->lang->line("Denied on");
							$innerOrder['statusColor'] = "#FF0000";
						}
						elseif($orderList[$i]->order_status_id == '9')
						{
							$innerOrder['statusText'] = $this->lang->line("Cancelled reversal on");
							$innerOrder['statusColor'] = "#FF0000";
						}
						elseif($orderList[$i]->order_status_id == '10')
						{
							$innerOrder['statusText'] = $this->lang->line("Failed on");
							$innerOrder['statusColor'] = "#FF0000";
						}
						elseif($orderList[$i]->order_status_id == '11')
						{
							$innerOrder['statusText'] = $this->lang->line("Refunded on");
							$innerOrder['statusColor'] = "#197BB0";
						}
					
					
					

					$orderHistory = $this->Order_history_m->get_by(array('order_id'=>$orderList[$i]->order_id,'order_status_id'=>$orderList[$i]->order_status_id));
					$innerOrder['statusDate'] = (string)strtotime($orderHistory->date_added);
					$innerOrder['orderDate'] = (string)strtotime($orderList[$i]->date_added);
					$result[] = $innerOrder;
				}	

				$response = array();
				$response['success'] = 1;
				$response['total'] = $totalOrder;
				$response['result'] = $result;
				echo json_encode($response);exit;
			}
			else
			{
				$response = array();
				$response['success'] = 0;
				$response['message'] = $this->lang->line('No Order Available');
				echo json_encode($response);exit;
			}

			
		}
		catch(Exception $e)
		{
			$response = array();
			$response['success'] = 0;
			$response['message'] = $e->getMessage();
			echo json_encode($response);exit;
		}

	}

	public function readNotification()
	{
		$input = file_get_contents('php://input');
		$post = json_decode($input, true);

		//{"notificationId":"1","userId":"3"}

		try
		{
			if((!isset($post['notificationId'])) || (!isset($post['userId'])))
			{
				throw new Exception("Please fill in all the required fields.");
			}

			if($post['notificationId'] == '' || $post['notificationId'] == '0' || $post['userId'] == '' || $post['userId'] == '0')
			{
				throw new Exception("Error in post data.");
			}

			$this->Order_history_m->update_by(array('order_history_id'=>$post['notificationId']),array('status'=>1));

			$badgeCount= $this->getUnreadCount($post['userId']);

			$response = array();
			$response['success'] = 1;
			$response['message'] = 'Notification read successfully.';
			$response['badgeCount'] = (string)$badgeCount;
			echo json_encode($response);exit;	
		}
		catch(Exception $e)
		{
			$response = array();
			$response['success'] = 0;
			$response['message'] = $e->getMessage();
			echo json_encode($response);exit;
		}
	}

	public function getUnreadCount($userid)
	{
		$userdetail = $this->Customers_m->get_by(array('customer_id'=>$userid));

		return $totalOrderHistory = $this->Order_history_m->count_by(array('user_name'=>$userdetail->email,'status'=>0));
	}

	public function getNotifications()
	{
		$input = file_get_contents('php://input');
		$post = json_decode($input, true);

		//Local
		//{"device": "1","userId": "3", "offset" : "0","languageCode" : "en"}
		//Live
		//{"device": "1","userId": "44", "offset" : "0","languageCode" : "en"}

		try
		{
			if((!isset($post['userId'])) || (!isset($post['offset'])) || (!isset($post['languageCode'])))
			{
				throw new Exception("Please fill in all the required fields.");
			}

			if($post['userId'] == '' || $post['userId'] == '0' || $post['languageCode'] == '' || $post['languageCode'] == '0' ||  $post['offset'] == '')
			{
				throw new Exception("Error in post data.");
			}

			$orderList = $this->Order_m->get_many_by(array('customer_id'=>$post['userId']));

			if(count($orderList) == 0)
		    {
		        throw new Exception("No notifications available.");
		    }
			$orderlistarr = array();
			for($i=0;$i<count($orderList);$i++)
			{
				$orderlistarr[] = $orderList[$i]->order_id; 
			}
			$orderListstr = implode(",",$orderlistarr);


			$sql = "SELECT * from oc_order_history where order_id IN (".$orderListstr.") AND status=0 ORDER BY order_history_id DESC LIMIT ".$post['offset']." , 10";
			$query = $this->db->query($sql);
			$orderHistory = $query->result();
			
			
			//echo '<pre>';print_r($orderHistory);exit;
			
			$where = " order_id IN (".$orderListstr.") AND status =0";
			$totalOrderHistory = $this->Order_history_m->count_by($where);

			if(count($orderHistory)>0)
			{
				$results = array();
				for($i=0;$i<count($orderHistory);$i++)
				{
					$innerarr = array();
					
					$innerarr['notificationId'] = $orderHistory[$i]->order_history_id;
					$innerarr['orderNo'] = $orderHistory[$i]->order_id;

					if($post['languageCode'] == 'en'){
				$language = $this->Language_m->get_by(array('name'=>'English'));
				$this->lang->load('Webservice', 'english');
			}
			elseif($post['languageCode'] == 'ar'){
				$language = $this->Language_m->get_by(array('name'=>'Arabic'));
			}
			elseif($post['languageCode'] == 'es'){
						$language = $this->Language_m->get_by(array('code'=>'es-es'));
					$this->lang->load('Webservice', 'spanish');
				}
			elseif($post['languageCode'] == 'ru'){
						$language = $this->Language_m->get_by(array('code'=>'ru-ru'));
					$this->lang->load('Webservice', 'russian');
				}

					if($language == '')
						$language = 1;
					else
						$language = $language->language_id;

					$orderStatus = $this->Order_status_m->get_by(array('order_status_id'=>$orderHistory[$i]->order_status_id ,'language_id'=>$language));
					$innerarr['statusName'] = (string)$orderStatus->name;

					if($post['languageCode'] == 'en')
					{
						if($orderHistory[$i]->order_status_id == '1')
						{
							$innerarr['statusColor'] = "#D3D3D3";
						}
						elseif($orderHistory[$i]->order_status_id == '2')
						{
							
							$innerarr['statusColor'] = "#FFA500";
						}
						elseif($orderHistory[$i]->order_status_id == '3')
						{
							$innerarr['statusColor'] = "#ADD8E6";
						}
						elseif($orderHistory[$i]->order_status_id == '5')
						{
							$innerarr['statusColor'] = "#008000";
						}
						elseif($orderHistory[$i]->order_status_id == '7')
						{
							$innerarr['statusColor'] = "#FF0000";
						}
						elseif($orderHistory[$i]->order_status_id == '8')
						{
							$innerarr['statusColor'] = "#FF0000";
						}
						elseif($orderHistory[$i]->order_status_id == '9')
						{
							$innerarr['statusColor'] = "#FF0000";
						}
						elseif($orderHistory[$i]->order_status_id == '10')
						{
							$innerarr['statusColor'] = "#FF0000";
						}
						elseif($orderHistory[$i]->order_status_id == '11')
						{
							$innerarr['statusColor'] = "#197BB0";
						}
					}
					elseif($post['languageCode'] == 'ar')
					{
						if($orderHistory[$i]->order_status_id == '1')
						{
							$innerarr['statusColor'] = "#D3D3D3";
						}
						elseif($orderHistory[$i]->order_status_id == '2')
						{
							$innerarr['statusColor'] = "#FFA500";
						}
						elseif($orderHistory[$i]->order_status_id == '3')
						{
							$innerarr['statusColor'] = "#ADD8E6";
						}
						elseif($orderHistory[$i]->order_status_id == '5')
						{
							$innerarr['statusColor'] = "#008000";
						}
						elseif($orderHistory[$i]->order_status_id == '7')
						{
							$innerarr['statusColor'] = "#FF0000";
						}
						elseif($orderHistory[$i]->order_status_id == '8')
						{
							$innerarr['statusColor'] = "#FF0000";
						}
						elseif($orderHistory[$i]->order_status_id == '9')
						{
							$innerarr['statusColor'] = "#FF0000";
						}
						elseif($orderHistory[$i]->order_status_id == '10')
						{
							$innerarr['statusColor'] = "#FF0000";
						}
						elseif($orderHistory[$i]->order_status_id == '11')
						{
							$innerarr['statusColor'] = "#197BB0";
						}
					}
					$innerarr['statusId'] = $orderHistory[$i]->order_status_id ;
					$innerarr['readStatus'] = (int)$orderHistory[$i]->status ;

					$results[] = $innerarr;
				}

				$badgeCount= $this->getUnreadCount($post['userId']);

				$response = array();
				$response['success'] = 1;
				$response['total'] = $totalOrderHistory;
				$response['badgeCount'] = (string)$badgeCount;
				$response['result'] = $results;

				echo json_encode($response);exit;
			}
			else
			{
				$response = array();
				$response['success'] = 0;
				$response['message'] = $this->lang->line('No Notification Available');
				echo json_encode($response);exit;
			}
		}
		catch(Exception $e)
		{
			$response = array();
			$response['success'] = 0;
			$response['message'] = $e->getMessage();
			echo json_encode($response);exit;
		}
	}

	public function addComment()
	{
		$input = file_get_contents('php://input');
		$post = json_decode($input, true);
		//Local
		//{"orderId":"25","userId":"3","languageCode":"en","comment":"test Comment","status":"1"}
		//Live
		//{"orderId":"25","userId":"44","languageCode":"en","comment":"test Comment","status":"1"}

		try
		{
			if((!isset($post['userId'])) || (!isset($post['orderId'])) || (!isset($post['languageCode'])) || (!isset($post['comment'])) || (!isset($post['status'])))
			{
				throw new Exception("Please fill in all the required fields.");
			}

			if($post['userId'] == '' || $post['userId'] == '0' || $post['orderId'] == '' || $post['orderId'] == '0' || $post['languageCode'] == '' || $post['languageCode'] == '0' || $post['comment'] == '' || $post['status'] == '0' || $post['status'] == '')
			{
				throw new Exception("Error in post data.");
			}

			$userdetail = $this->Customers_m->get_by(array('customer_id'=>$post['userId']));
			//$username = $userdetail->firstname.' '.$userdetail->lastname;
			$orderhistorydata = array("order_id"=>$post['orderId'],'order_status_id'=>$post['status'],"comment"=>addslashes($post['comment']),'date_added'=>date('Y-m-d H:i:s'),'user_group'=>'customer','user_name'=>$userdetail->email);
			$id = $this->Order_history_m->insert($orderhistorydata);

			if($id != 0)
			{
				$response = array();
				$response['success'] = 1;
				$response['message'] = 'Comment Added Successfully to Order.';
				echo json_encode($response);exit;
			}
			else
			{
				$response = array();
				$response['success'] = 0;
				$response['message'] = 'Something went wrong. Please try again.';
				echo json_encode($response);exit;
			}
		}
		catch(Exception $e)
		{
			$response = array();
			$response['success'] = 0;
			$response['message'] = $e->getMessage();
			echo json_encode($response);exit;
		}	
	}

	public function orderHistory()
	{
		$input = file_get_contents('php://input');
		$post = json_decode($input, true);


		//{ "userId": "1","orderId": "1","languageCode":"en","offset":"0"}

		try
		{
			if((!isset($post['userId'])) || (!isset($post['orderId'])) || (!isset($post['languageCode'])) || (!isset($post['offset'])))
			{
				throw new Exception("Please fill in all the required fields.");
			}

			if($post['userId'] == '' || $post['userId'] == '0' || $post['orderId'] == '' || $post['orderId'] == '0' || $post['languageCode'] == '' || $post['languageCode'] == '0' || $post['offset'] == '')
			{
				throw new Exception("Error in post data.");
			}

			if($_SERVER['HTTP_HOST'] == '192.168.1.101')
			{
				$server = $_SERVER['HTTP_HOST'].'/opencart';
			}
			else
			{
				$server = $_SERVER['HTTP_HOST'];
			}

			$this->load->model('Users_m');
			$where = " order_id='".$post['orderId']."' ORDER BY order_history_id ASC LIMIT ".$post['offset'].",10";
			$orderHistory = $this->Order_history_m->get_many_by($where);

			$totalOrderHistory = $this->Order_history_m->count_by(array('order_id'=>$post['orderId']));
			
			if(count($orderHistory)>0)
			{
				$results = array();

				$userRec = $this->Customers_m->getImage($post['userId']);
				//$userRec->thumbImage = '';
				if($userRec->thumbImage == '')
					$profileImageResp = $profileImageResp = (isset($_SERVER['HTTPS']) ? "https://" : "http://").$server.'/image/profile.png';
				else
					$profileImageResp = $profileImageResp = (isset($_SERVER['HTTPS']) ? "https://" : "http://").$server.'/image/'.$userRec->thumbImage;

				for($i=0;$i<count($orderHistory);$i++)
				{
					$inner = array();
					if($orderHistory[$i]->user_group == 'customer')
					{
						$inner['image'] = $profileImageResp;
						$userdetail = $this->Customers_m->get_by(array('email'=>$orderHistory[$i]->user_name));
						$inner['name'] = $userdetail->firstname.' '.$userdetail->lastname;
					}
					else
					{
						$userdetail = $this->Users_m->get_by(array('username'=>$orderHistory[$i]->user_name));
						
						if($userdetail->image == '')
							$profileImageResp = (isset($_SERVER['HTTPS']) ? "https://" : "http://").$server.'/image/catalog/profile-pic.png';
						else
							$profileImageResp = (isset($_SERVER['HTTPS']) ? "https://" : "http://").$server.'/image/'.$userdetail->image;

						$inner['image'] = $profileImageResp;
						$inner['name'] = $userdetail->firstname.' '.$userdetail->lastname;
					}
					$inner['comment'] = $orderHistory[$i]->comment;
					$inner['date'] = (string)strtotime($orderHistory[$i]->date_added);
					$results[] = $inner;
				}
				$response = array();
				$response['success'] = 1;
				$response['total'] = $totalOrderHistory;
				$response['result'] = $results;
				echo json_encode($response);exit;
			}
			else
			{
				$response = array();
				$response['success'] = 0;
				$response['message'] = 'No Record Found.';
				echo json_encode($response);exit;
			}
		}
		catch(Exception $e)
		{
			$response = array();
			$response['success'] = 0;
			$response['message'] = $e->getMessage();
			echo json_encode($response);exit;
		}	
	}

	public function orderDetails()
	{
		$input = file_get_contents('php://input');
		$post = json_decode($input, true);

		//{"userId": "1","orderId": "1","languageCode":"en"}

		try
		{
			if((!isset($post['userId'])) || (!isset($post['orderId'])) || (!isset($post['languageCode'])))
			{
				throw new Exception("Please fill in all the required fields.");
			}

			if($post['userId'] == '' || $post['userId'] == '0' || $post['orderId'] == '' || $post['orderId'] == '0' || $post['languageCode'] == '' || $post['languageCode'] == '0')
			{
				throw new Exception("Error in post data.");
			}

			if($_SERVER['HTTP_HOST'] == '192.168.1.101')
			{
				$server = $_SERVER['HTTP_HOST'].'/opencart';
			}
			else
			{
				$server = $_SERVER['HTTP_HOST'];
			}
			

			$orderDetails = $this->Order_m->get_by(array('order_id'=>$post['orderId']));
			$wherecon = "key ='config_currency'";
			$settings = $this->Setting_m->get_by($wherecon);
			

			$currencydetail = $this->Currency_m->get_by(array('code'=>$settings->value,'status'=>1));

			if($orderDetails != '')
			{
				$orderProducts = $this->Order_product_m->get_many_by(array('order_id'=>$post['orderId']));
				
				$products = array();
				$rewardpoint = 0;
				for($i=0;$i<count($orderProducts);$i++)
				{
					$innerProdArray = array();
					$rewardpoint = $rewardpoint + $orderProducts[$i]->reward;
					$innerProdArray['name'] = $orderProducts[$i]->name;
					$innerProdArray['quantity'] = $orderProducts[$i]->quantity;
					$innerProdArray['currencyCode'] = $currencydetail->symbol_left;
					$innerProdArray['total'] = number_format($orderProducts[$i]->total, 2, '.', '');

					$productImage = $this->Products_m->getProductImage($orderProducts[$i]->product_id);

					if($productImage->image == '')
					{
						$innerProdArray['thumbImage'] =  "";
					}
					else
					{
						$innerProdArray['thumbImage'] = (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $server.'/image/'.$productImage->image;
					}

					$products[] = $innerProdArray;
				}
				
				$result = array();

				$orderTotalDetail = $this->Order_total_m->get_many_by(array('order_id'=>$post['orderId']));
				for($k=0;$k<count($orderTotalDetail);$k++)
				{
					if($orderTotalDetail[$k]->code == 'total')
					{
						$result['total'] = number_format((float)$orderTotalDetail[$k]->value, 2, '.', '');
					}
					elseif($orderTotalDetail[$k]->code == 'shipping')
					{
						$result['shippingCharge'] = number_format((float)$orderTotalDetail[$k]->value, 2, '.', '');
					}
				}

				$result['placeOn'] 	= (string)strtotime($orderDetails->date_added);
				$result['orderNo'] 	= $orderDetails->order_id;
				$result['total'] 	= number_format((float)$orderDetails->total, 2, '.', '');
				$result['invoice'] 	= $orderDetails->invoice_prefix.$orderDetails->invoice_no;
				$result['reward'] 	= (string)$rewardpoint;
				$result['affiliate'] 	= "0.00";
				$result['currencyCode'] = $currencydetail->symbol_left;
				$result['email'] = $orderDetails->email;
				$result['phone'] = $orderDetails->telephone;
				$result['shipFirstName'] = $orderDetails->payment_firstname;
				$result['shipLastName'] = $orderDetails->payment_lastname;
				$result['shipCompany'] = $orderDetails->payment_company;
				$result['shipAdderss1'] = $orderDetails->payment_address_1;
				$result['shipAddress2'] = $orderDetails->payment_address_2;
				$result['shipCity'] = $orderDetails->payment_city;
				$result['shipState'] = $orderDetails->payment_zone;
				$result['shipCountry'] = $orderDetails->payment_country;
				$result['shipPostcode'] = $orderDetails->payment_postcode;
				$result['shipLastName'] = $orderDetails->telephone;
				$result['status'] = $orderDetails->order_status_id;
				if($orderDetails->order_status_id==1){
					$result['statusName'] = 'Pending';
				} else if($orderDetails->order_status_id==2){
					$result['statusName'] = 'Processing';
				} else if($orderDetails->order_status_id==3){
					$result['statusName'] = 'Shipped';
				} else if($orderDetails->order_status_id==5){
					$result['statusName'] = 'Complete';
				} else if($orderDetails->order_status_id==7){
					$result['statusName'] = 'Canceled';
				} else if($orderDetails->order_status_id==9){
					$result['statusName'] = 'Canceled Reversal';
				} else if($orderDetails->order_status_id==10){
					$result['statusName'] = 'Failed';
				} else if($orderDetails->order_status_id==11){
					$result['statusName'] = 'Refunded';
				} else if($orderDetails->order_status_id==12){
					$result['statusName'] = 'Reversed';
				} else if($orderDetails->order_status_id==13){
					$result['statusName'] = 'Chargeback';
				} else if($orderDetails->order_status_id==14){
					$result['statusName'] = 'Expired';
				} else if($orderDetails->order_status_id==15){
					$result['statusName'] = 'Processed';
				} else if($orderDetails->order_status_id==16){
					$result['statusName'] = 'Voided';
				}
				$result['products'] = $products;

				$response = array();
				$response['success'] = 1;
				$response['result'] = $result;
				echo json_encode($response);exit;
			}
			else
			{
				$response = array();
				$response['success'] = 0;
				$response['message'] = 'No record found.';
				echo json_encode($response);exit;
			}
		}
		catch(Exception $e)
		{
			$response = array();
			$response['success'] = 0;
			$response['message'] = $e->getMessage();
			echo json_encode($response);exit;
		}	
	}

	public function placeOrder()
	{
	  
		$input = file_get_contents('php://input');
		$post = json_decode($input, true);

       

		/*
		$post['userId']=55;
		$post['sessionId']='';
		$post['device']='2';
		$post['languageCode']='en';
		$post['addressId']='35';
		$post['comments']='';
		$post['paymentType']='0';*/
		//{ "device": "1","languageCode" : "en","userId" : "44" ,"sessionId":"adffdsdf12354" ,"addressId":"" ,"comments":"","paymentType" : "0","coupon": { }}

		try
		{
			if((!isset($post['addressId'])) || (!isset($post['userId'])) || (!isset($post['languageCode'])) || (!isset($post['sessionId'])) || (!isset($post['comments'])))
			{
				throw new Exception("Please fill in all the required fields.");
			}

			if($post['addressId'] == '' || $post['addressId'] == '0' ||  $post['languageCode'] == '' || $post['languageCode'] == '0' ||  $post['userId'] == '' || $post['userId'] == '0')
			{
				throw new Exception("Error in post data.");
			}

			$where = " key ='shipping_flat_cost' OR key='config_invoice_prefix' OR key='config_name' OR key='config_logo' OR key='config_email' ";
			$settings = $this->Setting_m->get_many_by($where);

			for($i=0;$i<count($settings);$i++)
			{
				if($settings[$i]->key == 'config_name')
				{
					$storename = $settings[$i]->value;
				}
				elseif($settings[$i]->key == 'config_invoice_prefix')
				{
					$invoiceprefix = $settings[$i]->value;
				}
				elseif($settings[$i]->key == 'shipping_flat_cost')
				{
					$shippingflatcost = $settings[$i]->value;
				}
				elseif($settings[$i]->key == 'config_logo')
				{
					$logo = $settings[$i]->value;
				}
				elseif($settings[$i]->key == 'config_email')
				{
					$storeemail = $settings[$i]->value;
					
				}
			}
			
			$userdetail = $this->Customers_m->get_by(array('customer_id'=>$post['userId']));

			if($_SERVER['HTTP_HOST'] == '192.168.1.101')
			{
				$server = $_SERVER['HTTP_HOST'].'/opencart';
			}
			else
			{
				$server = $_SERVER['HTTP_HOST'];
			}

			$wherecon = "key ='config_currency'";
			$settings = $this->Setting_m->get_by($wherecon);
			

			$currencydetail = $this->Currency_m->get_by(array('code'=>$settings->value,'status'=>1));

			if($post['languageCode'] == 'en'){
				$language = $this->Language_m->get_by(array('name'=>'English'));
				$this->lang->load('Webservice', 'english');
			}
			elseif($post['languageCode'] == 'ar'){
				$language = $this->Language_m->get_by(array('name'=>'Arabic'));
			}
			elseif($post['languageCode'] == 'es'){
						$language = $this->Language_m->get_by(array('code'=>'es-es'));
					$this->lang->load('Webservice', 'spanish');
				}
			elseif($post['languageCode'] == 'ru'){
						$language = $this->Language_m->get_by(array('code'=>'ru-ru'));
					$this->lang->load('Webservice', 'russian');
				}

			if($language == '')
				$language = 1;
			else
				$language = $language->language_id;

			$addressDetail = $this->Address_m->get_by(array('address_id'=>$post['addressId']));

			$countryDetail = $this->Country_m->get_by(array('country_id'=>$addressDetail->country_id));
			$stateDetail = $this->State_m->get_by(array('zone_id'=>$addressDetail->zone_id));
		
			$cartDetail = $this->Cart_m->get_many_by(array('customer_id'=>$post['userId']));
			//echo "<pre>";print_r($cartDetail);exit;

			

			if($post['paymentType'] == '0')
			{
				$insertdata =array(
							'invoice_prefix'	=> $invoiceprefix,
							'store_name'		=>	$storename,
							'store_url'			=>	$server,
							'customer_id' 		=> $post['userId'],
							'customer_group_id'	=> $userdetail->customer_group_id,
							'firstname'			=> $userdetail->firstname,
							'lastname'			=> $userdetail->lastname,
							'email'				=> $userdetail->email,
							'telephone'			=> $userdetail->telephone,
							'payment_firstname'	=> $addressDetail->firstname,
							'payment_lastname'	=> $addressDetail->lastname,
							'payment_company'	=> $addressDetail->company,
							'payment_address_1' => $addressDetail->address_1,
							'payment_address_2'	=> $addressDetail->address_2,
							'payment_city'		=> $addressDetail->city,
							'payment_postcode'	=> $addressDetail->postcode,
							'payment_country'	=> $countryDetail->name,
							'payment_country_id'=> $addressDetail->country_id,
							'payment_zone'		=> $stateDetail->name,
							'payment_zone_id'	=> $addressDetail->zone_id,
							'payment_method'	=> 'Cash On Delivery',
							'payment_code'		=> 'cod',
							'shipping_firstname'=> $addressDetail->firstname,
							'shipping_lastname'	=> $addressDetail->lastname,
							'shipping_company'	=> $addressDetail->company,
							'shipping_address_1'=> $addressDetail->address_1,
							'shipping_address_2'=> $addressDetail->address_2,
							'shipping_city'		=> $addressDetail->city,
							'shipping_postcode'	=> $addressDetail->postcode,
							'shipping_country'	=> $countryDetail->name,
							'shipping_country_id'=>$addressDetail->country_id ,
							'shipping_zone'		=> $stateDetail->name,
							'shipping_zone_id'	=> $addressDetail->zone_id,
							'shipping_method'	=> 'Flat Shipping Rate',
							'shipping_code'		=> 'flat.flat',
							'comment'			=> $post['comments'],
							'total'				=> 0.00,
							'order_status_id'	=> 1,
							'language_id'		=> $language,
							'currency_id'		=> $currencydetail->currency_id,
							'currency_code'		=> $currencydetail->code,
							'currency_value'	=> $currencydetail->value,
							'ip'				=> '127.0.0.1',
							'date_added'		=> date('Y-m-d H:i:s'),
							'date_modified'		=> date('Y-m-d H:i:s')
						);
				$this->Order_m->insert($insertdata);
				$lastId = $this->db->insert_id();
				
			}
			else
			{
				$insertdata =array(
							'invoice_prefix'	=> $invoiceprefix,
							'store_name'		=> $storename,
							'store_url'			=> $server,
							'customer_id' 		=> $post['userId'],
							'customer_group_id'	=> $userdetail->customer_group_id,
							'firstname'			=> $userdetail->firstname,
							'lastname'			=> $userdetail->lastname,
							'email'				=> $userdetail->email,
							'telephone'			=> $userdetail->telephone,
							'payment_firstname'	=> $addressDetail->firstname,
							'payment_lastname'	=> $addressDetail->lastname,
							'payment_company'	=> $addressDetail->company,
							'payment_address_1' => $addressDetail->address_1,
							'payment_address_2'	=> $addressDetail->address_2,
							'payment_city'		=> $addressDetail->city,
							'payment_postcode'	=> $addressDetail->postcode,
							'payment_country'	=> $countryDetail->name,
							'payment_country_id'=> $addressDetail->country_id,
							'payment_zone'		=> $stateDetail->name,
							'payment_zone_id'	=> $addressDetail->zone_id,
							'payment_method'	=> 'Stripe',
							'payment_code'		=> 'STRIPE',
							'shipping_firstname'=> $addressDetail->firstname,
							'shipping_lastname'	=> $addressDetail->lastname,
							'shipping_company'	=> $addressDetail->company,
							'shipping_address_1'=> $addressDetail->address_1,
							'shipping_address_2'=> $addressDetail->address_2,
							'shipping_city'		=> $addressDetail->city,
							'shipping_postcode'	=> $addressDetail->postcode,
							'shipping_country'	=> $countryDetail->name,
							'shipping_country_id'=>$addressDetail->country_id ,
							'shipping_zone'		=> $stateDetail->name,
							'shipping_zone_id'	=> $addressDetail->zone_id,
							'shipping_method'	=> 'Flat Shipping Rate',
							'shipping_code'		=> 'flat.flat',
							'comment'			=> $post['comments'],
							'total'				=> 0.00,
							'order_status_id'	=> 1,
							'language_id'		=> $language,
							'currency_id'		=> $currencydetail->currency_id,
							'currency_code'		=> $currencydetail->code,
							'currency_value'	=> $currencydetail->value,
							'ip'				=> '127.0.0.1',
							'date_added'		=> date('Y-m-d H:i:s'),
							'date_modified'		=> date('Y-m-d H:i:s')
						);
				
				$this->Order_m->insert($insertdata);
				$lastId = $this->db->insert_id();
			}

			$dataar = array();
			$dataar['customer_id'] = $post['userId'];
			$dataar['name'] = $userdetail->firstname.' '.$userdetail->lastname;
			$dataar['order_id'] = $lastId;
			$datan = json_encode($dataar);
			$datead = date('Y-m-d H:i:s');
			$this->Activity_m->insert(array('customer_id' => $post['userId'],'key'=>'order_account','data'=>$datan,'ip'=>$_SERVER['REMOTE_ADDR'],'date_added'=>$datead));

			$html = '<html>
				<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
				<title>{{ title }}</title>
				</head>
				<body style="font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: #000000;">
				<div style="width: 680px;"><a href="'.$server.'" title="'.$storename.'"><img src="'.$server.'/image/'.$logo.'" alt="'.$storename.'" style="margin-bottom: 20px; border: none;" /></a>
				  <p style="margin-top: 0px; margin-bottom: 20px;">Thank you for your interest in '.$storename.' products. Your order has been received and will be processed once payment has been confirmed</p>
				 
				  <p style="margin-top: 0px; margin-bottom: 20px;">To view your order click on the link below:</p>
				  <p style="margin-top: 0px; margin-bottom: 20px;"><a href="'.$server.'/index.php?route=account/order/info&order_id='.$lastId.'">'.$server."/index.php?route=account/order/info&order_id=".$lastId.'</a></p>
				  
				  
				  <table style="border-collapse: collapse; width: 100%; border-top: 1px solid #DDDDDD; border-left: 1px solid #DDDDDD; margin-bottom: 20px;">
				    <thead>
				      <tr>
				        <td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;" colspan="2">Order Details</td>
				      </tr>
				    </thead>
				    <tbody>
				      <tr>
				        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;"><b>Order ID:</b> '.$lastId.'<br />
				          <b>Date Added:</b> '.date('d/m/Y').'<br />
				          <b>Payment Method:</b> Cash on Delivery<br />
				          <b>Shipping Method:</b> Flat Shipping Rate
				          </td>
				        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;"><b>E-mail:</b> '.$userdetail->email.'<br />
				          <b>Telephone:</b> '.$userdetail->telephone.'<br />
				          <b>IP Address:</b> 127.0.0.1<br />
				          <b>Order Status:</b> Pending<br /></td>
				      </tr>
				    </tbody>
				  </table>';
				if($post['comments'] != '')
				{
				  $html .='<table style="border-collapse: collapse; width: 100%; border-top: 1px solid #DDDDDD; border-left: 1px solid #DDDDDD; margin-bottom: 20px;">
				    <thead>
				      <tr>
				        <td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;">Instructions</td>
				      </tr>
				    </thead>
				    <tbody>
				      <tr>
				        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;">'.$post['comments'].'</td>
				      </tr>
				    </tbody>
				  </table>';
				}

				$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
				$find = array(
							'{firstname}',
							'{lastname}',
							'{company}',
							'{address_1}',
							'{address_2}',
							'{city}',
							'{postcode}',
							'{zone}',
							'{country}'
						);
				$replace = array(
							'firstname' => $addressDetail->firstname,
							'lastname'  => $addressDetail->lastname,
							'company'   => $addressDetail->company,
							'address_1' => $addressDetail->address_1,
							'address_2' => $addressDetail->address_2,
							'city'      => $addressDetail->city,
							'postcode'  => $addressDetail->postcode,
							'zone'      => $stateDetail->name,
							'country'   => $countryDetail->name
						);

				$paymentAddress = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));


				$html.='<table style="border-collapse: collapse; width: 100%; border-top: 1px solid #DDDDDD; border-left: 1px solid #DDDDDD; margin-bottom: 20px;">
				    <thead>
				      <tr>
				        <td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;">Payment Address</td>
				
				        <td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;">Shipping Address</td>
				      </tr>
				    </thead>
				    <tbody>
				      <tr>
				        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;">'.$paymentAddress.'</td>
				        
				        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;">'.$paymentAddress.'</td>
				      </tr>
				    </tbody>
				  </table>
				  <table style="border-collapse: collapse; width: 100%; border-top: 1px solid #DDDDDD; border-left: 1px solid #DDDDDD; margin-bottom: 20px;">
				    <thead>
				      <tr>
				        <td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;">Product</td>
				        <td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;">Model</td>
				        <td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: right; padding: 7px; color: #222222;">Quantity</td>
				        <td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: right; padding: 7px; color: #222222;">Price</td>
				        <td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: right; padding: 7px; color: #222222;">Total</td>
				      </tr>
				    </thead>
				    <tbody>';

			$netTotal = 0;
			for($i=0;$i<count($cartDetail);$i++)
			{
				$productReward 	= $this->Products_m->getProductReward($cartDetail[$i]->product_id);
				//$productPrice  	= $this->Products_m->getProductPrice($cartDetail[$i]->product_id);
				$productPrice  = $this->Products_m->getProductPrice($cartDetail[$i]->product_id, $post['userId']);

				$productModel  	= $this->Products_m->getProductModel($cartDetail[$i]->product_id);
				$productName   	= $this->Products_m->getProductName($cartDetail[$i]->product_id,$language);
				$reward 		= $productReward->points * $cartDetail[$i]->quantity;

				$productPrice = $productPrice->price;
				$data = json_decode($cartDetail[$i]->option);
				
				if(isset($data))
				{
					foreach($data as $key=>$value) 
					{
						if(is_array($value))
						{	
							for($z=0;$z<count($value);$z++)
							{
								$result = $this->Options_m->getOptionPrice($value[$z],$key,$cartDetail[$i]->product_id);
								$productPrice = $productPrice + $result->price;
							}
						}
						else
						{
							$result = $this->Options_m->getOptionPrice($value,$key,$cartDetail[$i]->product_id);
							$productPrice = $productPrice + $result->price;
						}
					}
				}
				
				$cTotal = $productPrice * $cartDetail[$i]->quantity;
				$netTotal = $netTotal + $cTotal;

				$orderproductdata = array(
					"order_id"	=> $lastId,
					'product_id'=> $cartDetail[$i]->product_id,
					'name'		=> $productName->name,
					'model'		=> $productModel->model,
					'quantity'	=> $cartDetail[$i]->quantity,
					'price'		=> number_format((float)$productPrice, 2, '.', ''),
					'total'		=> number_format((float)$cTotal, 2, '.', ''),
					'reward'	=> $reward
				);

				$this->Order_product_m->insert($orderproductdata);
				$lastorderprodId = $this->db->insert_id();

				$data = json_decode($cartDetail[$i]->option);
				$html .='<tr>
						      <td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;">'.$productName->name.'<br />';

				foreach($data as $key=>$value) 
				{
					if(is_array($value))
					{	
						//$value = explode(',',$value[0]);
						
						for($z=0;$z<count($value);$z++)
						{
							$result = $this->Cart_m->getCartOptionDetail($key,$value[$z]);
							if(!empty($result)){
							$orderoptiondata = array(
								"order_id"			=> $lastId,
								'order_product_id'	=> $lastorderprodId,
								'product_option_id'	=> $value[$z],
								'product_option_value_id'	=> $key,
								'name'		=> $result->optionname,
								'value'		=> $result->optionvalname,
								'type'		=> $result->type
							);
							$this->Order_option_m->insert($orderoptiondata);

							$html .='&nbsp;<small> - '.$result->optionname.': '.$result->optionvalname.'</small>';
							}
						}
					}
					else
					{
						$result = $this->Cart_m->getCartOptionDetail($key,$value);
						if(!empty($result)){
						$orderoptiondata = array(
							"order_id"			=> $lastId,
							'order_product_id'	=> $lastorderprodId,
							'product_option_id'	=> $value,
							'product_option_value_id'	=> $key,
							'name'		=> $result->optionname,
							'value'		=> $result->optionvalname,
							'type'		=> $result->type
						);
						$this->Order_option_m->insert($orderoptiondata);

						$html .='&nbsp;<small> - '.$result->optionname.': '.$result->optionvalname.'</small>';
					}
					}
				}

				$html .=' </td>
					      <td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;">'.$productModel->model.'</td>
					      <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;">'.$cartDetail[$i]->quantity.'</td>
					      <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;">'.$currencydetail->symbol_left.number_format((float)$productPrice, 2, '.', '').'</td>
					      <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;">$'.$currencydetail->symbol_left.number_format((float)$cTotal, 2, '.', '').'</td>
					    </tr>';
			}	

			$netTotal = number_format((float)$netTotal, 2, '.', '');


			if($post['paymentType'] == 1)
			{

				require_once(APPPATH.'third_party/lib/Stripe.php');
				Stripe::setApiKey("sk_test_X1xGhzYdqTx9xgtFn4icgKvj"); //Replace with your Secret Key

				$userdetail = $this->Customers_m->get_by(array('customer_id'=>$post['userId']));


				if($userdetail->stripeId == '')
				{
					
					$customer = Stripe_Customer::create(
						array(
					  		"source" => $post['token'],
					  		"email"  => $userdetail->email,
					  		"description" => "NEw customer"
					  	)
					);	
					$newarray = $customer->__toArray(TRUE);

					$userdetail->stripeId = $newarray['id'];

					$this->Customers_m->update_by(array('customer_id'=>$post['userId']),array('stripeId' => $newarray['id']));

					$charge = Stripe_Charge::create(array(
					  'amount' => round($netTotal),
					  'currency' => 'BOB',
					  "customer" => $newarray['id']
					));
					$newarray2 = $charge->__toArray(TRUE);

				}
				else
				{
					
					$charge = Stripe_Charge::create(array(
					  'amount' => round($netTotal),
					  'currency' => 'BOB',
					  "customer" => $userdetail->stripeId
					));
					$newarray2 = $charge->__toArray(TRUE);
					//echo '<pre>';print_r($newarray2);exit;
				}

				$stripeinsert = array(
							'orderId'				=> 	$lastId,
							'stripeTransactionId'	=>	$newarray2['id'],
							'userId'				=>	$post['userId'],
							'stripeCustomerId' 		=>	$userdetail->stripeId,
							'createdDate'			=>  date('Y-m-d H:i:s')
						);

				$this->Stripe_order_m->insert($stripeinsert);
			}


			$this->Order_m->update_by(array('order_id'=>$lastId),array('total'=>$netTotal));

			

			$username = $userdetail->email;
			$orderhistorydata = array("order_id"=>$lastId,'order_status_id'=>1,"comment"=>$post['comments'],'date_added'=>date('Y-m-d H:i:s'),'user_group'=>'customer','user_name'=>$username);
			//$orderhistorydata = array("order_id"=>$lastId,'order_status_id'=>1,'date_added'=>date('Y-m-d H:i:s'));
			$this->Order_history_m->insert($orderhistorydata);

			if((isset($post['coupon']['couponId'])))
			{
				
				$couponhistorydata = array("coupon_id"=>$post['coupon']['couponId'],'order_id'=>$lastId,'customer_id'=>$post['userId'],'amount'=>'-'.$post['coupon']['discountValue'].'','date_added'=>date('Y-m-d H:i:s'));
				$this->Coupon_history_m->insert($couponhistorydata);

				$ordertotaldata = array(
					"order_id"	=> $lastId,
					'code'		=> 'coupon',
					'title'		=> 'Coupon ('.$post['coupon']['couponCode'].')',
					'value'		=> '-'.$post['coupon']['discountValue'].'',
					'sort_order'=> 4
				);
				$this->Order_total_m->insert($ordertotaldata);
				//Coupon entry ends here
			}

			//Order Total Table entry starts *************************************

			$ordertotaldata = array(
				"order_id"	=> $lastId,
				'code'		=> 'sub_total',
				'title'		=> 'Sub-Total',
				'value'		=> $netTotal,
				'sort_order'=> 1
			);

			$this->Order_total_m->insert($ordertotaldata);
			$shipping = number_format((float)$shippingflatcost, 2, '.', '');

			$ordertotaldata = array(
				"order_id"	=> $lastId,
				'code'		=> 'shipping',
				'title'		=> 'Flat Shipping Rate',
				'value'		=> $shipping,
				'sort_order'=> 3
			);

			$this->Order_total_m->insert($ordertotaldata);

			
			$finalTotal =  $shipping + $netTotal;
			if((isset($post['coupon']['couponId'])))
			{
				$finalTotal = $finalTotal - $post['coupon']['discountValue'];
			}
			$netTotal = number_format((float)$finalTotal, 2, '.', '');
			$ordertotaldata = array(
				"order_id"	=> $lastId,
				'code'		=> 'total',
				'title'		=> 'Total',
				'value'		=> $finalTotal,
				'sort_order'=> 9
			);

			$this->Order_total_m->insert($ordertotaldata);

			$html.= '</tbody>
				    
				    <tfoot>
				    
				    <tr>
				      <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;" colspan="4"><b>Sub-Total:</b></td>
				      <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;">'.$currencydetail->symbol_left.$netTotal.'</td>
				    </tr>
				    <tr>
				      <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;" colspan="4"><b>Flat Shipping Rate:</b></td>
				      <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;">'.$currencydetail->symbol_left.$shipping.'</td>
				    </tr>';
				    if((isset($post['coupon']['couponId'])))
					{
					    $html.= '<tr>
					      <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;" colspan="4"><b>Coupon ('.$post['coupon']['couponCode'].'):</b></td>
					      <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;">-'.$currencydetail->symbol_left.$post['coupon']['discountValue'].'</td>
					    </tr>';
					}
				    $html.= '<tr>
				      <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;" colspan="4"><b>Total:</b></td>
				      <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: right; padding: 7px;">'.$currencydetail->symbol_left.$finalTotal.'</td>
				    </tr>
				   
				      </tfoot>
				    
				  </table>
				  <p style="margin-top: 0px; margin-bottom: 20px;">Please reply to this e-mail if you have any questions.</p>
				</div>
				</body>
				</html>';


				$to      = $userdetail->email;
				
				$subject = $storename.' Order '.$lastId;
		        $message = $html;
		        $headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
		        $headers .= 'From: '.$storeemail. "\r\n" .
		            'Reply-To: ' .$storeemail. "\r\n" .
		            'MIME-Version: 1.0' . "\r\n".
		        'X-Mailer: PHP/' . phpversion();

		        //mail($to, $subject, $message, $headers);
		        
		        // mail send code new harmis
		        require_once('mailer.php');
           
                $mail = new PHPMailer(true); 
            
                $mail->IsSMTP(); 
                
               // $to = "harmistest@gmail.com";
                $subject = 'Посуда оптом и в розницу Order '.$lastId;
                            
               $mail->Host       = "ssl://smtp.mail.ru"; // SMTP server
              $mail->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)
              $mail->SMTPAuth   = true;                  // enable SMTP authentication
              $mail->Host       = "ssl://smtp.mail.ru"; // sets the SMTP server
              $mail->Port       = 465;                    // set the SMTP port for the GMAIL server
              $mail->Username   = "bespalov-89@mail.ru"; // SMTP account username
              $mail->Password   = "777kireevbes210989";        // SMTP account password
              //$headers = array ('From' => 'bespalov-89@mail.ru', 'To' => $to, 'Subject' => $subject, 'Reply-To' => $to , 'MIME-Version' => '1.0', 'Content-Type' => "text/html; charset=ISO-8859-1");
             $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'quoted-printable';
              $mail->AddReplyTo($to, 'posudacity161.ru Посуда оптом и в розницу');
              $mail->AddAddress($to, 'posudacity161.ru Посуда оптом и в розницу');
              $mail->SetFrom('bespalov-89@mail.ru', 'posudacity161.ru Посуда оптом и в розницу');
              $mail->AddReplyTo($to, 'posudacity161.ru Посуда оптом и в розницу');
              $mail->Subject = html_entity_decode($subject);
              $message=  html_entity_decode($message);
              $mail->MsgHTML($message);
            
              $mail->Send();
              
              
            
             
             
              
		        
		        
		        

			/*$this->load->library('email');
			$config['protocol'] = 'sendmail';
		    $config['mailpath'] = '/usr/sbin/sendmail';
		    $config['charset'] = 'iso-8859-1';
		    $config['wordwrap'] = TRUE;
		    $config['mailtype'] = 'html';
		    $this->email->initialize($config);
		    $messge = '';
		    
		    $subject = $storename.' Order '.$lastId;
		    $this->email->from($storeemail);
		    $this->email->to('khalidchauhan2108@gmail.com');
		    $this->email->subject($subject);
		    $this->email->message($html);
		    $message=$this->email->send();*/

		    
			$this->Cart_m->delete_by(array('customer_id'=>$post['userId']));

			

			$response = array();
			$response['success'] = 1;
			$response['message'] = $this->lang->line("Order has been placed successfully, Thank You");
			$response['orderId'] = $lastId;
			$response['statusId'] = 1;
			
			echo json_encode($response);exit;
		}
		catch(Exception $e)
		{
			$response = array();
			$response['success'] = 0;
			$response['message'] = $e->getMessage();
			echo json_encode($response);exit;
		}	
	}

	public function getCountries()
	{
		//$countries = $this->Country_m->get_many_by(array('status'=>1,'iso_code_2'=>'IN'));
		$countries = $this->Country_m->get_many_by(array('status'=>1));
		$mainarray = array();
		for($i=0;$i<count($countries);$i++)
		{
			$innerarr['countryId'] = $countries[$i]->country_id;
			$innerarr['countryName'] = $countries[$i]->name;
			$mainarray[] = $innerarr;
		}

		$response = array();
		$response['success'] = 1;
		$response['result'] = $mainarray;
		echo json_encode($response);exit;
	}

	public function getStates()
	{
		$input = file_get_contents('php://input');
		$post = json_decode($input, true);

		try
		{
			if((!isset($post['countryId'])))
			{
				throw new Exception("Please fill in all the required fields.");
			}

			if($post['countryId'] == '' || $post['countryId'] == '0')
			{
				throw new Exception("Error in post data.");
			}

			$this->load->model('State_m');
			$states = $this->State_m->get_many_by(array('status'=>1,'country_id'=>$post['countryId']));
			$mainarray = array();
			for($i=0;$i<count($states);$i++)
			{
				$innerarr['stateId'] = $states[$i]->zone_id;
				$innerarr['stateName'] = $states[$i]->name;
				$mainarray[] = $innerarr;
			}

			$response = array();
			$response['success'] = 1;
			$response['result'] = $mainarray;
			echo json_encode($response);exit;
		}
		catch(Exception $e)
		{
			$response = array();
			$response['success'] = 0;
			$response['message'] = $e->getMessage();
			echo json_encode($response);exit;
		}
	}

	public function AddAddress()
	{
		$input = file_get_contents('php://input');
		$post = json_decode($input, true);	
		//echo "<pre>";print_r($post);exit;
		# $post['city'] = 'Ahmedabad';
	 #    $post['googleAddress']['state'] = '';
	 #    $post['googleAddress']['city'] = '';
	 #    $post['googleAddress']['placeName'] = '';
	 #    $post['googleAddress']['fullAddress'] = '';
	 #    $post['googleAddress']['placeId'] = '';
	 #    $post['googleAddress']['country'] = '';
	   

	 #    $post['lastName'] = 'Sachala';
	 #    $post['userId'] = '7';
	 #    $post['lat'] = '23.0234838672';
	 #    $post['add2'] = 'Siromani';
	 #    $post['isEdit'] = '0';
	 #    $post['stateId'] = '1485';
	 #    $post['postalCode'] = '380015';
	 #    $post['long'] = '72.5389396772';
	 #    $post['addressId'] = '';
	 #    $post['add1'] = 'A/23, Acharya Narendradev Nagar, Ambawadi';
	 #    $post['companyName'] = 'Harmis';
	 #    $post['firstName'] = 'Bhavesh Sachala';
	 #    $post['countryId'] = '99';

		try
		{
			if( (!isset($post['isEdit'])) || (!isset($post['firstName'])) || (!isset($post['lastName'])) || (!isset($post['companyName'])) || (!isset($post['userId'])) || (!isset($post['addressId'])) || (!isset($post['add2'])) || (!isset($post['lat'])) || (!isset($post['long'])) || (!isset($post['add1'])) || (!isset($post['city'])) || (!isset($post['postalCode'])) || (!isset($post['countryId'])) || (!isset($post['stateId'])) || (!isset($post['googleAddress']['city'])) || (!isset($post['googleAddress']['state'])) || (!isset($post['googleAddress']['country'])) || (!isset($post['googleAddress']['placeName'])) || (!isset($post['googleAddress']['fullAddress'])) || (!isset($post['googleAddress']['placeId'])))
			{
				throw new Exception("Please provide all required fields.");
			}

			if($post['userId'] == '' || $post['userId'] == '0' || $post['lat'] == '' || $post['lat'] == '0' || $post['long'] == '' || $post['long'] == '0' || $post['isEdit'] == '' || $post['firstName'] == '' || $post['firstName'] == '0' || $post['lastName'] == '' || $post['lastName'] == '0' || $post['add1'] == '' || $post['add1'] == '0' || $post['city'] == '' || $post['city'] == '0' || $post['countryId'] == '' || $post['countryId'] == '0' || $post['stateId'] == '' || $post['stateId'] == '0')
			{
				throw new Exception("Error in post data.");
			}

			$countryDetail = $this->Country_m->get_by(array('country_id'=>$post['countryId']));
			$stateDetail = $this->State_m->get_by(array('zone_id'=>$post['stateId']));
			
			$insertdata = array(
    			"customer_id"	 	=> $post['userId'], 
				"firstname" 		=> addslashes($post['firstName']),
				"lastname"			=> addslashes($post['lastName']), 
				"company"  			=> addslashes($post['companyName']), 
				"address_1"  	 	=> addslashes($post['add1']),
				"address_2"  		=> addslashes($post['add2']),
				"city"				=> $post['city'],
				"postcode"			=> $post['postalCode'],
				"country_id"		=> $post['countryId'],
				"zone_id"			=> $post['stateId']
			);
			
			$fullAddress = $post['firstName'].' '.$post['lastName'].' '.$post['add1'].' '.$post['city'].' '.$stateDetail->name.' '.$countryDetail->name;

			if($post['isEdit'] == '0')
			{
				
				$id = $this->Address_m->insert($insertdata);

				$insertdata = array(
					"city"  	=> $post['googleAddress']['city'],
					"state"  	=> $post['googleAddress']['state'],
					"country" 	=> $post['googleAddress']['country'],
					"placeName"	=> addslashes($post['googleAddress']['placeName']),
					"googleFullAddress"	=> addslashes($post['googleAddress']['fullAddress']),
					"placeId"		=> $post['googleAddress']['placeId'],
					"userId"	 	=> $post['userId'], 
					"fullAddress" 	=> addslashes($fullAddress),
					"addressId"		=> $id, 
					"companyName"  	=> addslashes($post['companyName']), 
					"latitude" 		=> $post['lat'],
					"longitude" 	=> $post['long'],
					"createDate"	=> date('Y-m-d H:i:s')
				);
				$this->Customer_address_m->insert($insertdata);
				$message = 'Address added successfully.';


			}
			else if($post['isEdit'] == 1)
			{
				
				$id = $post['addressId'];
				$this->Address_m->update_by(array('address_id'=>$post['addressId']),$insertdata);
				
				$insertdata = array(
					"city"  	=> $post['googleAddress']['city'],
					"state"  	=> $post['googleAddress']['state'],
					"country" 	=> $post['googleAddress']['country'],
					"placeName"	=> addslashes($post['googleAddress']['placeName']),
					"googleFullAddress"	=> addslashes($post['googleAddress']['fullAddress']),
					"placeId"		=> $post['googleAddress']['placeId'],
					"userId"	 		=> $post['userId'], 
					"fullAddress" 		=> addslashes($fullAddress),
					"companyName"  		=> addslashes($post['companyName']), 
					"latitude" 			=> $post['lat'],
					"longitude" 		=> $post['long']
				);
				$this->Customer_address_m->update_by(array('addressId'=>$post['addressId']),$insertdata);

				$message = 'Address added successfully.';
			}

			
			$where = " key ='config_geocode'";
			$settings = $this->Setting_m->get_by($where);
			$geocode = explode(",",$settings->value);
			
			# change by raju
			# $distance = $this->getDistance($post['lat'],$post['long'],$geocode[0],$geocode[1]);


			$googleAddress = array();
			$googleAddress['city'] 		= $post['googleAddress']['city'];
			$googleAddress['country'] 	= $post['googleAddress']['country'];
			$googleAddress['state'] 	= $post['googleAddress']['state'];
			$googleAddress['placeName'] = $post['googleAddress']['placeName'];
			$googleAddress['fullAddress'] = $post['googleAddress']['fullAddress'];
			$googleAddress['placeId'] 	= $post['googleAddress']['placeId'];
			
			
			$pickUpAddress = array();
			$pickUpAddress['fullAddress'] 	= addslashes($fullAddress);
			$pickUpAddress['userId'] 		= $post['userId'];
			$pickUpAddress['lat'] 			= (float)$post['lat'];
			$pickUpAddress['long'] 			= (float)$post['long'];
			$pickUpAddress['addressId'] 	= (string)$id;
			$pickUpAddress['firstName'] 	= $post['firstName'];
			$pickUpAddress['lastName'] 		= $post['lastName'];
			$pickUpAddress['add1'] 			= $post['add1'];
			$pickUpAddress['add2'] 			= $post['add2'];
			$pickUpAddress['postalCode'] 	= $post['postalCode'];
			$pickUpAddress['city'] 			= $post['city'];
			$pickUpAddress['countryId'] 	= $post['countryId'];
			$pickUpAddress['stateId'] 		= $post['stateId'];
			$pickUpAddress['companyName'] 	= $post['companyName'];
			# $pickUpAddress['distance'] 		= (string)$distance;
			$pickUpAddress['googleAddress'] = $googleAddress;

			if($id)
			{
				$response = array();
				$response['success'] = 1;
				$response['message'] = $message;
				$response['result']  = $pickUpAddress;
				$response=$this->convertNullToString($response);
				echo json_encode($response);exit;
			}
			else
			{
				throw new Exception("Something went wrong. Please try again.");
			}	
		}
		catch(Exception $e)
		{
			//echo $e->getMessage;exit;
			$response = array();
			$response['success'] = 0;
			$response['message'] = $e->getMessage();
			echo json_encode($response);exit;
		}
	}

	public function getDistance($pickupLatitude,$pickupLongitude,$deliveryLatitude,$deliveryLongitude)
  	{
  		# echo $pickupLatitude;
  		# echo "<br>";
  		# echo $pickupLongitude;
  		# echo "<br>";
  		# echo $deliveryLatitude;
  		# echo "<br>";
  		# echo $deliveryLongitude;
  		# echo "<br>";
  		# exit;


    	$formattedAddrFrom = $pickupLatitude.','.$pickupLongitude;
      	$formattedAddrTo = $deliveryLatitude.','.$deliveryLongitude;
      	
  	    $geocodeFrom = file_get_contents('https://maps.googleapis.com/maps/api/directions/json?units=imperial&alternatives=true&mode=driving&origin='.$formattedAddrFrom.'&destination='.$formattedAddrTo.'&sensor=false&key=AIzaSyBSoJNA14MQoq22iyEhYOfY06XYkEnxXAU');
      	$outputFrom = json_decode($geocodeFrom);

      	
      	//echo 'https://maps.googleapis.com/maps/api/directions/json?units=imperial&alternatives=true&mode=driving&origin='.$formattedAddrFrom.'&destination='.$formattedAddrTo.'&sensor=false&key=AIzaSyDImcjjRxyJMDrtMz3JWOQa2AhHkyq1xng';

      	if($outputFrom->status == 'OVER_QUERY_LIMIT')
 		{
 			$response['success'] = 0;
			$response['message'] = "You have exceeded your daily request quota for this API.";
			echo json_encode($response);exit;
 		}
     	//echo 'https://maps.googleapis.com/maps/api/directions/json?units=imperial&alternatives=true&mode=driving&origin='.$formattedAddrFrom.'&destination='.$formattedAddrTo.'&sensor=false&key=AIzaSyBSoJNA14MQoq22iyEhYOfY06XYkEnxXAU';
     	if($outputFrom->status == 'ZERO_RESULTS')
     	{
     		 $geocodeFrom = file_get_contents('https://maps.googleapis.com/maps/api/directions/json?units=imperial&alternatives=true&mode=driving&origin='.$formattedAddrFrom.'&destination='.$formattedAddrTo.'&sensor=false&&key=AIzaSyBSoJNA14MQoq22iyEhYOfY06XYkEnxXAU');
      		 $outputFrom = json_decode($geocodeFrom);

      		if($outputFrom->status == 'ZERO_RESULTS')
     		{
     			$response['success'] = 0;
				$response['message'] = "Please select another location we are unable to find a driving route.";
				echo json_encode($response);exit;
     		}
     	}
      	$distanceLast = 0;
      	for($i=0;$i<count($outputFrom->routes);$i++)
      	{
        	$distance = $outputFrom->routes[$i]->legs[0]->distance->value * 0.001;
        	if($distance >= $distanceLast)
        	{
        		$distanceLast = $distance;
        	}
      	}
        return $distanceLast;
  	}

	public function DeleteAddress()
	{
		$input = file_get_contents('php://input');
		$post = json_decode($input, true);

		try
		{
			if((!isset($post['userId'])) || (!isset($post['addressId'])))
			{
				throw new Exception("Please provide all required fields.");
			}

			if($post['userId'] == '' || $post['userId'] == 0 || $post['addressId'] == '' || $post['addressId'] == 0)
			{
				throw new Exception("Error in post data.");
			}

			$id =$this->Address_m->delete_by(array('address_id'=>$post['addressId'],'customer_id'=>$post['userId']));
			
			$response = array();
			$response['success'] = 1;
			$response['message'] = 'Address removed successfully.';
			echo json_encode($response);exit;

		}
		catch(Exception $e)
		{
			$response = array();
			$response['success'] = 0;
			$response['message'] = $e->getMessage();
			echo json_encode($response);exit;
		}

	}

	public function GetAddressList()
	{
		$input = file_get_contents('php://input');
		$post = json_decode($input, true);

		/*{"userId": "5"}*/

		try
		{
			if((!isset($post['userId'])))
			{
				throw new Exception("Please provide all required fields.");
			}

			if($post['userId'] == '' || $post['userId'] == 0)
			{
				throw new Exception("Error in post data.");
			}

			$addressList = $this->Address_m->Count_by(array('customer_id'=>$post['userId']));
				
			if($addressList == 0)
			{
				$response = array();
				$response['success'] = 0;
				$response['message'] = "No Address Available.";
				echo json_encode($response);exit;
			}
			else
			{
				//$where = " userId='".$post['userId']."' ORDER BY id DESC LIMIT 0,1";
				$addressDetails = $this->Address_m->get_many_by(array('customer_id'=>$post['userId']));

				$mainArray = array();
				
				for($i=0;$i<count($addressDetails);$i++)
				{
					$where = " key ='config_geocode'";
					$settings = $this->Setting_m->get_by($where);

					$geocode = explode(",",$settings->value);

					$otherAddress = $this->Customer_address_m->get_by(array('addressId'=>$addressDetails[$i]->address_id));

					if($otherAddress != '')
					{
						#change by raju
						# $distance = $this->getDistance($otherAddress->latitude,$otherAddress->longitude,$geocode[0],$geocode[1]);

						$googleAddress = array();
						$googleAddress['city'] = $otherAddress->googleCity;
						$googleAddress['country'] = $otherAddress->googleCountry;
						$googleAddress['state'] = $otherAddress->googleState;
						$googleAddress['placeName'] = $otherAddress->googlePlacename;
						$googleAddress['fullAddress'] = $otherAddress->googleFullAddress;
						$googleAddress['placeId'] = $otherAddress->googlePlaceid;
					}
					else
					{
						$distance = "0";

						$googleAddress = array();
						$googleAddress['city'] = "";
						$googleAddress['country'] = "";
						$googleAddress['state'] = "";
						$googleAddress['placeName'] = "";
						$googleAddress['fullAddress'] = "";
						$googleAddress['placeId'] = "";
					}

						$countryDetail = $this->Country_m->get_by(array('country_id'=>$addressDetails[$i]->country_id));
						$stateDetail = $this->State_m->get_by(array('zone_id'=>$addressDetails[$i]->zone_id));

					$innerArray = array();
					$innerArray['addressId'] = $addressDetails[$i]->address_id;
					$innerArray['userId'] = $post['userId'];
					$innerArray['fullAddress'] = $addressDetails[$i]->firstname.' '.$addressDetails[$i]->lastname.' '.$addressDetails[$i]->address_1.' '.$addressDetails[$i]->city.' '.$stateDetail->name.' '.$countryDetail->name;
					$innerArray['lat'] = (float)$otherAddress->latitude;
					$innerArray['long'] = (float)$otherAddress->longitude;
					$innerArray['companyName'] = $addressDetails[$i]->company;
					$innerArray['firstName'] = $addressDetails[$i]->firstname;
					$innerArray['lastName'] = $addressDetails[$i]->lastname;
					$innerArray['add1'] = $addressDetails[$i]->address_1;
					$innerArray['add2'] = $addressDetails[$i]->address_2;
					$innerArray['city'] = $addressDetails[$i]->city;
					$innerArray['postalCode'] = $addressDetails[$i]->postcode;
					$innerArray['countryId'] = $addressDetails[$i]->country_id;
					$innerArray['countryName'] = $countryDetail->name;
					$innerArray['stateId'] = $addressDetails[$i]->zone_id;
					$innerArray['stateName'] = $stateDetail->name;
					$innerArray['distance'] = $distance;
					$innerArray['googleAddress'] = $googleAddress;

					$mainArray[] = $innerArray;
				}

				$response = array();
				$response['success'] = 1;
				$response['message'] = 'Get all addresses successfully.';
				$response['result'] = $mainArray;
				$response=$this->convertNullToString($response);
				echo json_encode($response);exit;
			}
		}
		catch(Exception $e)
		{
			$response = array();
			$response['success'] = 0;
			$response['message'] = $e->getMessage();
			echo json_encode($response);exit;
		}
	}

	public function updateWishlist()
	{
		$input = file_get_contents('php://input');
		$post = json_decode($input, true);
		
		try
		{
			if((!isset($post['productId'])) || (!isset($post['userId'])) || (!isset($post['languageCode'])) || (!isset($post['isFavourite'])))
			{
				throw new Exception("Please fill in all the required fields.");
			}

			if($post['productId'] == '' || $post['productId'] == '0' || $post['userId'] == '' || $post['userId'] == '0' || $post['isFavourite'] == '' || $post['languageCode'] == '' || $post['languageCode'] == '0')
			{
				throw new Exception("Error in post data.");
			}
			
			if($post['isFavourite'] == 1)
			{
				$cartDetail = $this->Wishlist_m->get_by(array( 'customer_id' => $post['userId'],'product_id'=> $post['productId']));

				if($cartDetail != '')
				{
					$response['success'] = 0;
					$response['message'] = "Product already available in wishlist.";
					echo json_encode($response);exit;
				}
				else
				{
					$this->Wishlist_m->insert(array('customer_id' => $post['userId'],'product_id'=>$post['productId'],'date_added'=>date('Y-m-d H:i:s')));
				}
				$total = $this->Wishlist_m->count_by(array('customer_id'=>$post['userId']));
				$response['success'] = 1;
				$response['wishListCount'] = (string)$total;
				$response['message'] = "Product successfully added to your wishlist.";
			}
			elseif($post['isFavourite'] == 0)
			{
				$this->Wishlist_m->delete_by(array('customer_id' => $post['userId'],'product_id'=>$post['productId']));
				$total = $this->Wishlist_m->count_by(array('customer_id'=>$post['userId']));
				$response['success'] = 1;
				$response['wishListCount'] = (string)$total;
				$response['message'] = "Product removed from your wishlist.";
			}

			echo json_encode($response);exit;
		}
		catch(Exception $e)
		{
			$response = array();
			$response['success'] = 0;
			$response['message'] = $e->getMessage();
			echo json_encode($response);exit;
		}	
	}

	public function getWishList()
	{
		$input = file_get_contents('php://input');
		$post = json_decode($input, true);
		
		try
		{
			if((!isset($post['offset'])) || (!isset($post['userId'])) || (!isset($post['languageCode'])))
			{
				throw new Exception("Please fill in all the required fields.");
			}

			if($post['offset'] == '' || $post['userId'] == '' || $post['userId'] == '0' || $post['languageCode'] == '' || $post['languageCode'] == '0')
			{
				throw new Exception("Error in post data.");
			}
		
			if($_SERVER['HTTP_HOST'] == '192.168.1.101')
			{
				$server = $_SERVER['HTTP_HOST'].'/opencart';
			}
			else
			{
				$server = $_SERVER['HTTP_HOST'];
			}
			
			$where = " customer_id ='".$post['userId']."' LIMIT ".$post['offset'].",10";
			$cartDetail = $this->Wishlist_m->get_many_by($where);
			//echo '<pre>';print_r($cartDetail);exit;
			$total = $this->Wishlist_m->count_by(array('customer_id'=>$post['userId']));
			$wherecon = "key ='config_currency'";
			$settings = $this->Setting_m->get_by($wherecon);
			

			$currencydetail = $this->Currency_m->get_by(array('code'=>$settings->value,'status'=>1));
			if(count($cartDetail) > 0)
			{
				$response['success'] = 1;
				$response['total'] = (string)$total;
				$mainarr = array();
				for($i=0;$i<count($cartDetail);$i++)
				{
					if($post['languageCode'] == 'en'){
				$language = $this->Language_m->get_by(array('name'=>'English'));
				$this->lang->load('Webservice', 'english');
			}
			elseif($post['languageCode'] == 'ar'){
				$language = $this->Language_m->get_by(array('name'=>'Arabic'));
			}
			elseif($post['languageCode'] == 'es'){
						$language = $this->Language_m->get_by(array('code'=>'es-es'));
					$this->lang->load('Webservice', 'spanish');
				}
			elseif($post['languageCode'] == 'ru'){
						$language = $this->Language_m->get_by(array('code'=>'ru-ru'));
					$this->lang->load('Webservice', 'russian');
				}

					if($language == '')
						$language = 1;
					else
						$language = $language->language_id;

					$productDetail = $this->Products_m->getProductDetail($cartDetail[$i]->product_id,$language);

					if($productDetail != '')
					{

						$innerarr['productId'] = $cartDetail[$i]->product_id;
						$innerarr['name'] = $productDetail->name;
						$innerarr['currencyCode'] = $currencydetail->symbol_left;
						$innerarr['price'] = $productDetail->price;
						if($productDetail->image == '')
						{
							$innerarr['thumbImage'] =  "";
						}
						else
						{
							$innerarr['thumbImage'] = (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $server.'/image/'.$productDetail->image;
						}
						// change by raju
						$checkMandatory = $this->Options_m->checkMandatory($cartDetail[$i]->product_id);		
						if($checkMandatory != '')
						{
							$innerarr['isOptions'] = "1";
						}
						else
						{
							$innerarr['isOptions'] = "0";
						}			

						$mainarr[] = $innerarr;
					}
				}

				$response['result'] = $mainarr;
				
			}
			else
			{
				$response['success'] = 0;
				$response['message'] = $this->lang->line("No product found in your wishlist");
			}
			echo json_encode($response);exit;
		}
		catch(Exception $e)
		{
			$response = array();
			$response['success'] = 0;
			$response['message'] = $e->getMessage();
			echo json_encode($response);exit;
		}	
	}

	public function getCategories()
	{
		$input = file_get_contents('php://input');
		$post = json_decode($input, true);	
	

		try
		{	
			if((!isset($post['languageCode'])) || (!isset($post['offset'])))
			{
				throw new Exception("Please fill in all the required fields.");
			}
			if( $post['languageCode'] == '' || $post['languageCode'] == '0' || $post['offset'] == '' )
			{
				throw new Exception("Error in post data.");
			}

			if($post['languageCode'] == 'en'){
				$language = $this->Language_m->get_by(array('name'=>'English'));
				$this->lang->load('Webservice', 'english');
			}
			elseif($post['languageCode'] == 'ar'){
				$language = $this->Language_m->get_by(array('name'=>'Arabic'));
			}
			elseif($post['languageCode'] == 'es'){
						$language = $this->Language_m->get_by(array('code'=>'es-es'));
					$this->lang->load('Webservice', 'spanish');
				}
			elseif($post['languageCode'] == 'ru'){
						$language = $this->Language_m->get_by(array('code'=>'ru-ru'));
					$this->lang->load('Webservice', 'russian');
				}

			if($language == '')
				$language = 1;
			else
				$language = $language->language_id;

			$categoryDetail = $this->Categories_m->getCategories($post['offset'],10,0,$language);
			//echo '<pre>';print_r($categoryDetail);exit;
			$totalCategory = $this->Categories_m->count_by(array('parent_id'=>0,'status'=>1));
			if($totalCategory > 0)
			{
				$response['success'] = 1;
				$response['total'] = $totalCategory;

				$categoryArr = array();
			
				for($i=0;$i<count($categoryDetail);$i++)
				{
					$innerarr = array();
					$innerarr['catId'] = $categoryDetail[$i]->category_id;
					$innerarr['name'] = $categoryDetail[$i]->name;
					if($categoryDetail[$i]->image == '')
					{
						$innerarr['thumbImage'] =  "";
					}
					else
					{
						$innerarr['thumbImage'] =  (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER['SERVER_NAME'].'/image/'.$categoryDetail[$i]->image;	
					}

			if($categoryDetail[$i]->meta_title == ''){
						$innerarr['meta_title'] =  "";

					} else {

						$innerarr['meta_title'] = $categoryDetail[$i]->meta_title ;
					}
					$isSubcategory = $this->Categories_m->count_by(array('parent_id'=>$categoryDetail[$i]->category_id,'status'=>1));
					if($isSubcategory > 0)
						$innerarr['hasSubCategory'] = 1;
					else
						$innerarr['hasSubCategory'] = 0;
					$categoryArr[] = $innerarr;
				}

				$response['result'] = $categoryArr;
				
				
				echo json_encode($response);exit;
			}
			else
			{
				echo json_encode(array("success" => 0, "message" => $this->lang->line("No category found"), "total"=>0));exit;
			}
		}
		catch(Exception $e)
		{
			$response = array();
			$response['success'] = 0;
			$response['message'] = $e->getMessage();
			echo json_encode($response);exit;
		}	
	}



	public function getCategoriess()
	{
		$input = file_get_contents('php://input');
		$post = json_decode($input, true);	
	

		try
		{	
			if((!isset($post['languageCode'])) || (!isset($post['offset'])))
			{
				throw new Exception("Please fill in all the required fields.");
			}
			if( $post['languageCode'] == '' || $post['languageCode'] == '0' || $post['offset'] == '' )
			{
				throw new Exception("Error in post data.");
			}

			if($post['languageCode'] == 'en'){
				$language = $this->Language_m->get_by(array('name'=>'English'));
				$this->lang->load('Webservice', 'english');
			}
			elseif($post['languageCode'] == 'ar'){
				$language = $this->Language_m->get_by(array('name'=>'Arabic'));
			}
			elseif($post['languageCode'] == 'es'){
						$language = $this->Language_m->get_by(array('code'=>'es-es'));
					$this->lang->load('Webservice', 'spanish');
				}
			elseif($post['languageCode'] == 'ru'){
						$language = $this->Language_m->get_by(array('code'=>'ru-ru'));
					$this->lang->load('Webservice', 'russian');
				}

			if($language == '')
				$language = 1;
			else
				$language = $language->language_id;

			$categoryDetail = $this->Categories_m->getCategoriess($post['offset'],10,0,$language);
			//echo '<pre>';print_r($categoryDetail);exit;
			$totalCategory = $this->Categories_m->count_by(array('parent_id'=>0,'status'=>1));
			if($totalCategory > 0)
			{
				$response['success'] = 1;
				$response['total'] = $totalCategory;

				$categoryArr = array();
			
				for($i=0;$i<count($categoryDetail);$i++)
				{
					$innerarr = array();
					$innerarr['catId'] = $categoryDetail[$i]->category_id;
					$innerarr['name'] = $categoryDetail[$i]->name;
					if($categoryDetail[$i]->image == '')
					{
						$innerarr['thumbImage'] =  "";
					}
					else
					{
						$innerarr['thumbImage'] =  (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER['SERVER_NAME'].'/image/'.$categoryDetail[$i]->image;	
					}

			if($categoryDetail[$i]->meta_title == ''){
						$innerarr['meta_title'] =  "";

					} else {

						$innerarr['meta_title'] = $categoryDetail[$i]->meta_title ;
					}
					$isSubcategory = $this->Categories_m->count_by(array('parent_id'=>$categoryDetail[$i]->category_id,'status'=>1));
					if($isSubcategory > 0)
						$innerarr['hasSubCategory'] = 1;
					else
						$innerarr['hasSubCategory'] = 0;
					$categoryArr[] = $innerarr;
				}

				$response['result'] = $categoryArr;
				
				
				echo json_encode($response);exit;
			}
			else
			{
				echo json_encode(array("success" => 0, "message" => $this->lang->line("No category found"), "total"=>0));exit;
			}
		}
		catch(Exception $e)
		{
			$response = array();
			$response['success'] = 0;
			$response['message'] = $e->getMessage();
			echo json_encode($response);exit;
		}	
	}


	public function applyCouponCode()
	{
		$input = file_get_contents('php://input');
		$post = json_decode($input, true);		

		//{ "couponCode":"FLAT5","userId":"3","total":"65.00"}

		try
		{	
			if((!isset($post['couponCode'])) || (!isset($post['userId'])) || (!isset($post['total'])))
			{
				throw new Exception("Please fill in all the required fields.");
			}
			if( $post['couponCode'] == '' || $post['couponCode'] == '0' || $post['userId'] == '' || $post['userId'] == '0' || $post['total'] == '' || $post['total'] == '0')
			{
				throw new Exception("Error in post data.");
			}

			$where = ' code="'.$post['couponCode'].'" AND status = 1 AND date_start <= CURDATE() AND date_end >= CURDATE()';
			$couponDetail = $this->Couponcode_m->get_by($where);
			//echo '<pre>';print_r($couponDetail);exit;
			$wherecon = "key ='config_currency'";
			$settings = $this->Setting_m->get_by($wherecon);
			

			$currencydetail = $this->Currency_m->get_by(array('code'=>$settings->value,'status'=>1));

			if($couponDetail->uses_total != '0')
			{
				$couponUse = $this->Coupon_history_m->count_by(array('coupon_id'=>$couponDetail->coupon_id));
				if($couponUse >= $couponDetail->uses_total)
				{
					$response = array();
					$response['success'] = 0;
					$response['message'] = 'Warning: Coupon is either invalid, expired or reached its usage limit!';
					echo json_encode($response);exit;
				}
			}

			if($couponDetail->uses_customer != '0')
			{
				$couponUse = $this->Coupon_history_m->count_by(array('coupon_id'=>$couponDetail->coupon_id,'customer_id'=>$post['userId']));
				if($couponUse >= $couponDetail->uses_customer)
				{
					$response = array();
					$response['success'] = 0;
					$response['message'] = 'Warning: Coupon is either invalid, expired or reached its usage limit!';
					echo json_encode($response);exit;
				}
			}

			if($couponDetail != '')
			{
				if($couponDetail->type == 'F')
				{
					$cartDetail = $this->Cart_m->get_many_by(array('customer_id'=>$post['userId']));
					$test = 0;
					for($i=0;$i<count($cartDetail);$i++)
					{
						$isValid = $this->Couponcode_m->checkCouponProduct($couponDetail->coupon_id,$cartDetail[$i]->product_id);
						
						if($isValid > 0)
						{
							$test = 1;
							$resultarray = array();
							$resultarray['couponId'] = $couponDetail->coupon_id;
							$resultarray['couponType'] = $couponDetail->type;
							$resultarray['couponCode'] = $couponDetail->code;
							$resultarray['currencyCode'] = $currencydetail->symbol_left;
							$resultarray['discountValue'] = number_format($couponDetail->discount, 2, '.', '');
							$updatedTotal = $post['total'] - $couponDetail->discount;

							$updatedTotal = number_format($updatedTotal, 2, '.', '');
							$resultarray['updatedTotal'] = $updatedTotal;

							$response = array();
							$response['success'] = 1;
							$response['message'] = 'Coupon code applied successfully.';
							$response['result'] = $resultarray;
							echo json_encode($response);exit;
						}
						else
						{
							$isValid = $this->Couponcode_m->checkCouponCategory($couponDetail->coupon_id,$cartDetail[$i]->product_id);
							if($isValid > 0)
							{
								$test = 1;
								$resultarray = array();
								$resultarray['couponId'] = $couponDetail->coupon_id;
								$resultarray['couponType'] = $couponDetail->type;
								$resultarray['couponCode'] = $couponDetail->code;
								$resultarray['currencyCode'] = $currencydetail->symbol_left;
								$resultarray['discountValue'] = $couponDetail->discount;
								$updatedTotal = $post['total'] - $couponDetail->discount;

								$updatedTotal = number_format($updatedTotal, 2, '.', '');
								$resultarray['updatedTotal'] = $updatedTotal;

								$response = array();
								$response['success'] = 1;
								$response['message'] = 'Coupon code applied successfully.';
								$response['result'] = $resultarray;
								echo json_encode($response);exit;
							}
						}
					}
					if($test == 0)
					{
						$response = array();
						$response['success'] = 0;
						$response['message'] = 'Warning: Coupon is either invalid, expired or reached its usage limit!';
						echo json_encode($response);exit;
					}
				}
				else if($couponDetail->type == 'P')
				{
					$cartDetail = $this->Cart_m->get_many_by(array('customer_id'=>$post['userId']));
					$test = 0;
					$discountPrice = 0;
					//echo '<pre>';print_r($cartDetail);exit;
					for($i=0;$i<count($cartDetail);$i++)
					{
						$isValid = $this->Couponcode_m->checkCouponProduct($couponDetail->coupon_id,$cartDetail[$i]->product_id);
						
						if($isValid>0)
						{
							$test = 1;
							//$productPrice = $this->Products_m->getProductPrice($cartDetail[$i]->product_id);
							$productPrice  = $this->Products_m->getProductPrice($cartDetail[$i]->product_id, $post['userId']);

							$price = $productPrice->price * $cartDetail[$i]->quantity;
							$discPrice = ($price * $couponDetail->discount) / 100;
							$discountPrice = $discPrice + $discountPrice;
						}
						else
						{
							$isValid = $this->Couponcode_m->checkCouponCategory($couponDetail->coupon_id,$cartDetail[$i]->product_id);
							if($isValid>0)
							{
								$test = 1;
								//$productPrice = $this->Products_m->getProductPrice($cartDetail[$i]->product_id);
								$productPrice  = $this->Products_m->getProductPrice($cartDetail[$i]->product_id, $post['userId']);
								$price = $productPrice->price * $cartDetail[$i]->quantity;
								$discPrice = ($price * $couponDetail->discount) / 100;
								$discountPrice = $discPrice + $discountPrice;
							}
						}
					}

					if($test == 0)
					{
						$response = array();
						$response['success'] = 0;
						$response['message'] = 'Warning: Coupon is either invalid, expired or reached its usage limit!';
						echo json_encode($response);exit;
					}
					else
					{
						$discountPrice = number_format($discountPrice, 2, '.', '');
						$resultarray = array();
						$resultarray['couponId'] = $couponDetail->coupon_id;
						$resultarray['couponType'] = $couponDetail->type;
						$resultarray['couponCode'] = $couponDetail->code;
						$resultarray['currencyCode'] = $currencydetail->symbol_left;
						$resultarray['discountValue'] = $discountPrice;
						$updatedTotal = $post['total'] - $discountPrice;

						$updatedTotal = number_format($updatedTotal, 2, '.', '');
						$resultarray['updatedTotal'] = $updatedTotal;

						$response = array();
						$response['success'] = 1;
						$response['message'] = 'Coupon code applied successfully.';
						$response['result'] = $resultarray;
						echo json_encode($response);exit;
					}
				}
			}
			else
			{
				$response = array();
				$response['success'] = 0;
				$response['message'] = 'Warning: Coupon is either invalid, expired or reached its usage limit!';
				echo json_encode($response);exit;
			}
		}
		catch(Exception $e)
		{
			$response = array();
			$response['success'] = 0;
			$response['message'] = $e->getMessage();
			echo json_encode($response);exit;
		}	
	}

	public function getSubCategories()
	{
		$input = file_get_contents('php://input');
		$post = json_decode($input, true);	

		

		try
		{	
			if((!isset($post['languageCode'])) || (!isset($post['offset'])) || (!isset($post['catId'])))
			{
				throw new Exception("Please fill in all the required fields.");
			}
			if( $post['languageCode'] == '' || $post['languageCode'] == '0' || $post['offset'] == '' || $post['catId'] == '0' || $post['catId'] == '' )
			{
				throw new Exception("Error in post data.");
			}

			if($post['languageCode'] == 'en'){
				$language = $this->Language_m->get_by(array('name'=>'English'));
				$this->lang->load('Webservice', 'english');
			}
			elseif($post['languageCode'] == 'ar'){
				$language = $this->Language_m->get_by(array('name'=>'Arabic'));
			}
			elseif($post['languageCode'] == 'es'){
						$language = $this->Language_m->get_by(array('code'=>'es-es'));
					$this->lang->load('Webservice', 'spanish');
				}
			elseif($post['languageCode'] == 'ru'){
						$language = $this->Language_m->get_by(array('code'=>'ru-ru'));
					$this->lang->load('Webservice', 'russian');
				}

			if($language == '')
				$language = 1;
			else
				$language = $language->language_id;

			$categoryDetail = $this->Categories_m->getCategories($post['offset'],10,$post['catId'],$language);
			//echo '<pre>';print_r($categoryDetail);exit;
			$totalCategory = $this->Categories_m->count_by(array('parent_id'=>$post['catId'],'status'=>1));
			if($totalCategory > 0)
			{
				$response['success'] = 1;
				$response['total'] = $totalCategory;
				$isProductAvailable = $this->Products_m->checkProduct($post['catId']);
				if($isProductAvailable > 0)
					$response['hasProducts'] = 1;
				else
					$response['hasProducts'] = 0;

				$categoryArr = array();


				for($i=0;$i<count($categoryDetail);$i++)
				{
					$innerarr = array();
					$innerarr['subCatId'] = $categoryDetail[$i]->category_id;
					$innerarr['name'] = $categoryDetail[$i]->name;
					if($categoryDetail[$i]->image == '')
					{
						$innerarr['thumbImage'] =  "";
					}
					else
					{
						$innerarr['thumbImage'] = (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER['SERVER_NAME'].'/image/'.$categoryDetail[$i]->image;	
					}
					$isSubcategory = $this->Categories_m->count_by(array('parent_id'=>$categoryDetail[$i]->category_id,'status'=>1));
					if($isSubcategory > 0)
						$innerarr['hasSubCategory'] = 1;
					else
						$innerarr['hasSubCategory'] = 0;

					$isProductAvailable = $this->Products_m->checkProduct($categoryDetail[$i]->category_id);

					if($isProductAvailable > 0)
						$innerarr['hasProducts'] = 1;
					else
						$innerarr['hasProducts'] = 0;

					$categoryArr[] = $innerarr;
				}

				$response['result'] = $categoryArr;
				echo json_encode($response);exit;
			}
			else
			{
				echo json_encode(array("success" => 0, "message" => $this->lang->line("No category found"), "total"=>0 ));exit;
			}
		}
		catch(Exception $e)
		{
			$response = array();
			$response['success'] = 0;
			$response['message'] = $e->getMessage();
			echo json_encode($response);exit;
		}	
	}

	public function getbestsellerProducts() 
    {

		
		$input = file_get_contents('php://input');
		$post = json_decode($input, true);



		try
		{
			if((!isset($post['languageCode'])))
			{
				if(isset($post['languageCode']) && $post['languageCode'] == 'ar')
				{
					throw new Exception("يرجى تقديم جميع الحقول المطلوبة.");		
				}
				else
				{
					throw new Exception("Please provide all required fields.");	
				}
			}

			if($post['languageCode'] == '' || $post['languageCode'] == '0') 
			{
				if($post['languageCode'] == 'ar')
				{
					throw new Exception("خطأ في نشر البيانات.");		
				}
				else
				{
					throw new Exception("Error in post data.");
				}
			}

			if($_SERVER['HTTP_HOST'] == '192.168.1.101')
			{
				$server = $_SERVER['HTTP_HOST'].'/opencart';
			}
			else
			{
				$server = $_SERVER['HTTP_HOST'];
			}
		/*	$products = array();
				$sql = "SELECT op.product_id, SUM(op.quantity) AS total FROM oc_order_product op LEFT JOIN `oc_order` o ON (op.order_id = o.order_id) LEFT JOIN `oc_product` p ON (op.product_id = p.product_id) LEFT JOIN oc_product_to_store p2s ON (p.product_id = p2s.product_id) WHERE o.order_status_id > '0' AND p.status = '1' AND p.date_available <= NOW() GROUP BY op.product_id ORDER BY total DESC";*/
				
				
				$sql = "SELECT DISTINCT ps.product_id, (
		SELECT AVG(rating) FROM oc_review r1 
		WHERE r1.product_id = ps.product_id AND r1.status = '1' 
		GROUP BY r1.product_id) AS rating 
		FROM oc_product_special ps 
		LEFT JOIN oc_product p ON (ps.product_id = p.product_id) 
		LEFT JOIN oc_product_to_category ptc
		ON (p.product_id = ptc.product_id) 
		LEFT JOIN oc_product_description pd ON (p.product_id = pd.product_id) 
		LEFT JOIN oc_product_to_store p2s ON (p.product_id = p2s.product_id) 
		WHERE p.status = '1' AND p.date_available <= NOW() AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) 
		GROUP BY ps.product_id";

			$query = $this->db->query($sql);
		    $products = $query->result();
				
			//echo "<pre>";print_r($products);exit();
			if($post['languageCode'] == 'en')
				$language = $this->Language_m->get_by(array('code'=>'English'));
			elseif($post['languageCode'] == 'ar')
				$language = $this->Language_m->get_by(array('name'=>'العربية'));

			if($language == '')
				$language = 1;
			else
				$language = $language->language_id;
			$outerarr = array();


			$taxdetails = $this->Taxrate_m->get_by();
			$taxrate = (int)$taxdetails->rate;
			$wherecon = "key ='config_currency'";
			$settings = $this->Setting_m->get_by($wherecon);
			

			$currencydetail = $this->Currency_m->get_by(array('code'=>$settings->value,'status'=>1));
			//echo "<pre>";print_r($products);exit();
            //echo $products[0]->product_id;exit;
			if(count($products) > 0)
			{
				for ($i=0; $i < count($products) ; $i++) 
				{ 
					$innerarr=array();
					$productDetail = $this->Products_m->getbestsellerproductdetail($products[$i]->product_id,$language);
					//echo "<pre>";print_r($productDetail);
					
					if(isset($productDetail) && $productDetail != '')
					{
						$file = $productDetail->image; 
						$image_info = explode(".", $file); 
						$imagename = $image_info[0].'-250x250';
						$imagename = $imagename.'.'.$image_info[1];
						
						$taxprice = $this->mypercentagecal($productDetail->price,$taxrate);
						$productDetail->price = $productDetail->price;
						
						$innerarr['productId'] = $productDetail->product_id;
						$innerarr['name'] = $productDetail->name;
						$innerarr['price'] = number_format((float)$productDetail->price, 2, '.', '');
						$innerarr['thumbImage'] = (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $server.'/image/'.$productDetail->image;
						
						
						$innerarr['currencyCode'] = $currencydetail->symbol_left;

						if($productDetail->extax == '')
						{
							$innerarr['specialPrice'] = "";
						}
						elseif($productDetail->extax == 0.00)
						{
							$innerarr['specialPrice'] = "";
						}
						else
						{
							$vatprice = $this->mypercentagecal($productDetail->extax,$taxrate);
							$innerarr['specialPrice'] = number_format((float)$productDetail->extax, 2, '.', '');
							$specialPrice = $innerarr['specialPrice'];
							$innerarr['specialPrice'] = number_format((float)$specialPrice, 2, '.', '');
						}
						//$innerarr['taxprice'] = "";

						/*$currentdate = date('Y-m-d');
						$next_date = strtotime($nextdate);
						$cur_date  = strtotime($currentdate);
						if($next_date >= $cur_date)
						{
						}
		                */
		                
						if($productDetail->price == "" || $productDetail->extax == "")
						{
							$innerarr['discountPercentage'] = "";
						}
						elseif($productDetail->price == 0.00  && $productDetail->extax == 0.00)
						{
							
							$innerarr['discountPercentage'] = "50%";
						}
						else
						{	

							$innerarr['discountPercentage'] = round((($productDetail->price - $productDetail->extax) / $productDetail->price * 100)) . ' %';
						}
						if($productDetail->quantity >= $productDetail->minimum && $productDetail->quantity != '0')
						{
							$innerarr['inStock'] = "1";
						}
						else
						{
							$innerarr['inStock'] = "0";
						}
						$checkMandatory = $this->Options_m->checkMandatory($products[$i]->product_id);

			            if($checkMandatory != '')
			            {
			              $innerarr['isOptions'] = "1";
			            }
			            else
			            {
			              $innerarr['isOptions'] = "0";
			            }
						
						$outerarr[] = $innerarr;
					}
				}

			}
			else
			{
				$products = array();
				

				$sql = "SELECT op.product_id, SUM(op.quantity) AS total FROM oc_order_product op LEFT JOIN `oc_order` o ON (op.order_id = o.order_id) LEFT JOIN `oc_product` p ON (op.product_id = p.product_id) LEFT JOIN oc_product_to_store p2s ON (p.product_id = p2s.product_id) WHERE o.order_status_id > '0' AND p.status = '1' AND p.date_available <= NOW() GROUP BY op.product_id ORDER BY total DESC";

				$query = $this->db->query($sql);
			    $products = $query->result();
               
				if(count($products) > 0)
				{
					for ($i=0; $i < count($products) ; $i++) 
					{ 
						$innerarr=array();
						$productDetail = $this->Products_m->getbestsellerproductdetail($products[$i]->product_id,$language);
 
						if(isset($productDetail) && $productDetail != '')
						{
							$taxprice = $this->mypercentagecal($productDetail->price,$taxrate);
							$taxprice = $this->mypercentagecal($productDetail->price,$taxrate);
							$productDetail->price = $productDetail->price;
							
							$innerarr['productId'] = $productDetail->product_id;
							$innerarr['name'] = $productDetail->name;
							$innerarr['price'] = number_format((float)$productDetail->price, 2, '.', '');
							$innerarr['thumbImage'] = (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $server.'/image/'.$productDetail->image;
							$innerarr['currencyCode'] = $currencydetail->symbol_left;
							if($productDetail->extax == '')
							{
								$innerarr['specialPrice'] = "";
							}
							elseif($productDetail->extax == 0.00)
							{
								$innerarr['specialPrice'] = "";
							}
							else
							{
								$vatprice = $this->mypercentagecal($productDetail->extax,$taxrate);
								$innerarr['specialPrice'] = number_format((float)$productDetail->extax, 2, '.', '');
								$specialPrice = $innerarr['specialPrice'];
								$innerarr['specialPrice'] = number_format((float)$specialPrice, 2, '.', '');
							}
							if($productDetail->quantity >= $productDetail->minimum && $productDetail->quantity != '0')
							{
								$innerarr['inStock'] = "1";
							}
							else
							{
								$innerarr['inStock'] = "0";
							}
							//$innerarr['taxprice'] = "";
							if($productDetail->price == "" || $productDetail->extax == "")
							{
								$innerarr['discountPercentage'] = "";
							}
							elseif($productDetail->price == 0.00  && $productDetail->extax == 0.00)
							{
								
								$innerarr['discountPercentage'] = "50%";
							}
							else
							{	

								$innerarr['discountPercentage'] = round((($productDetail->price - $productDetail->extax) / $productDetail->price * 100)) . ' %';
							}
							

							$checkMandatory = $this->Options_m->checkMandatory($products[$i]->product_id);
							

				            if($checkMandatory != '')
				            {
				              $innerarr['isOptions'] = "1";
				            }
				            else
				            {
				              $innerarr['isOptions'] = "0";
				            }

							$outerarr[] = $innerarr;
						}
					}	
				}
			}
			
			$response['success'] = 1;
			$response['result'] = $outerarr;
			echo json_encode($response);exit;
		}
		catch(Exception $e)
		{
			$response = array();
			$response['success'] = 0;
			$response['message'] = $e->getMessage();
			echo json_encode($response);exit;
		}	

			
		
	}

	public function Search()
	{
		$input = file_get_contents('php://input');
		$post = json_decode($input, true);

		try
		{
			if((!isset($post['keyword'])) || (!isset($post['languageCode'])) || (!isset($post['offset'])))
			{
				throw new Exception("Please fill in all the required fields.");
			}

			if($post['keyword'] == '' || $post['languageCode'] == '' || $post['languageCode'] == '0' || $post['offset'] == '')
			{
				throw new Exception("Error in post data.");
			}

			if($_SERVER['HTTP_HOST'] == '192.168.1.101')
			{
				$server = $_SERVER['HTTP_HOST'].'/opencart';
			}
			else
			{
				$server = $_SERVER['HTTP_HOST'];
			}

				if($post['languageCode'] == 'en'){
				$language = $this->Language_m->get_by(array('name'=>'English'));
				$this->lang->load('Webservice', 'english');
			}
			elseif($post['languageCode'] == 'ar'){
				$language = $this->Language_m->get_by(array('name'=>'Arabic'));
			}
			elseif($post['languageCode'] == 'es'){
						$language = $this->Language_m->get_by(array('code'=>'es-es'));
					$this->lang->load('Webservice', 'spanish');
				}
			elseif($post['languageCode'] == 'ru'){
						$language = $this->Language_m->get_by(array('code'=>'ru-ru'));
					$this->lang->load('Webservice', 'russian');
				}

					if($language == '')
						$language = 1;
					else
						$language = $language->language_id;
			
			$productArray = $this->Products_m->getProductList($post['keyword'],$language,$post['offset']);
			$productArray1 = $this->Products_m->getProductList1($post['keyword'],$language);
			$productArray2 = $this->Products_m->getProductList2($post['keyword'],$language,$post['offset']);
			//echo '<pre>';print_r($productArray1);exit;
			$totalProduct = $this->Products_m->getProductCount($post['keyword'],$post['languageCode']);
			$taxdetails = $this->Taxrate_m->get_by();
			$taxrate = (int)$taxdetails->rate;
			$wherecon = "key ='config_currency'";
			$settings = $this->Setting_m->get_by($wherecon);
			

			$currencydetail = $this->Currency_m->get_by(array('code'=>$settings->value,'status'=>1));

			if($post['languageCode'] == 'en'){
				$language = $this->Language_m->get_by(array('name'=>'English'));
				$this->lang->load('Webservice', 'english');
			}
			elseif($post['languageCode'] == 'ar'){
				$language = $this->Language_m->get_by(array('name'=>'Arabic'));
			}
			elseif($post['languageCode'] == 'es'){
						$language = $this->Language_m->get_by(array('code'=>'es-es'));
					$this->lang->load('Webservice', 'spanish');
				}
			elseif($post['languageCode'] == 'ru'){
						$language = $this->Language_m->get_by(array('code'=>'ru-ru'));
					$this->lang->load('Webservice', 'russian');
				}

					if($language == '')
						$language = 1;
					else
						$language = $language->language_id;

			/*if(count($productArray1)> 0)
			{	
					$total = 0;

				for($i=0;$i<count($productArray1);$i++)
				{
					
					$productDetail1 = $this->Products_m->getProductDetail($productArray1[$i]->product_id,$language);
					if($productDetail1 != '')
					{

						$total++;	
					}
				}
			}	

			$response['total'] = $total;*/	

			if(count($productArray2) > 0)
			{
				$response['success'] = 1;
				$response['total'] = count($productArray1);

				$mainProdArr = array();
			
				for($i=0;$i<count($productArray2);$i++)
				{
					$innerarr = array();
					
					//$productArray[$i] = $productArray1[$i];

					$productDetail = $this->Products_m->getProductDetail($productArray2[$i]->product_id,$language);

					//echo '<pre>';print_r($productDetail); exit;
					if($productDetail != '')
					{
								
						$innerarr['productId'] = $productArray2[$i]->product_id;
						$name = htmlspecialchars_decode($productDetail->name,ENT_QUOTES);
						$innerarr['name'] = $name;

						$categoryList = $this->Products_m->getProductCategory($productArray2[$i]->product_id);
						$productPriceF  = $this->Products_m->getProductPrice($productArray2[$i]->product_id, $post['userId']);
						$categoryArray = array();

						for($k=0;$k<count($categoryList);$k++)
						{
							$cateArray = array();
							$cateArray['id'] = $categoryList[$k]->category_id;
							$categoryDetail = $this->Categories_m->getCategoryDetail($categoryList[$k]->category_id,$language);
							$cname = htmlspecialchars_decode($categoryDetail->name,ENT_QUOTES);
							$cateArray['title'] = $cname;
							$categoryArray[] = $cateArray;
						}
						
						$innerarr['category'] = $categoryArray;
						$innerarr['currencyCode'] = $currencydetail->symbol_left;
						$innerarr['price'] = number_format((float)$productPriceF->price, 2, '.', '');
						if($productDetail->extax == '')
						{
							$innerarr['specialPrice'] = "";
						}
						elseif($productDetail->extax == 0.00)
						{
							$innerarr['specialPrice'] = "";
						}
						else
						{
							$vatprice = $this->mypercentagecal($productArray2[$i]->extax,$taxrate);
							$innerarr['specialPrice'] = number_format((float)$productArray2[$i]->extax, 2, '.', '');
							$specialPrice = $innerarr['specialPrice'];
							$innerarr['specialPrice'] = number_format((float)$specialPrice, 2, '.', '');
						}
						$innerarr['minQuantity'] = $productArray2[$i]->minimum;
						$innerarr['quantity'] = $productArray2[$i]->minimum;
						$innerarr['minQuantityDesc'] = "This product has a minimum quantity of ".$productDetail->minimum;


						if($productArray2[$i]->quantity >= $productArray2[$i]->minimum && $productArray2[$i]->quantity != '0')
						{
							$innerarr['inStock'] = "1";
						}
						else
						{
							$innerarr['inStock'] = "0";
						}
						if($productDetail->image == '')
						{
							$innerarr['thumbImage'] =  "";
						}
						else
						{
							$innerarr['thumbImage'] = (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $server.'/image/'.$productDetail->image;
						}
						
						$checkMandatory = $this->Options_m->checkMandatory($productArray2[$i]->product_id);
						if($checkMandatory != '')
						{
							$innerarr['isOptions'] = "1";
						}
						else
						{
							$innerarr['isOptions'] = "0";
						}

						$categoryArr[] = $innerarr;
					}
				}
				
				if($response['total'] == 1 && count($productDetail)=='')
				{
					echo json_encode(array("success" => 0, "message" => $this->lang->line("No product found") ));exit;
				}
				$response['result'] = $categoryArr;
				$response = $this->convertNullToString($response);
				echo json_encode($response);exit;
			}
			else
			{
				echo json_encode(array("success" => 0, "message" => $this->lang->line("No product found") ));exit;
			}
		}
		catch(Exception $e)
		{
			$response = array();
			$response['success'] = 0;
			$response['message'] = $e->getMessage();
			echo json_encode($response);exit;
		}	
	}

	public function getProducts()
	{
		$input = file_get_contents('php://input');
		$post = json_decode($input, true);	

		//{"device": "1","userId":"3","catId": "1","subCatId": "1","offset" : "0","isSubcategory" : "1","languageCode" : "en"}
		
		try
		{	
			if((!isset($post['languageCode'])) || (!isset($post['offset'])) || (!isset($post['catId'])) || (!isset($post['isSubcategory'])) || (!isset($post['userId'])))
			{
				throw new Exception("Please fill in all the required fields.");
			}
			if( $post['languageCode'] == '' || $post['languageCode'] == '0' || $post['offset'] == '' || $post['catId'] == '' || $post['catId'] == '0' || $post['isSubcategory'] == '')
			{
				throw new Exception("Error in post data.");
			}

			if($_SERVER['HTTP_HOST'] == '192.168.1.101')
			{
				$server = $_SERVER['HTTP_HOST'].'/opencart';
			}
			else
			{
				$server = $_SERVER['HTTP_HOST'];
			}
			//$where = " userId='".$post['userId']."' AND addressType ='1' ORDER BY id DESC LIMIT 0,1";
			//$homeAddressDetail = $this->Sender_address_m->get_by($where);
			if($post['isSubcategory'] == 0)
			{	
				//$totalProduct = $this->Categories_products_m->count_by(array('category_id'=>$post['catId']));
				$where = " category_id ='".$post['catId']."' ORDER BY product_id ASC LIMIT ".$post['offset'].",10";

				$sql = "SELECT p.product_id FROM  oc_product as p INNER JOIN oc_product_to_category as pc ON p.product_id = pc.product_id
		 		where pc.category_id=".$post['catId']."  AND p.stock_status_id=7 AND p.status=1 "; 
				$query = $this->db->query($sql);
				$newcount=  $query->result();
				//echo $this->db->last_query();exit;
				$totalProduct = count($newcount);
				//echo $totalProduct;exit;

			 	$sql12 = "SELECT pc.* FROM  oc_product as p INNER JOIN oc_product_to_category as pc ON p.product_id = pc.product_id
			 	where pc.category_id=".$post['catId']."  AND p.stock_status_id=7 AND p.status=1  ORDER BY p.product_id DESC LIMIT ".$post['offset'].",10"; 

				$query = $this->db->query($sql12);
				$productArray = $query->result();



			}
			elseif($post['isSubcategory'] == 1)
			{
				//$totalProduct = $this->Categories_products_m->count_by(array('category_id'=>$post['subCatId']));
				$where = " category_id ='".$post['subCatId']."' ORDER BY product_id DESC LIMIT ".$post['offset'].",10";



			$sql = "SELECT p.product_id FROM  oc_product as p INNER JOIN oc_product_to_category as pc ON p.product_id = pc.product_id
		 	where pc.category_id=".$post['subCatId']."  AND p.stock_status_id=7 AND p.status=1 "; 
			$query = $this->db->query($sql);
			$newcount=  $query->result();
			//echo $this->db->last_query();exit;
			$totalProduct = count($newcount);
			//echo $totalProduct;exit;

		 	$sql12 = "SELECT pc.* FROM  oc_product as p INNER JOIN oc_product_to_category as pc ON p.product_id = pc.product_id
		 	where pc.category_id=".$post['subCatId']."  AND p.stock_status_id=7 AND p.status=1  ORDER BY p.product_id DESC LIMIT ".$post['offset'].",10"; 

			$query = $this->db->query($sql12);
			$productArray = $query->result();
			//echo '<pre>';print_r($productArray);exit;

			//echo $this->db->last_query();exit;

			//echo $totalProduct;exit;

				
			}

			/*$productArray = $this->Categories_products_m->get_many_by($where);*/


			/*$sql = "SELECT * FROM oc_product_to_category where ".$where;
			$query = $this->db->query($sql);
			$productArray = $query->result();*/

		


			//echo '<pre>';print_r($rows);exit;

			//echo '<prE>';print_r($productArray);exit;
			$wherecon = "key ='config_currency'";
			$settings = $this->Setting_m->get_by($wherecon);
			

			$currencydetail = $this->Currency_m->get_by(array('code'=>$settings->value,'status'=>1));
			$taxdetails = $this->Taxrate_m->get_by();
			$taxrate = (int)$taxdetails->rate;

			
			if($totalProduct > 0)
			{

				$response['success'] = 1;
				$response['total'] = $totalProduct;
				//echo $totalProduct;exit;
				$mainProdArr = array();
				for($i=0;$i<count($productArray);$i++)
				{
					//echo 'test';exit;
					$innerarr = array();
						if($post['languageCode'] == 'en')
						{
							$language = $this->Language_m->get_by(array('name'=>'English'));
							$this->lang->load('Webservice', 'english');
						}
						elseif($post['languageCode'] == 'ar')
						{
							$language = $this->Language_m->get_by(array('name'=>'Arabic'));
						}
						elseif($post['languageCode'] == 'es')
						{
								$language = $this->Language_m->get_by(array('code'=>'es-es'));
								$this->lang->load('Webservice', 'spanish');
						}
						elseif($post['languageCode'] == 'ru')
						{
								$language = $this->Language_m->get_by(array('code'=>'ru-ru'));
								$this->lang->load('Webservice', 'russian');
						}

					if($language == '')
						$language = 1;
					else
						$language = $language->language_id;

					//echo $productArray[$i]->product_id; exit;

					$productDetail = $this->Products_m->getProductDetail($productArray[$i]->product_id,$language);
					//echo "<prE>";print_r($productDetail);exit;
					
					
					if($productDetail != '')
					{


						$productPriceF  = $this->Products_m->getProductPrice($productArray[$i]->product_id, $post['userId']);
						//echo $productPriceF->price;exit;
						//echo $productPrice->price;
						$innerarr['productId'] = $productArray[$i]->product_id;
						$innerarr['name'] = $productDetail->name;
						$innerarr['model'] = $productDetail->model;
						//$innerarr['rewardPoints'] = $productDetail->rewardPoints;
						//$innerarr['priceRewardPoints'] = $productDetail->points;
						//$innerarr['extax'] = $productDetail->extax;
						//$innerarr['availability'] = $productDetail->availability;
						//$innerarr['description'] = html_entity_decode($productDetail->description);
						$innerarr['currencyCode'] = $currencydetail->symbol_left;
						
							$innerarr['price'] = number_format((float)$productPriceF->price, 2, '.', '');	
						
						
						if($productDetail->extax == '')
						{
							$innerarr['specialPrice'] = "";
						}
						elseif($productDetail->extax == 0.00)
						{
							$innerarr['specialPrice'] = "";
						}
						else
						{
							$vatprice = $this->mypercentagecal($productDetail->extax,$taxrate);
							$innerarr['specialPrice'] = number_format((float)$productDetail->extax, 2, '.', '');
							$specialPrice = $innerarr['specialPrice'];
							$innerarr['specialPrice'] = number_format((float)$specialPrice, 2, '.', '');
						}
						$innerarr['minQuantity'] = $productDetail->minimum;
						$innerarr['quantity'] = $productDetail->minimum;
						$innerarr['minQuantityDesc'] = "This product has a minimum quantity of ".$productDetail->minimum;

						if($post['userId'] != "")
						{
							$prodCount = $this->Wishlist_m->Count_by(array( 'customer_id' => $post['userId'],'product_id'=> $productArray[$i]->product_id));

							$innerarr['isfavourite'] = (string)$prodCount;
						}
						else
						{
							$innerarr['isfavourite'] = "0";
						}

						if($productDetail->image == '')
						{
							$innerarr['thumbImage'] =  "";
						}
						else
						{
							$innerarr['thumbImage'] = (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $server.'/image/'.$productDetail->image;
						}
						
						$checkMandatory = $this->Options_m->checkMandatory($productArray[$i]->product_id);
						if($checkMandatory != '')
						{
							$innerarr['isOptions'] = "1";
						}
						else
						{
							$innerarr['isOptions'] = "0";
						}

						$categoryArr[] = $innerarr;
					}
				}
				
				$response['result'] = $categoryArr;
				$response = $this->convertNullToString($response);
				echo json_encode($response);exit;
			}
			else
			{
				echo json_encode(array("success" => 0, "message" => $this->lang->line("No product found"), "total"=>0 ));exit;
			}
		}
		catch(Exception $e)
		{
			$response = array();
			$response['success'] = 0;
			$response['message'] = $e->getMessage();
			echo json_encode($response);exit;
		}	
	}

	/*function accessObjectArray($var)
	{
  		return $this->$var;
	}*/

	public function mypercentagecal($prdprice,$rate)
	{
		$newprice=$prdprice * $rate/100;
		return $newprice;
	}
	
	public function sendCode()
	{
		$input = file_get_contents('php://input');
		$post = json_decode($input, true);		
		//$post['phone'] = '+919099671966';
		try
		{
			if((!isset($post['phone'])) || (!isset($post['email'])) || (!isset($post['isForgot'])))
			{
				throw new Exception("Please fill in all the required fields.");
			}

			if( $post['phone'] == '' || $post['phone'] == '0'  || $post['isForgot'] == '')
			{
				throw new Exception("Error in post data.");
			}


			if($post['isForgot'] == '0')
			{
				if( $post['email'] == '' || $post['email'] == '0')
				{
					throw new Exception("Error in post data.");
				}
				$where = " telephone ='".$post['phone']."' OR email ='".$post['email']."'";
				$userRec = $this->Customers_m->get_by($where);
				if(isset($userRec->customer_id))
				{
					echo json_encode(array("success" => 0, "message" => "The mobile number or email already exists." ));exit;
				}
				else
				{
					$digits = 4;
					$randomno =  rand(pow(10, $digits-1), pow(10, $digits)-1);
					$insertdata = array('otp' => $randomno);
					$this->OTP_m->insert($insertdata);
					$insert_id = $this->db->insert_id();

					$sid = 'ACa36907bc352e2f3e69f3f96c08f47fb9';
					$token = '454d12100d17ebdc4e23d4dbecb2bcff';
					$client = new Client($sid, $token);

					// Use the client to do fun stuff like send text messages!
					$client->messages->create(
					  
					    $post['phone'],
					    array(
					        'from' => '+12407861700',
					        'body' => 'Please verify your mobile number by entering OTP, '.$randomno.' is your OTP.Thanks Tabumark.'
					    )
					);
				
					$message = 'Please verify your mobile number by entering OTP, '.$randomno.' is your OTP.Thanks Tabumark.';
					$this->sendMail($post['email'],$message);

					$response['success'] = 1;
					$response['message'] = "OTP Sent to your mobile number and email, Please verify the mobile number to register your account.";

					$response['result'] = array(
							"id"	 	=> (string)$insert_id, 
							"otp" 		=> (string)$randomno
						);
					echo json_encode($response);exit;
				}
			}
			else if($post['isForgot'] == '1')
			{
				$userRec = $this->Customers_m->get_by(array( 'telephone' => $post['phone']));

				if($userRec == '')
				{
					throw new Exception("Mobile number not exist. Please try again.");
				}
				$digits = 4;
				$randomno =  rand(pow(10, $digits-1), pow(10, $digits)-1);
				$insertdata = array('otp' => $randomno);
				$this->OTP_m->insert($insertdata);
				$insert_id = $this->db->insert_id();

				
				$sid = 'ACa36907bc352e2f3e69f3f96c08f47fb9';
				$token = '454d12100d17ebdc4e23d4dbecb2bcff';
				$client = new Client($sid, $token);

				// Use the client to do fun stuff like send text messages!
				$client->messages->create(
				  
				    $post['phone'],
				    array(
				        'from' => '+12407861700',
				        'body' => 'Please verify your mobile number by entering OTP, '.$randomno.' is your OTP.Thanks Tabumark.'
				    )
				);

				$message = 'Please verify your mobile number by entering OTP, '.$randomno.' is your OTP.Thanks Tabumark.';
				$this->sendMail($userRec->email,$message);
				$response['success'] = 1;
				$response['message'] = "OTP Sent to your mobile number and email, Please verify the mobile number to change your password.";


				$response['result'] = array(
						"id"	 	=> (string)$insert_id, 
						"otp" 		=> (string)$randomno
					);
				echo json_encode($response);exit;
			}
			else if($post['isForgot'] == '2')
			{
				if( $post['email'] == '' || $post['email'] == '0')
				{
					throw new Exception("Error in post data.");
				}
				$where = " telephone ='".$post['phone']."'";
				$userRec = $this->Customers_m->get_by($where);
				if(isset($userRec->customer_id))
				{
					echo json_encode(array("success" => 0, "message" => "The mobile number already exists." ));exit;
				}
				else
				{
					$digits = 4;
					$randomno =  rand(pow(10, $digits-1), pow(10, $digits)-1);
					$insertdata = array('otp' => $randomno);
					$this->OTP_m->insert($insertdata);
					$insert_id = $this->db->insert_id();


					/*$sid = 'ACa36907bc352e2f3e69f3f96c08f47fb9';
					$token = '454d12100d17ebdc4e23d4dbecb2bcff';
					$client = new Client($sid, $token);

					// Use the client to do fun stuff like send text messages!
					$client->messages->create(
					  
					    $post['phone'],
					    array(
					        'from' => '+12407861700',
					        'body' => 'Please verify your mobile number by entering OTP, '.$randomno.' is your OTP.Thanks Tabumark.'
					    )
					);*/

				
					$message = 'Please verify your mobile number by entering OTP, '.$randomno.' is your OTP.Thanks Tabumark.';
					$this->sendMail($post['email'],$message);

					$response['success'] = 1;
					$response['message'] = "OTP Sent to your mobile number and email, Please verify the mobile number to register your account.";

					$response['result'] = array(
							"id"	 	=> (string)$insert_id, 
							"otp" 		=> (string)$randomno
						);
					echo json_encode($response);exit;
				}
			}
		}
		catch(Exception $e)
		{
			$response = array();
			$response['success'] = 0;
			$response['message'] = $e->getMessage();
			echo json_encode($response);exit;
		}	
	}

	public function verifyCode()
	{
		$input = file_get_contents('php://input');
		$post = json_decode($input, true);
		try
		{
			if(empty($post['id']) ||  empty($post['otp']))
			{
				throw new Exception("its look like your are spammer.");
			}

			$otpDetail = $this->OTP_m->get_by(array( 'id' => $post['id'],"otp"=>$post['otp']));
			
			if($otpDetail != '')
			{
				$this->OTP_m->delete($post['id']);
				echo json_encode(array("success" => 1, "message" => "OTP verified successfully." ));exit;
			}
			else
			{
				echo json_encode(array("success" => 0, "message" => "OTP verification failed. Please try again." ));exit;
			}
		}catch(Exception $e)
		{
			$response = array();
			$response['success'] = 0;
			$response['message'] = $e->getMessage();
			echo json_encode($response);exit;
		}	
	}


	function token($length = 32) 
	{
		// Create random token
		$string = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
		
		$max = strlen($string) - 1;
		
		$token = '';
		
		for ($i = 0; $i < $length; $i++) {
			$token .= $string[mt_rand(0, $max)];
		}	
		
		return $token;
	}

	function convertNullToString($mainArr)
	{
		$isObject=0;
	    if(is_object($mainArr))
	    {
	      $isObject=1;
	      $mainArr=(array)$mainArr;
	    }
	    if(is_array($mainArr))
	    {
	        if(count($mainArr)>1)
	        {
	          foreach ($mainArr as $Rkey => $innerArr) {
	            $mainArr[$Rkey]= $this->convertNullToString($innerArr);
	          }

	          if($isObject==1)
	            $mainArr=(object)$mainArr;

	          return $mainArr;
	        }
	        else
	       	{
	          	$mainArr= array_map(function($value1) 
	        	{
	            	return $value1 === NULL ? "" : $value1;
	        	}, $mainArr);
	          	return $mainArr;  
	        }
	    }
	    else
	    {     
	    	return $mainArr === NULL ? "" : $mainArr;
	    }
	}

	public function sendMail($email,$message)
	{
	    
	    
		
		$this->load->library('email');
		$config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
        $this->email->initialize($config);
        /*$messge = '';
        $messge = 'Congratulations, your Boon4Driver account has been approved! You now have access to the largest on-the-way delivery network in the region';*/
        $this->email->from('harmistest@gmail.com');
        $this->email->to("harmistest@gmail.com");
        $this->email->subject('Tabumark Registration Verification OTP.');
        $this->email->message($message);
        $message=$this->email->send();

       return $message;exit;
    }
    
    public function mailtest()
    {
        
        
        $this->load->library('email'); 
        $this->email->from('harmistest@gmail.com', 'Sender Name');
        $this->email->to('info@iraqcars.net','Recipient Name');
        $this->email->subject('Your Subject');
        $this->email->message('Your Message'); 
        try{
        $this->email->send();
        echo 'Message has been sent.';
        }catch(Exception $e){
        echo $e->getMessage();
        }
        
        exit;
        
        
        
        
       //Load email library
            $this->load->library('email');
            
            //SMTP & mail configuration
            $config = array(
                'protocol'  => 'smtp',
                'smtp_host' => 'ssl://smtp.mail.ru',
                'smtp_port' => 25,
                'smtp_user' => 'bespalov-89@mail.ru',
                'smtp_pass' => '777kireevbes210989',
                'mailtype'  => 'html',
                'charset'   => 'utf-8'
            );
            $this->email->initialize($config);
            $this->email->set_mailtype("html");
            $this->email->set_newline("\r\n");
            
            //Email content
            $htmlContent = '<h1>Sending email via SMTP server</h1>';
            $htmlContent .= '<p>This email has sent via SMTP server from CodeIgniter application.</p>';
            
            $this->email->to('harmistest@gmail.com');
            $this->email->from('bespalov-89@mail.ru','MyWebsite');
            $this->email->subject('How to send email via SMTP server in CodeIgniter');
            $this->email->message($htmlContent);
            
            //Send email
            $this->email->send();
            
            echo "send"; exit;
    }
}
?>