<?php
/**
 * @Author: pizepei
 * @Date:   2018-02-10 22:57:52
 * @Last Modified by:   pizepei
 * @Last Modified time: 2018-08-10 15:28:46
 * @Title 访问客户端信息
 */
namespace pizepei\terminalInfo;
use pizepei\terminalInfo\ToLocation;
class TerminalInfo{
    /**
     * 模式  high[高性能只使用本地qqwry.dat数据]  precision[高精度 使用qqwry.dat+百度接口+高德地图 可匹配出是否是手机网络 在手机网络下可匹配到城市] mixture[precision + mysql数据库 如果mysql中没有数据 使用precision获取数据 插入mysq中 ，如果mysql有数据匹配 不同就更新覆盖]
     * @var array
     */
    public static $pattern = 'high';
    /**
     * direct 直连   cdn 官方cnd   代理 agency
     * @var string
     */
    public static $ipPattern = [
            'pattern'=>'direct',
            'ip'=>['all'],
        ];
    /**
     * 第三方api接口配置
     * @var array
     */
    public static $apiConfig = [
        'BaiduIp' =>[ # 百度地图ip地址查询接口配置 接口申请地址http://lbsyun.baidu.com/
            'url'=>'',
            'Key'=>'',
        ],
        'AmapIp'=>[  # 高德地图 api配置  接口申请地址https://lbs.amap.com
            'url'=>'',
            'Key'=>'',
        ]
    ];

    /**
     * ip地址数据库  层级
     * @var int
     */
    public static $levels = 3;
    /**
     * 用来简单判断是否是真人ip
     */
    const ISP = [
        '中移铁通', '中移铁通','联通','移动','南平中国移动','电信'
    ];
    /**
     * redis 对象
     * @var \Redis
     */
    public static $redis = null;
    /**
     * redis 缓存有效期 单位小时
     * @var int
     */
    public static $period = 24;
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
    /**
     * $_SERVER['HTTP_USER_AGENT'];
     * @var mixed
     */
    public static $USER_AGENT = null;
    /**
     * $_SERVER['HTTP_ACCEPT_LANGUAGE']
     * @var null
     */
    public static $LANGUAGE = null;
    /**
     * 是否抛异常（只针对请求外部api接口时的数据异常问题）
     * @var bool
     */
    public static $exception = false;
    /**
     * ip信息缓存
     * @var array
     */
    protected static $IpInfo = [];
    /**
     * 浏览器类型
     * @var array
     */

    public static  $AgentInfoBrower = array(
        'SymbianOS'=>16,
        'MicroMessenger' => 6,
        'TencentTraveler' => 14,
        'Maxthon'   =>13,
        'Firefox' => 2,
        'MQQBrowser' => 3,
        'QQ/' => 4,
        'UCBrowser' => 5,
        'UCWEB'     =>17,
        'Edge' => 7,
        'Chrome' => 8,
        'Opera' => 9,
        'OPR' => 10,
        'Safari' => 11,
        'Trident' => 12,
        '360SE'    =>15,
        'MSIE' => 1,
        'PostmanRuntime'=>18,
    );
    /**
     * 浏览器类型
     * @var array
     */
    public static   $AgentInfoBroweInfo = array(  
        'IE(MSIE)' => 1,
        '微信(MicroMessenger)' => 6,
        '火狐(Firefox)' => 2,
        '腾讯(MQQBrowser)' => 3,
        '腾讯(QQ/)' => 4,
        'UC/支付宝(UCBrowser)' => 5,
        'Edge' => 7,
        '谷歌(Chrome)' => 8,
        '欧朋(Opera)' => 9,
        '欧朋(OPR)' => 10,
        '苹果(Safari)' => 11,
        'IE(Trident)' => 12,
        '傲游(Maxthon)' => 13,
        '腾讯TT(TencentTraveler)'=>14,
        '360SE'    =>15,
        'SymbianOS'=>16,
        'UCWEB'     =>17,
        'Postman'=>18,

    );
    /**
     * 操作系统
     * @var array
     */
    public static  $OsInfo =[
        'unknown'=> 0 ,//未知
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
        'ipad' => 31,
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
    const iPad = 31;
    /**
     * agent 缓存
     * @var array
     */
    protected static $agentInfo = [];
    /**
     * @Author 皮泽培
     * @Created 2019/8/14 15:53
     * @title  获取浏览器信息
     * @return array
     * @throws \Exception
     */
    public static function agentInfo():array
    {
        $arr['Ipanel'] =self::getAgentInfo();//获取浏览器内核
        $arr['OS'] = self::get_os();//获取操作系统
        # 根据不同的操作系统 和平台获取根据详细的信息
        if($arr['OS'] == 29){
            $arr['Build'] = self::getBuild();//获取安卓手机型号
            $arr['NetworkType'] = self::getBuildNetType();
        }else if($arr['OS'] == 30 || $arr['OS']==31 || $arr['OS']==16){
            $arr['Build'] = self::getBuildIPhone($arr['OS']);
            $arr['NetworkType'] = self::getBuildNetType();
        }else{
            $arr['NetworkType'] = 'Ethernet';
        }
        $arr['language'] = self::get_lang();  #获取浏览器语言
        return $arr;
    }

    /**
     * 通过缓存获取agentInfo信息
     * @return array
     * @throws \Exception
     */
    public static function agentInfoCache(bool $simplify=false):array
    {
        if (!isset($_SERVER['HTTP_USER_AGENT'])){return [];}
        # 判断缓存
        $agentMd5 = md5(static::$USER_AGENT?static::$USER_AGENT:$_SERVER['HTTP_USER_AGENT']);
        if (static::$redis !==null){
            # redis 缓存
            $agentInfo = static::$redis->get('TerminalInfo:agentInfo:'.$agentMd5);
            if ($agentInfo){
                $agentInfo = json_decode($agentInfo,true);
            }else{
                $agentInfo = static::agentInfo();
                static::$redis->setex('TerminalInfo:agentInfo:'.$agentMd5,60*60*static::$period,json_encode($agentInfo));
            }
        }else{
            #static 缓存
            if (isset(static::$agentInfo[$agentMd5]))
            {
                $agentInfo  = static::$agentInfo[$agentMd5];
            }else{
                static::$agentInfo[$agentMd5] = static::agentInfo();
                $agentInfo = static::$agentInfo[$agentMd5];
            }
        }
        $agentInfo['IP'] = empty(static::$ip)?self::get_ip():static::$ip;
        if ($simplify){
            # 替换为中文
            $agentInfo['language'] = self::get_lang();  #获取浏览器语言
            $agentInfo['Ipanel'] = self::getAgentInfo($agentInfo['Ipanel']);    #获取浏览器内核
            $agentInfo['OS'] =  array_search($agentInfo['OS'],self::$OsInfo);   #获取操作系统
        }
        return $agentInfo;
    }

    /**
     * @Author 皮泽培
     * @Created 2019/8/14 15:24
     * @param bool $simplify 是否获取全中文
     * @title  获取全部客户端信息
     * @return array
     * @throws \Exception
     */
    public static function getInfo(bool $simplify=false):array
    {
        $agentInfo['IpInfo'] = self::getIpInfo();   #ip信息  有自己的缓存处理
        $agentInfo['agentInfo'] = self::agentInfoCache($simplify);        # 获取客户端浏览器信息
        return $agentInfo;
    }


    /**
     * @Author 皮泽培
     * @Created 2019/8/14 15:24
     * @param string $all all 全部   ip  agent
     * @title  清空对应的数据缓存
     * @return array
     * @throws \Exception
     */
    public static function delCache(string $all='all')
    {
        if (static::$redis !==null){
            if ($all='all' ||$all='ip' ){static::$redis->del(static::$redis->keys('TerminalInfo:ipInfo:*'));}
            if ($all='all' ||$all='agent' ){static::$redis->del(static::$redis->keys('TerminalInfo:agentInfo:*'));}
        }else{
            if ($all='all' ||$all='ip' ){static::$IpInfo = [];}
            if ($all='all' ||$all='agent' ){static::$agentInfo = [];}
        }
    }
    /**
     * [getAgentInfo 获取浏览器内核]
     * @Effect
     * @param  boolean $Data [浏览器内核 值]
     * @return [type]        [description]
     */
    public static function getAgentInfo($Data = false){
        ##如果没有存入 浏览器内核 值 就是获取浏览器内核 值
        if(!$Data){
            $agent = static::$USER_AGENT?static::$USER_AGENT:$_SERVER['HTTP_USER_AGENT'];
            $browser_num = 0;//未知
            foreach(self::$AgentInfoBrower as $bro => $val){
                if(stripos($agent, $bro) !== false){
                    $Versions = self::getBuildIMicroVersions($bro);
                    $browser_num = $val;
                    break;  
                }
            }
            $Data = ['name'=>$browser_num,'versions'=>$Versions['versions']??false];
            return  $Data;
        }
        //存入就是获取 文字浏览器内核名称
        $Data['name'] = array_search($Data['name'],self::$AgentInfoBroweInfo);
        return $Data;
    }
    /**
     * 获得访问者浏览器语言
     * @return bool|string
     */
    public static function get_lang() {
        static::$LANGUAGE = isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])?$_SERVER['HTTP_ACCEPT_LANGUAGE']:null;
        if (empty(static::$LANGUAGE)){
            # 只取前4位，这样只判断最优先的语言。如果取前5位，可能出现en,zh的情况，影响判断。
            $lang = substr(static::$LANGUAGE, 0, 5);
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
        }
        return 'unknown';
    }
    /**
     * [get_os 获取客户端操作系统信息包括]
     * @Effect
     * @return [type] [description]
     */
    public static function get_os(){  
        $agent = static::$USER_AGENT?static::$USER_AGENT:$_SERVER['HTTP_USER_AGENT'];
        $os = false;  
        if (preg_match('/win/i', $agent) && strpos($agent, '95'))  
        {  
          $os = self::Windows_95;  
        }  
        else if (preg_match('/win 9x/i', $agent) && strpos($agent, '4.90'))  
        {  
          $os = self::Windows_95;    
        }  
//        else if (preg_match('/win/i', $agent) && preg_match('/98/i', $agent))
//        {
//          $os =  self::Windows_98;
//        }
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
        else if (preg_match('/Mac/i', $agent) && preg_match('/Macintosh/i', $agent))
        {
          $os = self::Macintosh;
        }
        else if (preg_match('/iPad/i', $agent) && preg_match('/Mac OS/i', $agent))
        {
            $os = self::iPad;
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
     * @return [type] [description] 0 系统  1 手机型号
     */
    public static function getBuild(){
        $agent = static::$USER_AGENT?static::$USER_AGENT:$_SERVER['HTTP_USER_AGENT'];
        if(preg_match("/U; (.*) Build\//i",$agent,$arrt)){

        }else if (preg_match("/; (.*) Build\//i",$agent,$arrt)){

        }else if (preg_match("/\(linux; (.*)\) Apple/i",$agent,$arrt)){

        }else if (preg_match("/Android (.*); Linux/i",$agent,$arrt))
        {
            return explode('; ',$arrt[0]);
        }
        if(!isset($arrt[1]) && empty($arrt[1])){
            return ['unknown'];
        }
        return explode('; ',$arrt[1]);
    }
    /**
     * [getBuildIPhone 获取苹果设备的部分设备信息]
     * @Effect
     * @return [type] [description]
     */
    public static function getBuildIPhone($code=30){
        $agent = static::$USER_AGENT?static::$USER_AGENT:$_SERVER['HTTP_USER_AGENT'];
        if ($code == 16){
            if(preg_match("/Macintosh; U; (.*);/i",$agent,$arrt)){

                if(!empty($arrt[1])){
                    list($name,$versions) = explode(' OS X ',$arrt[1]);
                }
            }else if(preg_match("/Macintosh; (.*)\) AppleWebKit/i",$agent,$arrt)){
                if(!empty($arrt[1])){
                    list($name,$versions) = explode(' OS X ',$arrt[1]);
                }
            }
        }else if ($code == 30){
            if(preg_match("/; CPU (.*) like Mac OS X/i",$agent,$arrt)){
                if(!empty($arrt[1])){
                    list($name,$versions) = explode(' OS ',$arrt[1]);
                }
            }
        }else if ($code == 31){
            if(preg_match("/iPad; CPU OS (.*) like Mac OS X/i",$agent,$arrt)){
                if(!empty($arrt[1])){
                    $name = 'AMC';
                    $versions= $arrt[1];
                }
            }
        }else{
            $name = array_search(self::get_os(),self::$OsInfo);
        }
        return ['name'=>$name??'','versions'=>$versions??''];
    }

    const MicroVersions =[
        'MQQBrowser'=>'MQQBrowser\/',
        'MicroMessenger'=>'MicroMessenger\/',
        'AppleWebKit'=>'AppleWebKit\/',
        'Chrome'=>'Chrome\/',
        'MSIE'=>'MSIE ',
        'Safari'=>'Safari\/',
        'Opera'=>'Presto\/',
        'Maxthon'=>'Maxthon ',
        'TencentTraveler'=>'TencentTraveler ',
        '360SE'         =>'360SE',
        'SymbianOS'  =>'SymbianOS\/',
        'UCBrowser' =>'UCBrowser\/',
        'Firefox'   =>'Firefox\/',
        'PostmanRuntime'=>'PostmanRuntime\/',
    ];
    /**
     * @Author 皮泽培
     * @Created 2019/8/5 15:15
     * @return array
     * @title  浏览器版本
     * @throws \Exception
     */
    public static function getBuildIMicroVersions($type='MSIE')
    {

        if (isset(self::MicroVersions[$type])){
            $type = self::MicroVersions[$type];
        }
        $blank = ['MSIE ','Maxthon ','TencentTraveler '];
        $not = ['UCWEB'];
        if (preg_match("/$type([\d\.]+)/i",static::$USER_AGENT?static::$USER_AGENT:$_SERVER['HTTP_USER_AGENT'],$arr)){
            if (in_array($type,$blank)){
                list($name,$versions) = explode(' ',$arr[0]);
            }elseif(in_array($type,$not)){
                $name = $type;
                $versions = $arr[1];
            }else{
                list($name,$versions) = explode('/',$arr[0]);
            }
        }
        return ['name'=>$name??$type??'','versions'=>$versions??''];
    }
    /**
     * 获取移动设备的网络
     * @return string
     */
    public static function getBuildNetType(){
        // NetType/WIFI Language
        if(!preg_match("/ NetType\/(.*) Language/i",static::$USER_AGENT?static::$USER_AGENT:$_SERVER['HTTP_USER_AGENT'],$arrt)){
            return 'unknown';
        }
        return $arrt[1]??'unknown';
    }


    /**
     * [getIpInfo 分析获取ip数据]
     * @Effect
     * @param  string $value [description]
     * @return [type]        [description]
     */
    public static function getIpInfo($value = '',$update=false){

        //判断并且获取IP数据
        if(empty($value)){
            static::$ip = self::get_ip();
            if(in_array(static::$ip,self::$IpInfoArr)){
                return static::$ip;
            }
        }else{
            static::$ip = $value;
        }
        $value = static::$ip;
        if (static::$redis !== null){
            $data = static::$redis->get('TerminalInfo:ipInfo:'.$value);
            if ($data){
                return json_decode($data,true);
            }
        }else{
            if (isset(static::$IpInfo[$value]))
            {
                return static::$IpInfo[$value];
            }
        }
        /**
         * 判断是否有文件配置
         */
        if(static::$pattern =='high'){
            $data =  static::getIpInfoHigh($value,$update);#只使用本地纯真ip地址数据库

        }elseif (static::$pattern =='precision'){
            $data =  static::getIpInfoPrecision($value);# 使用可能的资源整合数据
        }elseif (static::$pattern =='mixture'){
            $data =  static::getIpInfoMixture($value);
        }
        # 缓存结果
        if ($data && static::$redis !== null){
            static::$redis->setex('TerminalInfo:ipInfo:'.$value,60*60*static::$period,json_encode($data));
        }else{
            static::$IpInfo[$value] = $data;
        }
        $data['ip'] = $value;
        $data['type'] = 'IPV4';
        return $data;
    }
    /**
     *  high[高性能只使用本地qqwry.dat数据]
     * @param $value
     * @param $update
     */
    protected static function getIpInfoHigh($value,bool $update=false)
    {
        /**
         * 获取qqwry数据
         */
        $QqIp = self::getQqIp($value,$update);
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
            # 判断是否是移动网络
            $QqIp['NetworkType'] = 'WiFi';
            if(strstr($QqIp['isp'],'数据上网')){
                # 是移动网络
                $QqIp['NetworkType'] = 'Cellular';
                $QqIp['isp'] = strstr($QqIp['isp'],'数据上网',true);
            }
            $BdIp = self::getBdIp($value);
            $getAmapIp = self::getAmapIp($value);
            # 优先级 默认 $QqIp > $BdIp >$getAmapIp  注意：百度获取的城市比较准确、但是没有区分数据网络和宽带网络，也没有运营商数据
            if($getAmapIp){
                $QqIp = array_merge($QqIp,$getAmapIp);
            }
            if($BdIp){
                $QqIp = array_merge($QqIp,$BdIp);
            }
            return $QqIp;
        }else if ($BdIp = self::getBdIp($value)){
            return $BdIp;
        }elseif ($getAmapIp = self::getAmapIp($value)){
            return $getAmapIp;
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
     * qqwryIP 地址数据库 支持官网IP信息、支持IDC机房IP信息查询
     * @param $value
     *  @param $update
     * @return mixed
     */
    public static function getQqIp($value,bool $update=false)
    {
        $ToLocation = new ToLocation($update,dirname($_SERVER['SCRIPT_FILENAME'],self::$levels).DIRECTORY_SEPARATOR."qqwry.dat");
        $qqwry = $ToLocation->getlocation($value);
        $qqwryData = static::ipToLocation($qqwry['country']);
        $qqwryData['isp'] = $qqwry['area'];
        # 判断是否是真人（非国内主流电信运营商）
        if (!empty($qqwryData['isp'])){
            if (in_array($qqwryData['isp'],self::ISP)){
                $qqwryData['human'] = 'yes';
            }else{
                $qqwryData['human'] = 'no';
            }
        }
        return $qqwryData;
    }

    /**
     * @Author: pizepei
     * @Created: 2018/12/2 22:52
     * @param $value
     * @return bool
     * @throws \Exception
     * @title  [getBdIp 百度接口]
     * @explain 无法获取IDC机房ip信息
     */
    public static function getBdIp($value)
    {
        # 获取配置
        if (!isset(static::$apiConfig['BaiduIp']['Key']) || empty(static::$apiConfig['BaiduIp']['Key'])){
            return false;
        }
        $url = 'https://api.map.baidu.com/location/ip?ip='.$value.'&ak='.static::$apiConfig['BaiduIp']['Key'].'&coor=bd09ll';
        $Data = json_decode(self::http_request($url),true);
        if(!$Data){
           return  false;
        }
        if($Data['status'] !=0){
            if (static::$exception){
               throw new \Exception(json_encode($Data));
            }
            return  false;
        }
        if (!isset($Data['content']) && empty($Data['content'])){ return false;}

        $address_detail = $Data['content']['address_detail'];

        if (!empty($Data['address'])) {$reData['address'] = $Data['address'];}# 详细地址     CN|北京|北京|None|CHINANET|1|None
        if (!empty($address_detail['street_number'])) {$reData['street_number'] = $address_detail['street_number'];}# 门牌号
        if (!empty($Data['content']['point'])) {$reData['point'] = $Data['content']['point'];}#   当前城市中心点
        if (!empty($address_detail['street'])) {$reData['street'] = $address_detail['street'];}# 街道
        if (!empty($address_detail['city_code'])) {$reData['city_code'] = $address_detail['city_code'];}# 街道
        if (!empty($address_detail['province'])) {$reData['province'] = $address_detail['province'];}# 省
        return $reData;
    }

    /**
     * @Author: pizepei
     * @Created: 2018/12/2 22:52
     * @param $value
     * @return bool
     * @throws \Exception
     * @title  高德地图api
     * @explain 特别注意本api只能获取国内ip 不能获取IDC机房ip详细
     */
    public static function getAmapIp($value)
    {
        # 获取配置
        if (!isset(static::$apiConfig['AmapIp']['Key']) || empty(static::$apiConfig['AmapIp']['Key'])){
            return false;
        }
        $url = 'https://restapi.amap.com/v3/ip?key='.static::$apiConfig['AmapIp']['Key'].'&output=json&ip='.$value;
        $Data = json_decode(self::http_request($url),true);
        if(!$Data){
            return  false;
        }
        if($Data['status'] !=1){
            if (static::$exception){
                throw new \Exception(json_encode($Data));
            }
            return  false;
        }
        if (!empty($Data['province'])) {$reData['province'] = $Data['province'];}# 省
        if (!empty($Data['city'])) {$reData['city'] = $Data['city'];}# 市
        if (!empty($Data['adcode'])) {$reData['city_code'] = $Data['adcode'];}# 区域代码
        return $reData;
    }
    /**
     * [get_ip 不同环境下获取真实的IP]
     * @Effect
     * @return [type] [description]
     */
    public static function get_ip(){
        /**
         *   direct 直连   cdn 官方cnd   代理 agency
         */
        if(static::$ipPattern['pattern'] == 'direct'){
            if(isset($_SERVER)){
                $realip = $_SERVER['REMOTE_ADDR'];
            }else{
                $realip = getenv("REMOTE_ADDR");
            }

        }else if(static::$ipPattern['pattern'] == 'cdn' || static::$ipPattern['pattern']== 'agency'){
            # 判断ip的安全性
            if (!in_array('all',static::$ipPattern['ip'])){
                # 获取当前ip
                if(isset($_SERVER)){
                    $realip = $_SERVER['REMOTE_ADDR'];
                }else{
                    $realip = getenv("REMOTE_ADDR");
                }
                if (!isset(static::$ipPattern['ip'][$realip])){
                    throw new \Exception('Illegal agency IP address '.$realip);
                }
            }
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
