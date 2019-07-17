<?php
/**
 * @Author: pizepei
 * @Date:   2018-08-10 15:20:07
 * @Last Modified by:   pizepei
 * @Last Modified time: 2018-08-10 15:28:58
 * @title 纯真数据库自动更新
 */
namespace pizepei\terminalInfo;

use pizepei\func\Func;
use pizepei\helper\Helper;

class UpdateQqwry{
    /**
     * 缓存目录
     * @var string
     */
    public $prc = '..'.DIRECTORY_SEPARATOR.'runtime'.DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR;
    /**
     * 缓存时间 单位天
     * @var int
     */
    public $updateTime = 3;

    public function __construct()
    {
        if(!is_file($this->prc."qqwry.dat")){
            Helper::file()->createDir($this->prc);
            $this->getQqwry();
            return true;
        }

        if(!@filemtime($this->prc."qqwry.dat")){
            Helper::file()->createDir($this->prc);
            $this->getQqwry();
            return true;
        }
        /**
         * 默认3天86400*3
         */
        if((@filemtime($this->prc."qqwry.dat") + (86400*$this->updateTime)) < time() ){
            $this->getQqwry();
            return true;
        }else{
            return false;
        }
    }

    /**
     * 更新qqwry.dat文件
     */
    protected function getQqwry()
    {
        /**
         * 纯真数据库自动更新原理实_FILE__
         */
        $copywrite = file_get_contents("http://update.cz88.net/ip/copywrite.rar");
        $qqwry = file_get_contents("http://update.cz88.net/ip/qqwry.rar");
        //函数从二进制字符串对数据进行解包。
        $key = unpack("V6", $copywrite)[6];
        for($i=0; $i<0x200; $i++)
        {
            $key *= 0x805;
            $key ++;
            $key = $key & 0xFF;
            $qqwry[$i] = chr( ord($qqwry[$i]) ^ $key );
        }
        //此函数解压缩压缩字符串。
        $qqwry = gzuncompress($qqwry);
        /**
         * 当前php文件同级创建qqwry.dat
         * [$fp description]
         * @var [type]
         */
//        $fp = fopen(dirname(__FILE__).DIRECTORY_SEPARATOR."qqwry.dat", "wb");
        $fp = fopen($this->prc."qqwry.dat", "wb");

        if($fp)
        {
            /**
             * 函数写入文件（可安全用于二进制文件）。
             */
            fwrite($fp, $qqwry);
            /**
             * fclose() 函数关闭一个打开文件。
             */
            fclose($fp);
        }

    }



}

 