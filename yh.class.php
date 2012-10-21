<?php
/*
The unofficial YouHosting API
We are asking for it for years but YH still didn't make it!
It's time to do make it ourself!
CC-BY Maarten Eyskens
*/
class yh{
    //let's do what youhosting hasn't done for years, serious coding
    private $login='YHLOGIN';
    private $pass='YHPASS';
    
    private function GetBetween($content,$start,$end){
        $r = explode($start, $content);
        if (isset($r[1])){
            $r = explode($end, $r[1]);
            return $r[0];
        }
    }
    private function connect($url){
        $tmp_fname = tempnam("/tmp", "COOKIE");
        
        //hack the security code
        $file=file_get_contents("http://www.youhosting.com/en/auth");
        $output=$this->GetBetween($file,"document.write(",");");
        $alphas = array_merge(range('A', 'Z'), range('a', 'z'));
        $delete=array('"',"'","+","<",">"," ","=");
        $key=str_replace($delete,"",$output);
        $key=str_replace($alphas,"",$key);
        $delete=array("'","+","<",">"," ");
        $name=str_replace($delete,"",$output);
        $name= $this->GetBetween($name,'inputname="','"');
        
        //now we can login
        $curl_handle = curl_init ("http://www.youhosting.com/en/auth");
        curl_setopt ($curl_handle, CURLOPT_COOKIEJAR, $tmp_fname);
        curl_setopt ($curl_handle, CURLOPT_RETURNTRANSFER, true);
	    $post_array = array('submit'=>'Login', 'email' => $this->login, 'password' => $this->pass, $name=>$key);
	    curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $post_array);
	    $output = curl_exec ($curl_handle);
        //we are logged in now
        
        //let's get the content
	    $curl_handle = curl_init ($url);
	    curl_setopt ($curl_handle, CURLOPT_COOKIEFILE, $tmp_fname);
	    curl_setopt ($curl_handle, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec ($curl_handle);
        return $output;
    } 
    
    public function numclients(){
        $output=$this->GetBetween($this->connect("http://www.youhosting.com"),'<a href="/en/client">','</a>');
        return $output;
    }
    public function numaccounts(){
        $output=$this->GetBetween($this->connect("http://www.youhosting.com"),'<a href="/en/client-account/manage/status/active">','</a>');
        return $output;
    }
    public function clientidbyemail($email){
        $email=urlencode($email);
        $id=$this->GetBetween($this->connect("http://www.youhosting.com/en/client/manage?email=meyskens%40me.com&submit=Search"),'<a class="" href="/en/client/view/id/','">');
        return $id;
    }
    
    public function userdata($id,$data){
        $page=$this->GetBetween($this->connect("http://www.youhosting.com/en/client/view/id/$id"),'<div class="b-cont">','<div>');
        $dom = new DOMDocument();
        $dom->loadHTML($page);
        $tables = $dom->getElementsByTagName('table');
        $rows = $tables->item(0)->getElementsByTagName('tr');
    
        foreach ($rows as $row) {
            $cols = $row->getElementsByTagName('td');
            $key=$cols->item(0)->nodeValue;
            $value=$cols->item(1)->nodeValue;
            if ($key==$data){
                return $value;
            }
        }
        
    }
    
    //this is something special
     public function createuser($email,$pass,$country,$fname){
        $tmp_fname = tempnam("/tmp", "COOKIE");
        $email= urlencode($email);
        $pass= urlencode($pass);
        $fname= urlencode($fname);
        $country= urlencode($country);
         //hack the security code
        $file=file_get_contents("http://www.youhosting.com/en/auth");
        $output=$this->GetBetween($file,"document.write(",");");
        $alphas = array_merge(range('A', 'Z'), range('a', 'z'));
        $delete=array('"',"'","+","<",">"," ","=");
        $key=str_replace($delete,"",$output);
        $key=str_replace($alphas,"",$key);
        $delete=array("'","+","<",">"," ");
        $name=str_replace($delete,"",$output);
        $name= $this->GetBetween($name,'inputname="','"');
        
        //now we can login
        $curl_handle = curl_init ("http://www.youhosting.com/en/auth");
        curl_setopt ($curl_handle, CURLOPT_COOKIEJAR, $tmp_fname);
        curl_setopt ($curl_handle, CURLOPT_RETURNTRANSFER, true);
        $post_array = array('submit'=>'Login', 'email' => $this->login, 'password' => $this->pass, $name=>$key);
	    curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $post_array);
	    $output = curl_exec ($curl_handle);
        //we are logged in now
        
        //let's create a user
	    $curl_handle = curl_init ('http://www.youhosting.com/en/client/add');
	    curl_setopt ($curl_handle, CURLOPT_COOKIEFILE, $tmp_fname);
        curl_setopt ($curl_handle, CURLOPT_RETURNTRANSFER, true);
        $post_array = array('email' => $email, 'first_name'=>$fname, 'country'=> $country, 'password' => $pass, 'password_confirm'=>$pass, 'send_email'=>'1','submit'=>'Save', );
	    curl_setopt ($curl_handle, CURLOPT_RETURNTRANSFER, $post_array);
        $output = curl_exec ($curl_handle);
        return $output;
    } 
    
}