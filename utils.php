<?php 

	function toJS($value)
	{
		echo '\''.addslashes(htmlspecialchars($value)).'\'';
	}

	function quote($value){
		return '"'.$value.'"';
	}
	function htmlquote($value){
		return quote(htmlspecialchars($value));
	}

	class Response{

		public $status;
		public $message;
		public $data;

		function __construct($status,$message,$data){
			$this->status = $status;
			$this->message = $message;
			$this->data = $data;
		}

		public function GetAsJson(){
			$response['status'] = $this->status;
			$response['message'] = $this->message;
			$response['data'] = $this->data;

			return json_encode($response);
		}

		public function Send(){
			header("HTTP/1.1 ". $this->status);
			echo $this->GetAsJson();
			die();
		}
	}
?>