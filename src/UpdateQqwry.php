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
    public $path = '..'.DIRECTORY_SEPARATOR.'runtime'.DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR;
    /**
     * 缓存时间 单位天
     * @var int
     */
    public $updateTime = 3;

    public function __construct(bool $update=false)
    {
        if(!is_file($this->path."qqwry.dat")){
            Helper::file()->createDir($this->path);
            $this->getQqwry();
            return true;
        }
        if(!@filemtime($this->path."qqwry.dat")){
            Helper::file()->createDir($this->path);
            $this->getQqwry();
            return true;
        }
        /**
         * 更新Qqwry文件
         */
        if ($update){
            # 默认3天86400*3 触发一次更新
            if((@filemtime($this->path."qqwry.dat") + (86400*$this->updateTime)) < time() ){
                $this->getQqwry();
                return true;
            }else{
                return false;
            }
        }

    }
    /**
     * @Author 皮泽培
     * @Created 2019/8/13 11:01
     * @title  更新qqwry.dat文件
     * @throws \Exception
     */
    protected function getQqwry()
    {
        #纯真数据库自动更新原理实_FILE__
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
        # 创建qqwry.dat
        $fp = fopen($this->path."qqwry.dat", "wb");
        if($fp)
        {
            # 函数写入文件（可安全用于二进制文件）。
            fwrite($fp, $qqwry);
            # fclose() 函数关闭一个打开文件。
            fclose($fp);
        }

    }



}

 