<?php
/**
InInboxApiLib by Circlewaves Team

PHP Library for easy integration with ININBOX service - http://www.ininbox.com/

* @package   		InInboxApiLib
* @subpackage   InInboxBase
* @author    		Max Kostinevich <max@circlewaves.com>
* @license   		http://opensource.org/licenses/mit-license.php MIT License 
* @link      		http://circlewaves.com
* @copyright 		2014 Circlewaves LLC (support@circlewaves.com)
* @see 					http://www.ininbox.com/api
* @version 			1.0
*/

class InInboxBase{

	var 
	$api_key = '',
	//$api_url='http://www.ininbox.com/api/v1/', //old api url
	$api_url='http://api.ininbox.com/v1/',	//new api url
	$curl=true,
	$curlExists = true;
	
	
	/**
	* @param string $api Your API key.
	*/
	function InInboxBase($api_key=null){
		$this->api_key = $api_key;
		$this->curlExists = function_exists( 'curl_init' ) && function_exists( 'curl_setopt' );	
	}
	
	/**
	* The direct way to make an API call. 
	*
	* @param string $action The API call.
	* @param string $format API call format - json or xml.
	* @param array $options An associative array of values to send as part of the request.
	* @return array parsed to array XML or JSON response.
	*/	
	function makeCall( $action = '', $format='json', $options = null ){
	
		if ( isset( $options['params'] ) ){
				$postdata = $options['params'];
			}
	
		if ( $this->curl && $this->curlExists ){
		
			//$url = "http://www.ininbox.com/api/v1/contacts/create.xml";
		//	$url = "http://www.ininbox.com/api/v1/.json";
			$url=$this->api_url.$action.'.'.$format;
			$ch = curl_init( );
			# Setup request to send json via POST.
			$postdata = json_encode( $postdata );

			curl_setopt($ch, CURLOPT_URL,$url); 
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");  

			//$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code

			curl_setopt($ch, CURLOPT_FAILONERROR, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); // Returns result to a variable instead of echoing
			curl_setopt($ch, CURLOPT_TIMEOUT, 3); // Sets a time limit for curl in seconds (do not set too low)
			//curl_setopt($ch, CURLOPT_POST, 1); // Set curl to send data using post

			curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
			curl_setopt($ch, CURLOPT_USERPWD, $this->api_key.":");

			curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
			if($format=='json'){
				curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Content-Length: ' . strlen($postdata)));
			}


			# Send request.
			$result = curl_exec($ch);
			curl_close($ch);
			
			if($format=='json'){
				return json_decode($result, true);	
			}
		}

	return $result;		
	
	}
	
	/**
	* contactAdd() - Adds contact to your list
	*
	* @param string $email Email address.
	* @param string $name User's name.
	* @param array $listids. Array of a valid Lists IDs.
	* @param array $custom_fields. Additional fields and options  such as address, company, resubscribe
	* @link http://www.ininbox.com/api/contact
	*/
	
	function contactAdd( $email, $listids, $custom_fields=null ){

		if($email && $listids){
		
			$action='contacts/create';
			$format='json';
			
			return $this->makeCall( $action,$format,
				array(
					'params' => array(
						'Email' => $email,
						'ListIDs' => $listids
					)
				)
			);
		}
	}	

}
?>