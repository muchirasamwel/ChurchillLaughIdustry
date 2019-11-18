<?php 

class Mpesa{
	function __construct(){
		$this->consKey="yyGTRIEcoYSWGGoHIgZgjhN8242a28G3";
		$this->consSecret="rwZxDhRPsAmlq8HX";
		$this->headers=['Content-Type:application/json; charset=utf8'];
		$this->shortCode1=2;
		$this->onlineLipaNaMpesaBusinessShortCode=174379;
		$this->initiatorName="samwel";
		$this->securityCredential="Xj33943g";
		$this->msisdn=254708374149;

		//enter domain name and path to the folder payment_api
		$myDomain="";

		$this->confirmationUrl=$myDomain."/payment_api/confirmation_main.php'";
		$this->validationUrl=$myDomain."/payment_api/validation_main.php";

		$this->accessToken=$this->getAccessToken();
	}

	private function getAccessToken(){
		$url="https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";
		//$url="https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";
		$curl = curl_init($url);

		curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($curl, CURLOPT_HEADER, FALSE);
		curl_setopt($curl, CURLOPT_USERPWD, $this->consKey.':'.$this->consSecret);
		$result = curl_exec($curl);
		$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		$result = json_decode($result);
	
		curl_close($curl);

		return $result->access_token;
	}

	public function regUrl(){
		//make sure not to use test urls when using a live shortcode
		$url="https://sandbox.safaricom.co.ke/mpesa/c2b/v1/registerurl";
		//$url="https://api.safaricom.co.ke/mpesa/c2b/v1/registerurl";
		$curl = curl_init($url);

		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$this->accessToken));

		$curl_post_data = array(
		  //Fill in the request parameters with valid values
		  'ShortCode' => $this->shortCode1,
		  'ResponseType' => 'Cancelled',
		  'ConfirmationURL' => $this->confirmationUrl,
		  'ValidationURL' => $this->validationUrl
		);

		$data_string = json_encode($curl_post_data);

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
		
		$curl_response = curl_exec($curl);

		curl_close($curl);

		return $curl_response;
	}

	public function simulateTrans($amount){
		$url = 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/simulate';
		//$url = 'https://api.safaricom.co.ke/mpesa/c2b/v1/simulate';
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$this->accessToken));

		$curl_post_data = array(
			'ShortCode' => $this->shortCode1,
			'CommandID' => 'CustomerPayBillOnline',
			'Amount' => $amount,
			'Msisdn' => $this->msisdn,
			'BillRefNumber' => 101002
		);

		$data_string = json_encode($curl_post_data);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

		$curl_response = curl_exec($curl);
		echo $curl_response;

		curl_close($curl);

		return $curl_response;
	}
}

 ?>