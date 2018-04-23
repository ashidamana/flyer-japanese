<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <title>小飞鸟日语学习监督部</title>
        <meta name="keywords" content="小飞鸟日语学习监督部,MANA-CHANN-BU!!!,爱菜小部,Manachannbu,愛菜ちゃん部,芦田爱菜,菜籽,飞鸟,飞鸟鸣鸾,飛鳥メイラン,Flyer Angel">
        <meta name="description" content="小飞鸟日语学习监督部,由小飞鸟于2017年09月07日成立，以互相学习，互相监督，共同进步为目标。采用极具实践性、持续性、高效性的小飞鸟&啊叶联合日语学习模式，于2017年09月11日起正式实施。">
        <link rel="shortcut icon" href="https://blog.mana.love/img/favicon.png">
        <link rel="stylesheet" href="./lib/layui/css/layui.css">
        <link rel="stylesheet" href="./res/css/global.css">
    </head>
    <body>
        <!--头部-->
        <div class="fly-header layui-bg-black">
            <div class="layui-container">
                <a class="fly-logo" href="/">
                    <img src="./res/images/logo.png" alt="layui">
                </a>
                <ul class="layui-nav fly-nav layui-hide-xs">
                    <li class="layui-nav-item layui-this">
                        <a href="/"><i class="iconfont icon-iconmingxinganli"></i>首页</a>
                    </li>
                    <li class="layui-nav-item ">
                        <a href="/"><i class="iconfont icon-jiaoliu"></i>每日一句</a>
                    </li>
                </ul>

                <ul class="layui-nav fly-nav-user">

                    <!-- 未登入的状态 -->
                    <!--
                    <li class="layui-nav-item">
                      <a class="iconfont icon-touxiang layui-hide-xs" href="user/login.html"></a>
                    </li>
                    <li class="layui-nav-item">
                      <a href="user/login.html">登入</a>
                    </li>
                    <li class="layui-nav-item">
                      <a href="user/reg.html">注册</a>
                    </li>
                    <li class="layui-nav-item layui-hide-xs">
                      <a href="/app/qq/" onclick="layer.msg('正在通过QQ登入', {icon:16, shade: 0.1, time:0})" title="QQ登入" class="iconfont icon-qq"></a>
                    </li>
                    <li class="layui-nav-item layui-hide-xs">
                      <a href="/app/weibo/" onclick="layer.msg('正在通过微博登入', {icon:16, shade: 0.1, time:0})" title="微博登入" class="iconfont icon-weibo"></a>
                    </li>
                    -->

                    <!-- 登入后的状态 -->
                    <li class="layui-nav-item">
                        <a class="fly-nav-avatar" href="javascript:;">
                            <cite class="layui-hide-xs">小飞鸟</cite>
                            <i class="iconfont icon-renzheng layui-hide-xs" title="认证信息：爱菜家、希望之神小飞鸟"></i>
                            <i class="layui-badge fly-badge-vip layui-hide-xs">VIP99</i>
                            <img src="https://ooo.0o0.ooo/2017/06/27/5951e19dce0d3.png">
                        </a>
                        <!--                        <dl class="layui-nav-child">
                                                    <dd><a href="../user/set.html"><i class="layui-icon">&#xe620;</i>基本设置</a></dd>
                                                    <dd><a href="../user/message.html"><i class="iconfont icon-tongzhi" style="top: 4px;"></i>我的消息</a></dd>
                                                    <dd><a href="../user/home.html"><i class="layui-icon" style="margin-left: 2px; font-size: 22px;">&#xe68e;</i>我的主页</a></dd>
                                                    <hr style="margin: 5px 0;">
                                                    <dd><a href="" style="text-align: center;">退出</a></dd>
                                                </dl>-->
                    </li>
                </ul>
            </div>
        </div>
        <!--中间内容-->
        <div class="layui-container fly-marginTop">
            <div class="layui-row layui-col-space10">
                <div class="layui-col-md4">
                    <div class="layui-row layui-hide-xs">
                        <div class="layui-col-md12">
                            <div class="fly-panel" pad20 style="padding-top: 5px;">
                                <div class="fly-home fly-panel" style="background-image: url();">
                                    <img src="https://ooo.0o0.ooo/2017/06/27/5951e19dce0d3.png" alt="小飞鸟">
                                    <i class="iconfont icon-renzheng" title="小飞鸟"></i>
                                    <h1>
                                        <span class="local-name">小飞鸟</span>
                                        <i class="iconfont icon-nan"></i>
                                        <!-- <i class="iconfont icon-nv"></i>  -->
                                        <i class="layui-badge fly-badge-vip">VIP99</i>
                                        <!--
                                        <span style="color:#c00;">（管理员）</span>
                                        <span style="color:#5FB878;">（社区之光）</span>
                                        <span>（该号已被封）</span>
                                        -->
                                    </h1>

                                    <p style="padding: 10px 0; color: #5FB878;">认证信息：爱菜家、希望之神小飞鸟</p>

                                    <p class="fly-home-info">
                                        <i class="iconfont icon-kiss" title="菜币"></i><span style="color: #FF7200;">66666 菜币</span>
                                        <i class="iconfont icon-shijian"></i><span>2017-09-07 加入</span>
                                        <i class="iconfont icon-chengshi"></i><span>来自江苏</span>
                                    </p>

                                    <p class="fly-home-sign">（踏踏实实，一步一个脚印）</p>

                                    <div class="fly-sns" data-user="">
                                        <a href="https://blog.mana.love/" target="_blank" class="layui-btn layui-btn-primary fly-imActive" data-type="addFriend">访问博客</a>
                                        <a href="http://www.weibo.com/flyerangel" target="_blank" class="layui-btn layui-btn-normal fly-imActive" data-type="chat">关注微博</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="layui-row layui-hide-xs">
                        <div class="layui-col-md12">
                            <div class="fly-panel">
                                <h3 class="fly-panel-title">关于本站</h3>
                                <div class="fly-panel-main">
                                    <p class="layui-text" style="color:#333;">小飞鸟日语学习监督部，由爱菜家、希望之神小飞鸟于2017年09月07日成立，以互相学习，互相监督，共同进步为目标。
<br><br>我们采用极具实践性、持续性、高效性的小飞鸟&啊叶联合日语学习模式，于2017年09月11日起正式实施。
</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="layui-row layui-hide-xs">
                        <div class="layui-col-md12">
                            <div class="fly-panel fly-link">
                                <h3 class="fly-panel-title">友情链接</h3>
                                <dl class="fly-panel-main">
                                    <dd><a href="https://blog.mana.love/" target="_blank">喵喵清吟 | 小飞鸟的博客</a><dd>                                  
                                    <dd><a href="http://ashidamana.info/" target="_blank">芦田愛菜展覽館</a><dd>
                                    <dd><a href="http://weibo.com/laomingxiang" target="_blank">芦田愛菜展览馆官博</a><dd>
                                    <dd><a href="http://weibo.com/mana0623" target="_blank">芦田愛菜中文首站</a><dd>
                                    <dd><a href="http://www.manachannbu.com/" target="_blank">爱菜小部官方网站</a><dd>
                                    <dd><a href="https://blog.mana.love/messages/" target="_blank" class="fly-link">申请友链</a><dd>
                                </dl>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="layui-col-md8">
                    <div class="fly-panel" pad20 style="padding-top: 5px;">                  
                        <div class="layui-form layui-form-pane generate-form">
                            <div class="layui-tab layui-tab-brief" lay-filter="user">
                                <ul class="layui-tab-title">
                                    <li class="layui-this">生成材料<!-- 编辑帖子 --></li>
                                </ul>
                                <div class="layui-form layui-tab-content" id="LAY_ucm" style="padding: 20px 0;">
                                    <div class="layui-tab-item layui-show">
                                        <form action="" method="post">
                                            <!--中文名-->
                                            <div class="layui-form-item">
                                                <label class="layui-form-label" style="text-align: left;">1.中文名</label>
                                                <div class="layui-input-block">
                                                    <input type="text" name="cn_name" placeholder="请输入中文名" autocomplete="off" class="layui-input">
                                                </div>
                                            </div>

                                            <!--日文名-->
                                            <div class="layui-form-item">
                                                <label class="layui-form-label" style="text-align: left;">2.日文名</label>
                                                <div class="layui-input-block">
                                                    <input type="text" name="jp_name" placeholder="请输入日文名" autocomplete="off" class="layui-input">
                                                </div>
                                            </div>

                                            <!--时间-->
                                            <div class="layui-form-item">
                                                <label class="layui-form-label" style="text-align: left;">3.时间</label>
                                                <div class="layui-input-block">
                                                    <select name="pb_time" lay-verify="required">
                                                        <option value="">请选择时间</option>
                                                        <option value="0">晚上</option>
                                                        <option value="1">早上</option>
                                                        <option value="2">其他</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!--五十音-->
                                            <div class="layui-form-item">
                                                <div class="layui-inline">
                                                    <label class="layui-form-label" style="text-align: left;">4.五十音</label>
                                                    <div class="layui-input-inline">
                                                        <input type="text" name="50_tone" placeholder="请输入五十音" autocomplete="off" class="layui-input">
                                                    </div>
                                                    <div class="layui-form-mid">-</div>
                                                    <div class="layui-input-inline">
                                                        <div class="layui-input-inline">
                                                            <input type="radio" name="hang_duan" value="行" title="行" checked>
                                                            <input type="radio" name="hang_duan" value="段" title="段">
                                                        </div>                                                    
                                                    </div>
                                                </div>
                                            </div>

                                            <!--单词-->
                                            <div class="layui-form-item layui-form-text">
                                                <label class="layui-form-label">5.单词</label>
                                                <div class="layui-input-block">
                                                    <textarea name="word" placeholder="请输入单词" class="layui-textarea"></textarea>
                                                </div>
                                            </div>

                                            <!--语法-->
                                            <div class="layui-form-item layui-form-text">
                                                <label class="layui-form-label">6.语法</label>
                                                <div class="layui-input-block">
                                                    <textarea name="grammar" placeholder="请输入语法" class="layui-textarea"></textarea>
                                                </div>
                                            </div>

                                            <!--表达方式-->
                                            <div class="layui-form-item">
                                                <label class="layui-form-label" style="text-align: left;">7.表达方式</label>
                                                <!--附加说明-->
                                                <div class="layui-input-block">
                                                    <input type="text" name="expression_additional" placeholder="请输入附加说明" autocomplete="off" class="layui-input">
                                                </div>
                                            </div>
                                            <div class="layui-form-item layui-form-text">
                                                <div class="layui-input-block">
                                                    <textarea name="expression" placeholder="请输入表达方式" class="layui-textarea"></textarea>
                                                </div>
                                            </div>

                                            <!--@人物-->
                                            <div class="layui-form-item layui-form-text">
                                                <label class="layui-form-label">8.@人物</label>
                                                <div class="layui-input-block">
                                                    <textarea name="friend" placeholder="请输入@人物" class="layui-textarea"></textarea>
                                                </div>
                                            </div>

                                            <!--每日一句-->
                                            <div class="layui-form-item layui-form-text">
                                                <label class="layui-form-label">9.每日一句</label>
                                                <div class="layui-input-block">
                                                    <textarea name="daily_sentence" placeholder="请输入每日一句" class="layui-textarea"></textarea>
                                                </div>
                                            </div>

                                            <!--操作-->
                                            <div class="layui-form-item">
                                                <button class="layui-btn" lay-submit lay-filter="generate">生成</button>
                                                <button type="reset" class="layui-btn layui-btn-danger">全部清空</button>
                                                <button type="button" class="layui-btn layui-btn-warm clean567">清空567</button>
                                                <button type="button" class="layui-btn layui-btn-normal copy_all">一键复制</button>

                                            </div>

                                            <!--详细操作-->
                                            <div class="layui-form-item">
                                                <button type="button" class="layui-btn layui-btn-sm layui-btn-primary copy_1">复制第1条</button>
                                                <button type="button" class="layui-btn layui-btn-sm layui-btn-primary copy_2">复制第2条</button>
                                                <button type="button" class="layui-btn layui-btn-sm layui-btn-primary copy_3">复制第3条</button>
                                                <button type="button" class="layui-btn layui-btn-sm layui-btn-primary copy_4">复制第4条</button>
                                                <button type="button" class="layui-btn layui-btn-sm layui-btn-primary copy_5">复制第5条</button>
                                                <button type="button" class="layui-btn layui-btn-sm layui-btn-primary copy_6">复制第6条</button>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--底部-->
        <div class="fly-footer">
            <p>&copy; 2014-<?php
                date_default_timezone_set("PRC");
                echo date("Y");
                ?><a href="http://www.manachannbu.com/" target="_blank">爱菜小部 All Rights Reserved.</a></p>
            <p>
                <a href="https://blog.mana.love/about/" target="_blank">关于我们</a>
                <a href="https://blog.mana.love/" target="_blank">联系我们</a>
                <a href="https://blog.mana.love/messages/" target="_blank">给我留言</a>
                <a href="https://blog.mana.love/messages/" target="_blank">每日一句</a>
            </p>
        </div>

        <script src="./lib/layui/layui.js"></script>
        <script src="https://cdn.bootcss.com/clipboard.js/1.7.1/clipboard.min.js"></script>       

        <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
        <!--[if lt IE 9]>
          <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
          <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <script>
//            遵循 layui 的模块规范建立一个入口文件，并通过 layui.use() 方式来加载该入口文件
            layui.config({
                base: './res/js/modules/' //你存放新模块的目录，注意，不是layui的模块目录
            }).use('index'); //加载入口
        </script>    

    </body>
</html>