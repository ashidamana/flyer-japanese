Lumen
Lumen, Laravel新推出的小框架，算是小巧板laravel，专门为了开发API而设计的。很给力啊

phalapi
https://www.phalapi.net/

但是个人觉得slim、lumen较为适合搭建rest api服务

[
好的，小伙伴们本周可以自行学习。

最近，花了两天时间，重写了下默写材料生成工具。
小飞鸟日语学习监督部
https://flyer-japanese.mana.love/

主要做了如下优化：
1.美化页面，并实现响应式。
2.通过浏览器的存储功能实现所填表单的数据存储。
3.实现原有默写材料生成器的全部功能。
4.提高了生成材料的普适性。
5.美化了内容复制提示。
6.实现生成、全部清空、清空567、数据还原、一键复制、复制第1(-6)条功能。
7.借助浏览器存储实现中文名、日文名、五十音、行段、@人物、每日一句的自动化填写。
8.实现五十音、行段的随机化。
9.实现时间的自动判断和选择。
10.实现单词、语法、表达方式的随机化。
11.编写实现了每日一句网络爬虫，并以此为基础实现每一句自动化。
12.设计了小飞鸟日语学习监督部logo。

]

小飞鸟日语学习监督部[
1.美化的页面，并实现响应式。ok
2.通过浏览器的存储功能实现所填表单的数据存储。ok
3.实现原有默写材料生成器的全部功能。ok
4.提高了生成材料的普适性。ok
5.美化了内容复制提示。ok
6.实现全部清空、清空567、一键复制、复制第1(-6)条功能。ok
7.借助浏览器存储实现中文名、日文名、五十音、行段、@人物、每日一句的自动化填写。
8.实现五十音、行段的随机化。
9.实现时间的自动判断。
8.编写实现了每日一句网络爬虫。ok
------
9.设计了小飞鸟日语学习监督部logo。
10.实现了每日一句API。
10.一些高级自动化[
注意算法
五十音、
行段、
时间、ok
每日一句自动填写当天内容
]

单词、语法、表达方式实现对填入内容的顺序随机化 ok

11.5/6/7第二天自动清空[
generate_time
存一个时间，时间不一致时自动清空567
] ok

console介绍%c ok

时间自动化[
http://blog.sina.com.cn/s/blog_4940e1810102w9se.html
おはよう：９時まで
こんにちは：９時～１８時まで
こんばんは：１８時以降

おはよう：１１時まで
こんにちは：１１時～１７時まで
こんばんは：１７時以降

おはよう：１０時まで
こんにちは：１０時～１７時半まで
こんばんは：17時半以降

本站采用
おはよう：９時まで
こんにちは：９時～１8時まで
こんばんは：１８時以降
] ok

时钟[
使用jQuery和CSS3制作数字时钟(jQuery篇)
https://www.helloweba.net/javascript/273.html
] ok

惜时胜金/关于本站/友情链接/底部/头部 ok

五十音、行段随机化ok

临时API[
/api/v1/getDailySentence.php
] ok

代码压缩 ok
配置文件数据库等 ok

设计了小飞鸟日语学习监督部logo ok

每日一句自动化[
定时任务crontab ok
API开发 ok
自动填充当日的每日一句 ok
] ok

最终代码放到github仓库 ok
提交站点至layui官方以增加知名度[
http://fly.layui.com/case/2018/
鉴于越来越多的人使用 layui 并分享案例，为尽可能保证案例具备一定的参考价值，特此对其设立审核标准。即日起，案例必须符合以下要求
1、案例必须采用 layui 为主要的 UI 框架，且不能只使用到了某一个独立组件
2、案例必须具有独立域名，且访问速度不能过慢
3、案例必须具备一定内容且正规，而不是一个空壳
4、案例如果为后台模板，必须提供下载地址（即必须是开源的）
5、案例如果是基于 Fly社区 模板，必须有较大幅度改动
]
]

layui.data('flyer_japanese', {
    key: 'generate_time'
    , value: '2018-01-01'
});

layui.data('flyer_japanese',null);

js文件压缩
压缩js代码的工具
npm install uglify-js -g

使用
uglifyjs ./index.js -o index.min.js

压缩css
npm install uglifycss -g

使用
uglifycss ./clock.css > clock.min.css


uglifyjs ./index.js -o flyerjp-1.0.0.min.js

TRUNCATE TABLE `jp_one`;

数据库编码问题 ok

qingyinj

/usr/local/bin/php /home/qingyinj/public_html/flyer-japanese/getone.php

# 参考：
- [layui](http://www.layui.com/)
- [快速开发一个PHP电影爬虫](https://www.cnblogs.com/blueel/p/3756446.html)
- [simple_html_dom](https://github.com/samacs/simple_html_dom)
- [simple_html_dom](http://simplehtmldom.sourceforge.net/)
- [simple_html_dom使用手册](http://simplehtmldom.sourceforge.net/manual.htm)
- [RESTful API 设计指南](http://www.ruanyifeng.com/blog/2014/05/restful_api.html)  
- [使用什么PHP轻框架搭建RESTful API 服务好](https://www.jianshu.com/p/d7e0ab2926fa)  
- [lumen](https://lumen.laravel-china.org/docs/5.3/installation)  
- []()  
- []()  
- []()  