# TerminalInfo
一个简单的分析WEB客户端信息的类
## 此项目期望通过简单的方法获取WEB客户端一下信息：
+ 1、通过HTTP_USER_AGENT信息获取客户端的语言（HTTP_ACCEPT_LANGUAGE）、客户端类型、客户端操作系统（PC、IOS、Android以及版本号）、IOS系统版本、微信版本、浏览器内核版本
+ 2、通过HTTP_ACCEPT_LANGUAGE信息获取客户端类型、客户端操作系统、网络类型等信息。
+ 3、通过搜集的IP信息查询API综合分析客户端所在国家、省、城市信息。
+ 4、通过搜集的IP信息、客户端信息综合分析客户端的网络状态。
# 使用方法：
* 简单的使用方法

 ~~~
    * redis使用缓存结果避免重复获取ip和浏览器信息
        terminalInfo::$redis= $Redis;   #$Redis为Redis实例  非必须如果不设置属性默认中缓存当前请求生命周期内的ip与浏览器信息
        terminalInfo::$period = 24;     #redis缓存有效期单位小时  默认24小时
        terminalInfo::$USER_AGENT;      #非必须如果不设置此属性 默认获取当前请求的$_SERVER['HTTP_USER_AGENT']
        terminalInfo::getInfo(true);    # 当参数为 true 时获取全文字信息方便展示  false 时获取的是int数值代替的内容方便存储数据库
        * 返回信息如下
        {
                "Ipanel": {
                    "name": "微信(MicroMessenger)",             # 浏览器名称
                    "versions": "7.0.6.1460"                    # 浏览器内核版本（客户端是微信时versions为微信版本号）
                },
                "language": "简体中文",                         # 浏览器系统语言  
                "OS": Android,                                  # 客户端系统  
                "Build": [                                      # 移动设备的系统信息如系统、设备型号 IOS设备时会获取到IOS版本号
                    "Android 9",
                    "ONEPLUS A5010"
                ],
                "NetworkType": "WIFI",                          # 通过浏览器信息获取到的网络信息
                "IpInfo": {                                     # IP详细信息 不同的模式下的信息有一些区别
                    "province": "广东省",
                    "city": "深圳市",
                    "isp": "电信",
                    "NetworkType": "WiFi",
                    "address": "CN|广东|深圳|None|CHINANET|0|0",
                    "street_number": "",
                    "point": {
                        "x": "114.02597366",
                        "y": "22.54605355"
                    }
                },
                "IP": "121.34.151.140",                         # 客户端IP
            }
        
    * 单独获取浏览器信息
        terminalInfo::agentInfo();      # 单独获取，不支持获取全文字信息
    * 单独获取IP详细
        terminalInfo::getIpInfo([$IP]); # 如果传入ip就获取此IP信息否则获取当前请求IP的信息（会自动根据参数缓存结果）
    * 获取当前请求IP
        terminalInfo::get_ip()
 ~~~
        
        
        
# 注意：
+ 获取的数据的准确性需要在客户端没有存在刻意欺骗行为的前提下才能有一定的保证。
+ IP地址信息查询API,需要注意百度的API需要申请、淘宝的API有请求限制（比较准确的是百度API）、中国移动IP如果在异地漫游会比较准确，电信联通好查询到归属地城市数据。
