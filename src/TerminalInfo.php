<?php
/**
 * @Author: pizepei
 * @Date:   2018-02-10 22:57:52
 * @Last Modified by:   pizepei
 * @Last Modified time: 2018-08-10 15:28:46
 */
namespace pizepei\terminalInfo;
use pizepei\terminalInfo\ToLocation;
use pizepei\config\Config;
/**
 * 访问客户端信息
 */
class TerminalInfo{
    /**
     * 模式  high[高性能只使用本地qqwry.dat数据]  precision[高精度 使用qqwry.dat+百度接口 可匹配出是否是手机网络 在手机网络下可匹配到城市] mixture[precision + mysql数据库 如果mysql中没有数据 使用precision获取数据 插入mysq中 ，如果mysql有数据匹配 不同就更新覆盖]
     * @var array
     */
    protected static $pattern = 'precision';

    /**
     * true 单例模式
     * @var string
     */
    public static $singleton = true;
    /**
     * ip
     * @var string
     */
    public static $ip ='';
    //浏览器类型
    public static  $AgentInfoBrower = array(  
                'MSIE' => 1,  
                'MicroMessenger' => 6,  
                'Firefox' => 2,  
                'QQBrowser' => 3,  
                'QQ/' => 4,  
                'UCBrowser' => 5,  
                'Edge' => 7,  
                'Chrome' => 8,  
                'Opera' => 9,  
                'OPR' => 10,  
                'Safari' => 11,  
                'Trident/' => 12,
            );
    //浏览器类型
    public static   $AgentInfoBroweInfo = array(  
                'IE(MSIE)' => 1,  
                '微信(MicroMessenger)' => 6,  
                '火狐(Firefox)' => 2,  
                '腾讯(QQBrowser)' => 3,  
                '腾讯(QQ/)' => 4,  
                'UC/支付宝(UCBrowser)' => 5,  
                'Edge' => 7,  
                '谷歌(Chrome)' => 8,  
                '欧朋(Opera)' => 9,  
                '欧朋(OPR)' => 10,  
                '苹果(Safari)' => 11,  
                'IE(Trident/)' => 12,
        );
    //操作系统
    public static  $OsInfo =[
            '其它系统'=> 0 ,//未知
            'Windows_95'=> 1,
            'Windows_ME'=> 2,
            'Windows_98'=> 3, 
            'Windows_Vista'=> 4, 
            'Windows_7'=> 5, 
            'Windows_8'=> 6, 
            'Windows_XP'=> 8,
            'Windows_2000'=> 9,  
            'Windows_10'=> 10,
            'Windows_32'=> 11,  
            'Linux'=> 12,  
            'Unix'=> 13,  
            'SunOS'=> 14,  
            'IBM_OS_2'=> 15,  
            'Macintosh'=> 16,  
            'PowerPC'=> 17,  
            'AIX'=> 18,  
            'HPUX'=> 19,  
            'NetBSD'=> 20,  
            'BSD'=> 21,  
            'OSF1'=> 22,  
            'IRIX'=> 23,  
            'FreeBSD'=> 24,  
            'teleport'=> 25,  
            'flashget'=> 26,  
            'webzip'=> 27,  
            'offline'=> 28,  
            'Android' => 29, 
            'iPhone' => 30,
        ];
    //操作系统
    public static  $IpInfoArr =['192.168.1.1','127.0.0.1','0.0.0.0'];
    //  百度地图api接口 配置
    //  申请地址http://lbsyun.baidu.com/
    public static  $BdApiKey = NULL;

    const unknown_os   = 0 ;//未知
    const Windows_95 = 1;
    const Windows_ME = 2;
    const Windows_98 = 3; 
    const Windows_Vista = 4; 
    const Windows_7 = 5; 
    const Windows_8 = 6; 
    const Windows_10 = 10;
    const Windows_XP = 8;  
    const Windows_2000 = 9;  
    const Windows_NT = 7;
    const Windows_32 = 11;  
    const Linux = 12;  
    const Unix = 13;  
    const SunOS = 14;  
    const IBM_OS_2 = 15;  
    const Macintosh = 16;  
    const PowerPC = 17;  
    const AIX = 18;  
    const HPUX = 19;  
    const NetBSD = 20;  
    const BSD = 21;  
    const OSF1 = 22;  
    const IRIX = 23;  
    const FreeBSD = 24;  
    const teleport = 25;  
    const flashget = 26;  
    const webzip = 27;  
    const offline = 28; 
    const Android = 29;  
    const iPhone = 30;
    /**
     * 获取浏览数据
     * @var array
     */
    public static $ArowserInfo = [];
    /**
     * [getArowserInfo 获取浏览数据]
     * @Effect
     * @return [type] [description]
     */
    public static function  getArowserInfo($type = 'arr'){
        /**
         * 判断是否获取过
         */
        if(static::$ArowserInfo && static::$singleton){
            return static::$ArowserInfo;
        }

        $arr['Ipanel'] =self::getAgentInfo();//获取浏览器内核

        $arr['language'] = self::get_lang();//获取浏览器语言

        $arr['Os'] = self::get_os();//获取操作系统

        $arr['IpInfo'] = self::getIpInfo();//时时ip信息

        if($arr['Os'] == 29){
            $arr['Build'] = self::getBuild();//获取安卓手机型号
            $arr['NetType'] = self::getBuildNetType();
        }else if($arr['Os'] == 30){
            $arr['Build'] = self::getBuildIPhone();
            $arr['NetType'] = self::getBuildNetType();
        }else{

        }
        $arr['ip'] = static::$ip;
        //判断返回格式
        return static::$ArowserInfo = $type == 'arr'?$arr:json_encode($arr);

    }

    /**
     * 完整的中文数据
     * @var array
     */
    public static $ArowserPro = [];
    /**
     * [getArowserPro 获取完整的中文数据]
     * @Effect
     * @param  string $type [description]
     * @return [type]       [description]
     */
    public static function  getArowserPro($type = 'arr'){
        /**
         * 判断是否获取过
         */
        if(static::$ArowserPro && static::$singleton){
            return static::$ArowserPro;
        }
        $arr['Ipanel'] =self::getAgentInfo(self::getAgentInfo());//获取浏览器内核

        $arr['language'] = self::get_lang();//获取浏览器语言

        $arr['Os'] =  self::get_os() ==29?self::get_os():array_search(self::get_os(),self::$OsInfo);//获取操作系统

        $arr['IpInfo'] = self::getIpInfo();//ip信息相关信息

        if(self::get_os() ==29){
            $Build = self::getBuild();
            $count = count($Build);
            if($count == 2){
                /**
                 * 0 系统 1 手机型号
                 */

                $arr['Build'] = $Build;//获取安卓手机型号
                $arr['Os'] = $Build[0];

            }else if($count == 1){
                $arr['Os'] = $Build[0];
            }else if($count >2){
                $arr['Os'] = implode('|',$Build);
                $arr['Build'] = &$Build;
            }
            $arr['NetType'] = self::getBuildNetType();
        }else if(self::get_os() == 30){

            $Build = self::getBuildIPhone();
            $count = count($Build);
            if($count >1){
                $count = $count-1;
                $count = $count == 0 ?'':$Build[$count];
                $arr['Os'] = $Build[1].' | '.$count;
            }else{
                $arr['Os'] = $Build[0];
            }
            // $arr['Os'] = $Build[0].' '.$Build[1];
            $arr['Build'] = $Build;
            $arr['NetType'] = self::getBuildNetType();
        }else{
            $arr['Os'] = array_search(self::get_os(),self::$OsInfo);//获取操作系统
            $arr['NetType'] = 'Ethernet';
        }

        $arr['ip'] = static::$ip;
        //判断返回格式
        return static::$ArowserPro = $type == 'arr'?$arr:json_encode($arr);
    }

    /**
     * [getAgentInfo 获取浏览器内核]
     * @Effect
     * @param  boolean $Data [浏览器内核 值]
     * @return [type]        [description]
     */
    public static function getAgentInfo($Data = false){
        //如果没有存入 浏览器内核 值 就是获取浏览器内核 值
        if(!$Data){
            $agent = $_SERVER['HTTP_USER_AGENT'];  
            $browser_num = 0;//未知  
            foreach(self::$AgentInfoBrower as $bro => $val){  
                if(stripos($agent, $bro) !== false){  
                    $browser_num = $val;  
                    break;  
                }
            }
            return  $browser_num;  
        }
        //存入就是获取 文字浏览器内核名称
        return array_search($Data,self::$AgentInfoBroweInfo);
    }

    /**
     * 获得访问者浏览器语言
     */
    public static function get_lang() {
        if (!empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            //只取前4位，这样只判断最优先的语言。如果取前5位，可能出现en,zh的情况，影响判断。  
            $lang = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
            $lang = substr($lang, 0, 5);
            if (preg_match("/zh-c/i", $lang))  
            $lang = "简体中文";  
            else if (preg_match("/zh/i", $lang))  
            $lang = "繁體中文";  
            else if (preg_match("/en/i", $lang))  
            $lang = "English";  
            else if (preg_match("/fr/i", $lang))  
            $lang = "French";  
            else if (preg_match("/de/i", $lang))  
            $lang = "German";  
            else if (preg_match("/jp/i", $lang))  
            $lang = "Japanese";  
            else if (preg_match("/ko/i", $lang))  
            $lang = "Korean";  
            else if (preg_match("/es/i", $lang))  
            $lang = "Spanish";  
            else if (preg_match("/sv/i", $lang))  
            $lang = "Swedish";  
            else
            $lang = "else";  

            return $lang;
        } else {
            return 'unknow';
        }
    }
    /**
     * [get_os 获取客户端操作系统信息包括]
     * @Effect
     * @return [type] [description]
     */
    public static function get_os(){  
    $agent = $_SERVER['HTTP_USER_AGENT'];  
        $os = false;  
        if (preg_match('/win/i', $agent) && strpos($agent, '95'))  
        {  
          $os = self::Windows_95;  
        }  
        else if (preg_match('/win 9x/i', $agent) && strpos($agent, '4.90'))  
        {  
          $os = self::Windows_95;    
        }  
        else if (preg_match('/win/i', $agent) && preg_match('/98/i', $agent))  
        {  
          $os =  self::Windows_98; 
        }  
        else if (preg_match('/win/i', $agent) && preg_match('/nt 6.0/i', $agent))  
        {  
          $os = self::Windows_Vista;  
        }  
        else if (preg_match('/win/i', $agent) && preg_match('/nt 6.1/i', $agent))  
        {  
          $os = self::Windows_7;  
        }  
          else if (preg_match('/win/i', $agent) && preg_match('/nt 6.2/i', $agent))  
        {  
          $os = self::Windows_8;  
        }else if(preg_match('/win/i', $agent) && preg_match('/nt 10.0/i', $agent))  
        {  
          $os = self::Windows_10;
        }else if (preg_match('/win/i', $agent) && preg_match('/nt 5.1/i', $agent))  
        {  
          $os = self::Windows_XP;  
        }  
        else if (preg_match('/win/i', $agent) && preg_match('/nt 5/i', $agent))  
        {  
          $os = self::Windows_2000;  
        }  
        else if (preg_match('/win/i', $agent) && preg_match('/nt/i', $agent))  
        {  
          $os = self::Windows_NT;  
        }  
        else if (preg_match('/win/i', $agent) && preg_match('/32/i', $agent))  
        {  
          $os = self::Windows_32;  
        }  
        else if (preg_match('/Android/i', $agent)){
          $os = self::Android;  
        }
        else if (preg_match('/linux/i', $agent))  
        {  
          $os = self::Linux;  
        }  
        else if (preg_match('/unix/i', $agent))  
        {  
          $os = self::Unix;  
        }  
        else if (preg_match('/sun/i', $agent) && preg_match('/os/i', $agent))  
        {  
          $os = self::SunOS;  
        }  
        else if (preg_match('/ibm/i', $agent) && preg_match('/os/i', $agent))  
        {  
          $os = self::IBM_OS_2;  
        }  
        else if (preg_match('/Mac/i', $agent) && preg_match('/PC/i', $agent))  
        {  
          $os = self::Macintosh;  
        }  
        else if (preg_match('/PowerPC/i', $agent))  
        {  
          $os = self::PowerPC;  
        }  
        else if (preg_match('/AIX/i', $agent))  
        {  
          $os = self::AIX;  
        }  
        else if (preg_match('/HPUX/i', $agent))  
        {  
          $os = self::HPUX;  
        }  
        else if (preg_match('/NetBSD/i', $agent))  
        {  
          $os = self::NetBSD;  
        }  
        else if (preg_match('/BSD/i', $agent))  
        {  
          $os = self::BSD;  
        }  
        else if (preg_match('/OSF1/i', $agent))  
        {  
          $os = self::OSF1;  
        }  
        else if (preg_match('/IRIX/i', $agent))  
        {  
          $os = self::IRIX;  
        }  
        else if (preg_match('/FreeBSD/i', $agent))  
        {  
          $os = self::FreeBSD;  
        }  
        else if (preg_match('/teleport/i', $agent))  
        {  
          $os = self::teleport;  
        }  
        else if (preg_match('/flashget/i', $agent))  
        {  
          $os = self::flashget;  
        }  
        else if (preg_match('/webzip/i', $agent))  
        {  
          $os = self::webzip;  
        }  
        else if (preg_match('/offline/i', $agent))  
        {  
          $os = self::offline;  
        }  
        else if (preg_match('/iPhone/i', $agent)){
          $os = self::iPhone;  
        }
        else  
        {  
          $os = self::unknown_os;  
        }  
        return $os;    
    }  

    /**
     * [get_os_show 获取文字标识系统显示]
     * @param  [type] $id [id]
     * @return [type]     [description]
     */
    public static function get_os_show($id)
    {
        return array_search($id,self::$OsInfo);
    }
    /**
     * [getBuild 获取安卓手机型号]
     * @Effect
     * @return [type] [description]
     */
    public static function getBuild(){
        $agent = $_SERVER['HTTP_USER_AGENT'];  
        if(!preg_match("/; (.*) Build\//i",$agent,$arrt)){
            return '未知型号';
        }
        if(empty($arrt[1])){
            return '未知型号数据';
        }

        return explode('; ',$arrt[1]);
    }
    /**
     * [getBuildIPhone 获取苹果设备的部分设备信息]
     * @Effect
     * @return [type] [description]
     */
    public static function getBuildIPhone(){
        $agent = $_SERVER['HTTP_USER_AGENT'];  
        if(!preg_match("/; CPU (.*) like Mac OS X/i",$agent,$arrt)){
            return '未知型号版本';
        }
        if(empty($arrt[1])){
            return '未知型号版本数据';
        }
        return explode('; ',$arrt[1]);
    }

    public static function getBuildNetType(){
        // $agent = 'Mozilla/5.0 (Linux; Android 7.1.1; ONEPLUS A5010 Build/NMF26X; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/57.0.2987.132 MQQBrowser/6.2 TBS/043906 Mobile Safari/537.36 MicroMessenger/6.6.3.1260(0x26060339) NetType/WIFI Language/zh_CN'; 
        $agent = $_SERVER['HTTP_USER_AGENT'];  

        // NetType/WIFI Language
        if(!preg_match("/ NetType\/(.*) Language/i",$agent,$arrt)){
            return '未知网络';
        }
        return $arrt[1];
    }
    /**
     * [getIpInfo 分析获取ip数据]
     * @Effect
     * @param  string $value [description]
     * @return [type]        [description]
     */
    public static function getIpInfo($value = ''){
        //判断并且获取IP数据
        if(empty($value)){
            $value = self::get_ip();
            if(in_array($value,self::$IpInfoArr)){
                return $value;
            }
        }
        static::$ip = $value;
        if(static::$pattern =='high'){

            return static::getIpInfoHigh($value);

        }elseif (static::$pattern =='precision'){

            return static::getIpInfoPrecision($value);

        }elseif (static::$pattern =='mixture'){
            return static::getIpInfoMixture($value);
        }
    }
    /**
     *  high[高性能只使用本地qqwry.dat数据]
     * @param $value
     */
    protected static function getIpInfoHigh($value)
    {
        /**
         * 获取qqwry数据
         */
        $QqIp = self::getQqIp($value);
        if($QqIp){
            /**
             * 判断是否是移动网络
             */
            $QqIp['NetworkType'] = 'WiFi';
            if(strstr($QqIp['isp'],'数据上网')){
                /**
                 * 是移动网络
                 */
                $QqIp['NetworkType'] = 'Cellular';
                $QqIp['isp'] = strstr($QqIp['isp'],'数据上网',true);
            }
            return $QqIp;
        }else{
            return null;
        }
    }

    /**
     *  precision[高精度 使用qqwry.dat+百度接口 可匹配出是否是手机网络 在手机网络下可匹配到城市]
     * @param $value
     */
    protected static function getIpInfoPrecision($value)
    {
        /**
         * 获取qqwry数据
         */
        if($QqIp = self::getQqIp($value)){
            /**
             * 判断是否是移动网络
             */
            $QqIp['NetworkType'] = 'WiFi';
            if(strstr($QqIp['isp'],'数据上网')){
                /**
                 * 是移动网络
                 */
                $QqIp['NetworkType'] = 'Cellular';
                $QqIp['isp'] = strstr($QqIp['isp'],'数据上网',true);
            }
            $arr['QqIp']= &$QqIp;
            $BdIp = self::getBdIp($value);
            if( $BdIp && $QqIp){
                $arr['BdIp']= &$BdIp;
                /**
                 * 优先级 默认 $QqIp < $BdIp
                 * 注意：百度获取的城市比较准确、但是没有区分数据网络和宽带网络，也没有运营商数据
                 */
                return array_merge($QqIp,$BdIp);
            }
            return $QqIp;
        }else if ($BdIp = self::getBdIp($value)){
            return $BdIp;
        }else{
            return null;
        }

    }
    /**
     * mixture[precision + mysql数据库 如果mysql中没有数据 使用precision获取数据 插入mysq中 ，如果mysql有数据匹配 不同就更新覆盖]
     * @param $value
     */
    protected static function getIpInfoMixture($value)
    {
        return null;
    }

    /**
     * qqwry ip接口
     * @param $value
     * @return mixed
     */
    public static function getQqIp($value)
    {
        $ToLocation = new ToLocation();
        $qqwry = $ToLocation->getlocation($value);
        $qqwryData = static::ipToLocation($qqwry['country']);
        $qqwryData['isp'] = $qqwry['area'];
        return $qqwryData;
    }

    /**
     * [getTbIp 淘宝ip接口]
     * @Effect
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    public static function getTbIp($value)
    {
        //淘宝接口
        // $url = 'https://ip.taobao.com/service/getIpInfo.php?ip='.$value;

        $url = 'http://ip.taobao.com/service/getIpInfo.php?ip='.$value;
        
        //返回数据格式
        //{"code":0,"data":{"ip":"121.34.35.220","country":"中国","area":"","region":"广东","city":"深圳","county":"XX","isp":"电信","country_id":"CN","area_id":"","region_id":"440000","city_id":"440300","county_id":"xx","isp_id":"100017"}}
        $Data = json_decode(self::http_request($url),true);

        if($Data['code'] != 0){
           return  false;
        }
        //处理数据
        $Data = $Data['data'];
        $reData['country'] = $Data['country'];//国家
        $reData['province'] = $Data['region'];//省
        if($Data['city'] != 'XX' && $Data['city'] !=''){ $reData['city'] = $Data['city'];}//城市
        $reData['isp'] = $Data['isp'];//服务商
        if(!empty($Data['area'])){$reData['district'] = $Data['area'];}//区域
        if($Data['county']!= 'XX'){$reData['county'] = $Data['county'];}//县

        return $reData;
    }
    /**
     * [getSgIp 新浪IP接口] 好像不能用
     * @Effect
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    public static function getXlIp($value)
    {
        $url = 'https://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json&ip='.$value;
        $Data = json_decode(self::http_request($url),true);
        if(!$Data){
           return  false;
        }
        //处理数据
        $reData['country'] = $Data['country'];//国家
        $reData['province'] = $Data['province'];//省
        if($Data['city'] != ''){$reData['city'] = $Data['city'];}//城市

        //区域
        if(!empty($Data['district'])){$reData['district'] = $Data['district'];}
        //服务商
        // if(!empty($Data['isp'])){$reData['isp'] = $Data['isp'];}
        return $reData;
    }

    /**
     *
     * https://freeapi.ipip.net/
     */
    public static function ipipnet($value)
    {

        $url = 'https://freeapi.ipip.net/'.$value;
        $Data = json_decode(self::http_request($url),true);

        if($Data){
            $reData['country'] = $Data[0];//国家
            $reData['province'] = $Data[1];//省
            $reData['city'] = $Data[2];//城市
            $reData['isp'] = $Data['4'];//服务商
        }
        return false;

    }
    /**
     * [getBdIp 百度接口]
     * @Effect
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    public static function getBdIp($value)
    {
        /**
         * 获取配置
         */
        if(!static::$BdApiKey){ static::$BdApiKey = Config::API_CONFIG['BaiduIp']['Key'];}

        $url = 'https://api.map.baidu.com/location/ip?ip='.$value.'&ak='.self::$BdApiKey.'&coor=bd09ll';

        $Data = json_decode(self::http_request($url),true);
        if(!$Data){
           return  false;
        }
        if($Data['status'] !=0){
           return  false;
        }
        $reData['address'] = $Data['address']??'';
        $reData['street_number'] = $Data['street_number']??'';
        $reData['point'] =  $Data['content']['point'];
        $Data = $Data['content']['address_detail'];
        //处理数据
        $reData['province'] = $Data['province'];//省
        if($Data['city'] != ''){$reData['city'] = $Data['city'];}//城市

        //区域
        if(!empty($Data['district'])){$reData['district'] = $Data['district'];}
        return $reData;

    }

    /**
     * [get_ip 不同环境下获取真实的IP]
     * @Effect
     * @return [type] [description]
     */
    public static function get_ip(){
            //判断服务器是否允许$_SERVER
            if(isset($_SERVER)){    
                if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
                    $realip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                }elseif(isset($_SERVER['HTTP_CLIENT_IP'])) {
                    $realip = $_SERVER['HTTP_CLIENT_IP'];
                }else{
                    $realip = $_SERVER['REMOTE_ADDR'];
                }
            }else{
                //不允许就使用getenv获取  
                if(getenv("HTTP_X_FORWARDED_FOR")){
                      $realip = getenv( "HTTP_X_FORWARDED_FOR");
                }elseif(getenv("HTTP_CLIENT_IP")) {
                      $realip = getenv("HTTP_CLIENT_IP");
                }else{
                      $realip = getenv("REMOTE_ADDR");
                }
            }
            return $realip;
    }  
    /**
     * [http_request curl请求]
     * @Effect
     * @param  [type] $url  [地址]
     * @param  [type] $data [POST数据]
     * @return [type]       [description]
     */
    public static function http_request($url, $data = null)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)){
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }
    /**
     * 具体位置转换成相应的省份和城市
     * @param $position
     * @return array
     */
    public static function ipToLocation($position){
        //有省，有市,普通省份
        if(strstr($position, '省') && strstr($position, '市')){
            $explodePosition = explode('省', $position);
            $province        = $explodePosition[0].'省';
            $city = explode('市', $explodePosition[1])[0].'市';
            if (empty($province) && empty($city)) {
                $province = $position.'省';
                $city = $position.'市';
            }
        }elseif(strstr($position, '省') && strstr($position, '州')){
            $explodePosition = explode('省', $position);
            $province        = $explodePosition[0];
            $city = explode('州', $explodePosition[1])[0];
            if (empty($province) && empty($city)) {
                $province = $position.'省';
                $city = $position.'州';
            }
        }
        //没有省但是有市,自治区或者直辖市,或者国外的某个城市
        elseif(!strstr($position, '省') && strstr($position, '市')){
            //自治区
            if(strstr($position, '宁夏')){
                $province = '宁夏回族自治区';
                $city     = explode('市', explode('宁夏', $position)[1])[0].'市';
            }elseif(strstr($position, '内蒙古')){
                $province = '内蒙古自治区';
                $city     = explode('市', explode('内蒙古', $position)[1])[0].'市';
            }elseif(strstr($position, '新疆')){
                $province = '新疆维吾尔自治区';
                $city     = explode('市', explode('新疆', $position)[1])[0].'市';
            }elseif(strstr($position, '广西')){
                $province = '广西壮族自治区';
                $city     = explode('市', explode('广西', $position)[1])[0].'市';
            }elseif(strstr($position, '西藏')){
                $province = '西藏自治区';
                $city     = explode('市', explode('西藏', $position)[1])[0].'市';
            }elseif(strstr($position, '北京市')){
                $province = '北京市';
                $city     = $province.'市';
            }elseif(strstr($position, '天津市')){
                $province = '天津市'.'市';
                $city     = $province.'市';
            }elseif(strstr($position, '重庆市')){
                $province = '重庆市';
                $city     = $province.'市';
            }elseif(strstr($position, '上海市')){
                $province = '上海市';
                $city     = $province.'市';
            }else{
                $length = strpos($position, ' ');
                //判断字符串内是否存在空格键
                if ($length !== false) {
                    $position = explode(' ',$position);
                    $province = $position[0];
                    //判断字符串内是否有 市 这个字符串
                    if(strpos($position[1],'市')!==false){
                        $city = explode('市',$position[1])[0];
                    }else{
                        $city = $position[1];//没有，就把空格剩余的字段赋值给城市
                    }

                } else {
                    $province = $position;
                    $city = $position;
                }
            }
        }
        elseif(strstr($position, '省') && !strstr($position, '市')){
            $start = strpos($position,'省');
            $province = substr($position,0,$start).'省';
            $city = '暂无数据';
        }
        //没有省也没有市,特别行政区或者国外
        elseif(!strstr($position, '省') && !strstr($position, '市')){
            $length = strpos($position, ' ');
            //判断字符串内是否存在空格键
            if ($length !== false) {
                $position = explode(' ', $position);
                $province = $position[0];
                $city = $position[1];//把空格剩余的字段赋值给城市
            } else {
                $province = $position;
                $city = $position;
            }
        }else{
            $province = $position.'省';
            $city = $position;
        }
        return ['province'=>$province,'city'=>$city];
    }
    /**
     * [CharToArr 把文字切割数组存储  ]
     * @Effect
     * @param  [type] $str [description]
     */
    public static function CharToArr($str){  
         return preg_split('/(?<!^)(?!$)/u', $str );  
    } 

}
