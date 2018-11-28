# TerminalInfo
一个简单的分析WEB客户端信息的类
## 此项目期望通过简单的方法获取WEB客户端一下信息：
+ 1、通过HTTP_USER_AGENT信息获取客户端的语言、客户端类型、客户端操作系统、HTTP_ACCEPT_LANGUAGE
+ 2、通过HTTP_ACCEPT_LANGUAGE信息获取客户端类型、客户端操作系统、网络类型等信息。
+ 3、通过搜集的IP信息查询API综合分析客户端所在国家、省、城市信息。
+ 4、通过搜集的IP信息、客户端信息综合分析客户端的网络状态。
# 使用方法：
+ 1、获取简化数据方法：TerminalInfo::getArowserInfo([type]) $type默认为arr数组形式返回数据，json为sjon形式返回数据
+ 1、获取全中文数据方法：TerminalInfo::getArowserPro([type]) $type默认为arr数组形式返回数据，json为sjon形式返回数据
# 注意：
+ 获取的数据的准确性需要在客户端没有存在刻意欺骗行为的前提下才能有一定的保证。
+ IP地址信息查询API,需要注意百度的API需要申请、淘宝的API有请求限制（比较准确的是百度API）、中国移动IP如果在异地漫游会比较准确，电信联通好查询到归属地城市数据。
