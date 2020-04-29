<?php

class ozekisend {
	private $host;
	private $port;
	private $user;
	private $pass;
	
	function __construct($host,$port,$user,$pass){
		$this->host=$host;
		$this->port=$port;
		$this->user=$user;
		$this->pass=$pass;
	}
	
	public function get_param_list() {
		print('Host: '.$this->host.' Port: '.$this->port.' User name: '.$this->user.' Password: '.$this->pass);
	}
	
	private function make_url(){
		$ozekiurl='http://'.$this->host.':'.$this->port.'/api?';
		return $ozekiurl;
	}
	
	private function httpRequest($url){
		$pattern = "/http...([0-9a-zA-Z-.]*).([0-9]*).(.*)/";
		preg_match($pattern,$url,$args);
		$in = "";
		$fp = fsockopen("$args[1]", $args[2], $errno, $errstr, 30);
		if (!$fp) {
			return("$errstr ($errno)");
		} 
		else {
			$out = "GET /$args[3] HTTP/1.1\r\n";
			$out .= "Host: $args[1]:$args[2]\r\n";
			$out .= "User-agent: Ozeki PHP client\r\n";
			$out .= "Accept: */*\r\n";
			$out .= "Connection: Close\r\n\r\n";

			fwrite($fp, $out);
			while (!feof($fp)) {
				$in.=fgets($fp, 128);
			}
		}
    fclose($fp);
    return($in);
	}

	public function ozekiSend($phone, $msg, $debug=false){
		$ozeki_url=$this->make_url();
		$url = 'username='.$this->user;
		$url.= '&password='.$this->pass;
		$url.= '&action=sendmessage';
		$url.= '&messagetype=SMS:TEXT';
		$url.= '&recipient='.urlencode($phone);
		$url.= '&messagedata='.urlencode($msg);
		$urltouse =  $ozeki_url.$url;	
		if ($debug) {
			echo "Request: <br>$urltouse<br><br>"; 
		}
		//Open the URL to send the message
		$response = $this->httpRequest($urltouse);
		if ($debug) {
			echo "Response: <br><pre>".
			str_replace(array("<",">"),array("&lt;","&gt;"),$response).
			"</pre><br>"; 
		}
		return($response);
	}

	function oz_response_parser($response){
		$ozeki_out = 0;
		$pieces=explode('<?xml',$response);
		$xml_to_use ='<?xml'.$pieces[1];
		$p = xml_parser_create();
		if (0==xml_parse_into_struct($p, $xml_to_use, $vals, $index)) {
			$ozeki_out =-1;
		}
		xml_parser_free($p);
		if ($vals['5']['value']!=0) {
			$ozeki_out = $vals['5']['value'];
		}
		return $ozeki_out;
	}

	
}

?>