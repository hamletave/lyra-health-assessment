<?php

$changes = new GetLeadChanges();
$changes->fields = ["activatedDate"];
$changes->covertArray();

class GetLeadChanges{
	private $host = "https://359-gqr-502.mktorest.com";
	private $clientId = "8b4d35d0-c6cc-4d1c-b83e-157c85e5ceb9";
	private $clientSecret = "RPmIIG0njy4je0akdqzyQztQMykkn0XD";
	public $fields; //array of field names to retrieve changes for, required
	public $nextPageToken;
	public $batchSize; //max 300, default 300
	public $listId = 4648;
	
	// Get data from Marketo API
	public function getData(){
		$nextPageToken = "KMFQHCJHNS22QFZPHYJAKLVCHVRO6BO2FTDRBPTBPVBDYRKQHUIA====";
		$response_array = array();
		// while($nextPageToken !== false) {
			$url = $this->host . "/rest/v1/activities/leadchanges.json?access_token=" . $this->getToken() . "&fields=" . $this::csvString($this->fields) . "&nextPageToken=" . $nextPageToken;
		
			if (isset($this->batchSize)){
			$url .= "&batchSize=" . "$this->batchSize";
			}

			if (isset($this->listId)){
			$url .= "&listId=" . $this->listId; 
			}

			echo $url;

			$ch = curl_init();          
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array("accept: application/json"));
			
			$response = curl_exec($ch);
			$response = json_decode($response, true);
                                                                                                                                         
			$nextPageToken = $response['nextPageToken'];

			if($response['moreResult'] !== true) {
				$nextPageToken = false;
			} else {
				array_push($response_array, $response);
			}
		// }

		return $response_array;
	}

	// Save API array data to CSV file
	public function covertArray(){
		$leadIds = array();
		$oldValues = array();
		$newValues = array();

		foreach ($this->getData() as $fields) {
			foreach ($fields['result'] as $field) {
				array_push($leadIds, $field['leadId']);
			}
		}

		foreach ($this->getData() as $fields) {
			foreach ($fields['result'] as $field) {
				foreach ($field['fields'] as $fields) {
					array_push($oldValues, $fields['oldValue']);
				}
			}
		}		

		foreach ($this->getData() as $fields) {
			foreach ($fields['result'] as $field) {
				foreach ($field['fields'] as $fields) {
					array_push($newValues, $fields['newValue']);
				}
			}
		}

		$merged_arrays = array_map(function($item) {
			return array_combine(['leadId', 'oldValue', 'newValue'], $item);
		}, array_map(null, $leadIds, $oldValues, $newValues));
		
		$fp = fopen('leads.csv', 'w');

		$result = [];
		foreach ($merged_arrays as $record) {   
			$key = $record['leadId'];
			if (array_key_exists($key, $result)) {
				$result[$key] = array_merge($result[$key], $record);
			}else{
				$result[$key] = $record;
			}
		}
			
		foreach ($result as $fields) {
			fputcsv($fp, $fields);
		}
		 
		fclose($fp);
	}
	
	// Get Access Token
	private function getToken(){
		$ch = curl_init($this->host . "/identity/oauth/token?grant_type=client_credentials&client_id=" . $this->clientId . "&client_secret=" . $this->clientSecret);
		curl_setopt($ch,  CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('accept: application/json',));
		$response = json_decode(curl_exec($ch));
		curl_close($ch);
		$token = $response->access_token;
		return $token;
	}

	// Convert API fields to CSV format
	private static function csvString($fields){
		$csvString = implode(",", $fields);
		return $csvString;
	}
}
?> 