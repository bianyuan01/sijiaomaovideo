<?php 
class curl{
    /*
     * post 请求数据
     * 
     * @param string  $url            请求地址
     * @param mix     $data           请求的数据
     * @param int     $withhead       是否返回请求头信息
     * @param string  $cookie         请求时附加的cookie信息
     * @param string  $reffer         请求来路
     * @param boolean $ssl            加密请求
     * @param boolean $followlocation 是否跟随跳转
     */
    
    static function post($url,$data,$withhead=0,$cookie='',$reffer='',$ssl=false,$followLocation=0,$custom_head = array()){
       $ch = curl_init($url);

	   curl_setopt($ch, CURLOPT_TIMEOUT, 10);

       //ssl
       if($ssl){
           curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
           curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
       }
       
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
       curl_setopt($ch, CURLOPT_POST, 1);
       curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
       curl_setopt($ch, CURLOPT_HEADER, $withhead);
       
       //cookie 
       if($cookie){
           curl_setopt($ch, CURLOPT_COOKIE, $cookie);     
       }
	   
	   //reffer
       if($reffer){
			curl_setopt ($ch,CURLOPT_REFERER,$reffer);
		}
		
       //ua
       $ua = self::get_ua();
       curl_setopt($ch, CURLOPT_USERAGENT, $ua);
       
       //followLocation
       if($followLocation){
       		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, $followLocation);	       	
       }
       
       //custom_head
       if($custom_head){
           curl_setopt($ch, CURLOPT_HTTPHEADER , $custom_head);
       }
       
       $ret = curl_exec($ch);
       curl_close($ch);
       return $ret;  
    }
    
    /*
     * get 请求数据
     * 
     * @param string  $url            请求地址
     * @param int     $withhead       是否返回请求头信息
     * @param string  $cookie         请求时附加的cookie信息
     * @param string  $reffer         请求来路
     * @param boolean $followlocation 是否跟随跳转
     * @param boolean $ssl            加密请求
     */
    static function get($url,$withhead=0,$cookie='',$reffer='',$followLocation=0,$ssl=false){
        $ch = curl_init($url);
		
        $timeout = 30;
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);

		if($ssl){
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        }
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_HEADER, $withhead);
        if($cookie){
            curl_setopt($ch, CURLOPT_COOKIE, $cookie);
        }
        
		//reffer
       if($reffer){
			curl_setopt ($ch,CURLOPT_REFERER,$reffer);
		}
		
        //follow location
        if($followLocation){
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, $followLocation);
        }
        
        $ua = self::get_ua();
        curl_setopt($ch, CURLOPT_USERAGENT, $ua);
        $ret = curl_exec($ch);
        if(!$ret){
            var_dump(curl_error($ch));
        }
        curl_close($ch);

        return $ret;
    }
    
    static function get_ua(){
		return 'MicroMessenger';
        return 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0';
        //return 'Mozilla/5.0 (Linux; U; Android 4.0.3; zh-cn; M032 Build/IML74K) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30';
    }
}