<?php

class Emailer {
  
  var $subject;
  var $body;
  var $to;
  var $from;
  
  function setSubject($s){
    $this->subject=$s;
  }
  
  function bodyAdd($t){
    $this->body.=$t;
    $this->body.="\n";
    //$this->body.="<BR>";
  }
  
  function setTo($s){
    $this->to=$s;
  }
  
  function setFrom($s){
    $this->from=$s;
  }
  
  function send(){
    $headers="From: ".$this->from."\r\n";
    $headers.="X-Mailer: CJSMailSystem\r\n";
    $headers.= "MIME-Version: 1.0\r\n";
    $headers.= "Content-type: text/html; charset=iso-8859-1\r\n";
    
    $this->body="<HTML><PRE>".$this->body."</pre></html>";
    
    return mail($this->to, $this->subject, $this->body, $headers);
  }
}

?>
