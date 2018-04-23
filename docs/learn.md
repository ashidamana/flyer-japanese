layui v2.2.6学习
# 起步
引入layui.css、layui.js 
不用去管其它任何文件。因为他们（比如各模块）都是在最终使用的时候才会自动加载。
```
# 模块的定义和使用
//layui模块的定义
layui.define([mods], function(exports){
  
  //……
  
  exports('mod', api);
});  
 
//layui模块的使用
layui.use(['mod1', 'mod2'], function(args){
  var mod = layui.mod1;
  
  //……
  
});    
```
# 模块化的用法（推荐）
我们推荐你遵循 layui 的模块规范建立一个入口文件，并通过 layui.use() 方式来加载该入口文件，如下所示：
```
<script>
layui.config({
  base: '/res/js/modules/' //你存放新模块的目录，注意，不是layui的模块目录
}).use('index'); //加载入口
</script>    
```
# 核心基础库 layui.js 底层方法
## 全局配置
方法：layui.config(options)
你可以在使用模块之前，全局化配置一些参数，尽管大部分时候它不是必须的。
目前支持的全局配置项如下：
```
layui.config({
  dir: '/res/layui/' //layui.js 所在路径（注意，如果是script单独引入layui.js，无需设定该参数。），一般情况下可以无视
  ,version: false //一般用于更新模块缓存，默认不开启。设为true即让浏览器不缓存。也可以设为一个固定的值，如：201610
  ,debug: false //用于开启调试模式，默认false，如果设为true，则JS模块的节点会保留在页面
  ,base: '' //设定扩展的Layui模块的所在目录，一般用于外部模块扩展
});
```

## 定义模块
方法：layui.define([mods], callback)
通过该方法可定义一个 Layui模块。参数mods是可选的，用于声明该模块所依赖的模块。
callback即为模块加载完毕的回调函数，它返回一个exports参数，用于输出该模块的接口。
```
layui.define(function(exports){
  //do something
  
  exports('demo', function(){
    alert('Hello World!');
  });
});
```
跟Requirejs最大不同的地方在于接口输出，
exports是一个函数，它接受两个参数，第一个参数为模块名，第二个参数为模块接口，

你也可以在定义一个模块的时候，声明该模块所需的依赖，如：
```
layui.define(['layer', 'laypage'], function(exports){
  //do something
  
  exports('demo', function(){
    alert('Hello World!');
  });
});
```
上述的['layer', 'laypage']即为本模块所依赖的模块，
它并非只能是一个数组，你也可以直接传一个字符型的模块名，但是这样只能依赖一个模块。

## 加载所需模块
方法：layui.use([mods], callback)
Layui的内置模块并非默认就加载的，他必须在你执行该方法后才会加载。
它的参数跟上述的 define方法完全一样。 
另外请注意，mods里面必须是一个合法的模块名，不能包含目录。
如果需要加载目录，建议采用extend建立别名

```
layui.use(['laypage', 'layedit'], function(){
  var laypage = layui.laypage
  ,layedit = layui.layedit;
  
  //do something
});
```
该方法的函数其实返回了所加载的模块接口，所以你其实也可以不通过layui对象赋值获得接口（这一点跟Sea.js很像哈）：
```
layui.use(['laypage', 'layedit'], function(laypage, layedit){
  
  //使用分页
  laypage();
  
  //建立编辑器
  layedit.build();
});
```

## 动态加载CSS
方法：layui.link(href)
href即为css路径。注意：该方法并非是你使用Layui所必须的，它一般只是用于动态加载你的外部CSS文件。

## 本地存储
本地存储是对 localStorage 和 sessionStorage 的友好封装，可更方便地管理本地数据。
localStorage 持久化存储：
layui.data(table, settings)，数据会永久存在，除非物理删除。
sessionStorage 会话性存储：
layui.sessionData(table, settings)，页面关闭后即失效。注：layui 2.2.5 新增

上述两个方法的使用方式是完全一样的。
其中参数 table 为表名，settings是一个对象，用于设置key、value。
```
//【增】：向test表插入一个nickname字段，如果该表不存在，则自动建立。
layui.data('test', {
  key: 'nickname'
  ,value: '贤心'
});
 
//【删】：删除test表的nickname字段
layui.data('test', {
  key: 'nickname'
  ,remove: true
});
layui.data('test', null); //删除test表
  
//【改】：同【增】，会覆盖已经存储的数据
  
//【查】：向test表读取全部的数据
var localTest = layui.data('test');
console.log(localTest.nickname); //获得“贤心”
```
## 获取设备信息
方法：layui.device(key)，参数key是可选的
由于Layui的一些功能进行了兼容性处理和响应式支持，因此该方法同样发挥了至关重要的作用。
尤其是在layui mobile模块中的作用可谓举足轻重。该方法返回了丰富的设备信息：

```
var device = layui.device();
 
//device即可根据不同的设备返回下述不同的信息
{
  os: "windows" //底层操作系统，windows、linux、mac等
  ,ie: false //ie6-11的版本，如果不是ie浏览器，则为false
  ,weixin: false //是否微信环境
  ,android: false //是否安卓系统
  ,ios: false //是否ios系统
}
```
有时你的App可能会对userAgent插入一段特定的标识，譬如： 
Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.143 myapp/1.8.6 Safari/537.36

你要验证当前的WebView是否在你的App环境，
即可通过上述的myapp（即为Native给Webview插入的标识，可以随意定义）来判断。
```
var device = layui.device('myapp');
if(device.myapp){
  alert('在我的App环境');
}      
```
## 其它
其实除此之外，layui.js内部还提供了许多底层引擎，他们同样是整个Layui框架体系的有力支撑，
所以有必要露个脸，尽管你可能并不会用到：

方法/属性	描述
layui.cache	静态属性。获得一些配置及临时的缓存信息
layui.extend(options)	拓展一个模块别名，如：layui.extend({test: '/res/js/test'})
layui.each(obj, fn)	对象（Array、Object、DOM对象等）遍历，可用于取代for语句
layui.getStyle(node, name)	获得一个原始DOM节点的style属性值，如：layui.getStyle(document.body, 'font-size')
layui.img(url, callback, error)	图片预加载
layui.sort(obj, key, desc)	将数组中的对象按某个成员重新对该数组排序，如：layui.sort([{a: 3},{a: 1},{a: 5}], 'a')
layui.router()	获得location.hash路由，目前在Layui中没发挥作用。对做单页应用会派上用场。
layui.hint()	向控制台打印一些异常信息，目前只返回了error方法：layui.hint().error('出错啦')
layui.stope(e)	阻止事件冒泡
layui.onevent(modName, events, callback)	自定义模块事件，属于比较高级的应用。有兴趣的同学可以阅读layui.js源码以及form模块
layui.event(modName, events, params)	执行自定义模块事件，搭配onevent使用
layui.factory(modName)	用于获取模块对应的 define 回调函数

## 第三方支撑
Layui部分模块依赖jQuery（比如layer），但是你并不用去额外加载jQuery。
Layui已经将jQuery最稳定的一个版本改为Layui的内部模块，当你去使用 layer 之类的模块时，
它会首先判断你的页面是否已经引入了jQuery，如果没有，则加载内部的jQuery模块，如果有，则不会加载。
另外，我们的图标取材于阿里巴巴矢量图标库（iconfont），构建工具采用 Gulp 。
除此之外，不依赖于任何第三方工具。

# 页面元素规范与说明
Layui提倡返璞归真，遵循于原生态的元素书写规则，
所以通常而言，你仍然是在写基本的HTML和CSS代码，
不同的是，在HTML结构上及CSS定义上需要小小遵循一定的规范。

## CSS内置公共基础类
布局 / 容器
layui-main	用于设置一个宽度为 1140px 的水平居中块（无响应式）
layui-inline	用于将标签设为内联块状元素
layui-box	用于排除一些UI框架（如Bootstrap）强制将全部元素设为box-sizing: border-box所引发的尺寸偏差
layui-clear	用于消除浮动（一般不怎么常用，因为layui几乎没用到浮动）
layui-btn-container	用于定义按钮的父容器。（layui 2.2.5 新增）
layui-btn-fluid	用于定义流体按钮。即宽度最大化适应。（layui 2.2.5 新增）

辅助
layui-icon	用于图标
layui-elip	用于单行文本溢出省略
layui-unselect	用于屏蔽选中
layui-disabled	用于设置元素不可点击状态
layui-circle	用于设置元素为圆形
layui-show	用于显示块状元素
layui-hide	用于隐藏元素

文本
layui-text	定义一段文本区域（如文章），该区域内的特殊标签（如a、li、em等）将会进行相应处理
layui-word-aux	灰色标注性文字，左右会有间隔

背景色
layui-bg-red	用于设置元素赤色背景
layui-bg-orange	用于设置元素橙色背景
layui-bg-green	用于设置元素墨绿色背景（主色调）
layui-bg-cyan	用于设置元素藏青色背景
layui-bg-blue	用于设置元素蓝色背景
layui-bg-black	用于设置元素经典黑色背景
layui-bg-gray	用于设置元素经典灰色背景
其它的类一般都是某个元素或模块所特有，因此不作为我们所定义的公共类。

## CSS命名规范
class命名前缀：layui，连接符：-，如：class="layui-form"

命名格式一般分为两种：
一：layui-模块名-状态或类型，
二：layui-状态或类型。
因为有些类并非是某个模块所特有，他们通常会是一些公共类。
如：
一（定义按钮的原始风格）：class="layui-btn layui-btn-primary"、
二（定义内联块状元素）：class="layui-inline"

大致记住这些简单的规则，会让你在填充HTML的时候显得更加得心应手。
另外，如果你是开发Layui拓展（模块），你最好也要遵循于类似的规则，
并且请勿占用Layui已经命名好的类，
假设你是在帮Layui开发一个markdown编辑器，你的css书写规则应该如下：
```
.layui-markdown{border: 1px solid #e2e2e2;}
.layui-markdown-tools{}
.layui-markdown-text{}
```

## HTML规范：结构
Layui在解析HTML元素时，必须充分确保其结构是被支持的。以Tab选项卡为例：
```
<div class="layui-tab">
  <ul class="layui-tab-title">
    <li class="layui-this">标题一</li>
    <li>标题二</li>
    <li>标题三</li>
  </ul>
  <div class="layui-tab-content">
    <div class="layui-tab-item layui-show">内容1</div>
    <div class="layui-tab-item">内容2</div>
    <div class="layui-tab-item">内容3</div>
  </div>
</div>
```
你如果改变了结构，极有可能会导致Tab功能失效。
所以在嵌套HTML的时候，你应该细读各个元素模块的相关文档（如果你不是拿来主义）

## HTML规范：常用公共属性
很多时候，元素的基本交互行为，都是由模块自动开启。
但不同的区域可能需要触发不同的动作，
这就需要你设定我们所支持的自定义属性来作为区分。
如下面的 lay-submit、lay-filter即为公共属性（即以 lay- 作为前缀的自定义属性）：
```
<button class="layui-btn" lay-submit lay-filter="login">登入</button>
```
目前我们的公共属性如下所示（即普遍运用于所有元素上的属性）
属性	描述
lay-skin=" "	定义相同元素的不同风格，如checkbox的开关风格
lay-filter=" "	事件过滤器。你可能会在很多地方看到他，他一般是用于监听特定的自定义事件。你可以把它看作是一个ID选择器
lay-submit	定义一个触发表单提交的button，不用填写值

其它的自定义属性基本都在各自模块的文档中有所介绍。

其实很多时候并不想陈列条条框框（除了一些特定需要的），所以你会发现本篇的篇幅较短。

# 模块规范
layui 的模块是基于 layui.js 内部实现的异步模块加载方式，
它并不遵循于AMD（没有为什么，毕竟任性呀！），
而是自己定义了一套更轻量的模块规范。
并且这种方式在经过了大量的实践后，成为 layui 最核心的模块加载引擎。

## 预先加载
开门见山，还是直接说使用比较妥当。
Layui的模块加载采用核心的 layui.use(mods, callback)方法，
当你的JS 需要用到Layui模块的时候，我们更推荐你采用预先加载，
因为这样可以避免到处写layui.use的麻烦。你应该在最外层如此定义：
```
/*
  Demo1.js
  使用Layui的form和upload模块
*/
layui.use(['form', 'upload'], function(){  //如果只加载一个模块，可以不填数组。如：layui.use('form')
  var form = layui.form //获取form模块
  ,upload = layui.upload; //获取upload模块
  
  //监听提交按钮
  form.on('submit(test)', function(data){
    console.log(data);
  });
  
  //实例化一个上传控件
  upload({
    url: '上传接口url'
    ,success: function(data){
      console.log(data);
    }
  })
});
```
## 按需加载（不推荐）
如果你有强迫症，你对网站的性能有极致的要求，你并不想预先加载所需要的模块，
而是在触发一个动作的时候，才去加载模块，
那么，这是允许的。你不用在你的JS最外层去包裹一个大大的 layui.use，你只需要：
```
demo.jslayui.code
/*
  Demo2.js
  按需加载一个Layui模块
*/
 
//……
//你的各种JS代码什么的
//……
 
//下面是在一个事件回调里去加载一个Layui模块
button.addEventListener('click', function(){
  layui.use('laytpl', function(laytpl){ //温馨提示：多次调用use并不会重复加载laytpl.js，Layui内部有做模块cache处理。
    var html = laytpl('').render({});
    console.log(html);
  });
});
      
```
注意：如果你的 JS 中需要大量用到模块，我们并不推荐你采用这种加载方式，
因为这意味着你要写很多 layui.use()，代码可维护性不高。 
建议还是采用：预先加载。即一个JS文件中，写一个use即可。

## 模块命名空间
layui 的模块接口会绑定在 layui 对象下，内部由 layui.define() 方法来完成。
每一个模块都会一个特有的名字，并且无法被占用。
所以你无需担心模块的空间被污染，除非你主动 delete layui.{模块名}。
调用模块可通过 layui.use 方法来实现，然后再通过 layui 对象获得模块接口。如：
```
layui.use(['layer', 'laypage', 'laydate'], function(){
  var layer = layui.layer //获得layer模块
  ,laypage = layui.laypage //获得laypage模块
  ,laydate = layui.laydate; //获得laydate模块
  
  //使用模块
});      
```
我们推荐你将所有的业务代码都写在一个大的 use 回调中，
而不是将模块接口暴露给全局，比如下面的方式我们是极不推荐的：
```
//强烈不推荐下面的做法
var laypage, laydate;
layui.use(['laypage', 'laydate'], function(){
  laypage = layui.laypage;
  laydate = layui.laydate;
});
```
你之所以想使用上面的错误方式，是想其它地方使用不在执行一次 layui.use？
但这种理解本身是存在问题的。
因为如果一旦你的业务代码是在模块加载完毕之前执行，
你的全局对象将获取不到模块接口，
因此这样用不仅不符合规范，还存在报错风险。
建议在你的 js 文件中，在最外层写一个 layui.use 来加载所依赖的模块，
并将业务代码写在回调中，见：预先加载。

事实上，如果你不想采用 layui.use，你可以引入 layui.all.js 来替代 layui.js，见：非模块化用法

## 扩展一个 layui 模块
layui 官方提供的模块有时可能还无法满足你，
或者你试图按照layer的模块规范来扩展一个模块。
那么你有必要认识layui.define()方法，相信你在文档左侧的“底层方法”中已有所阅读。
下面就就让我们一起扩展一个Layui模块吧：
第一步：确认模块名，假设为：mymod，然后新建一个mymod.js 文件放入项目任意目录下（注意：不用放入layui目录）

第二步：编写test.js 如下：
```
/**
  扩展一个test模块
**/      
 
layui.define(function(exports){ //提示：模块也可以依赖其它模块，如：layui.define('layer', callback);
  var obj = {
    hello: function(str){
      alert('Hello '+ (str||'mymod'));
    }
  };
  
  //输出test接口
  exports('mymod', obj);
});    
```

第三步：设定扩展模块所在的目录，然后就可以在别的JS文件中使用了
```
//config的设置是全局的
layui.config({
  base: '/res/js/' //假设这是你存放拓展模块的根目录
}).extend({ //设定模块别名
  mymod: 'mymod' //如果 mymod.js 是在根目录，也可以不用设定别名
  ,mod1: 'admin/mod1' //相对于上述 base 目录的子目录
});
 
//你也可以忽略 base 设定的根目录，直接在 extend 指定路径（主要：该功能为 layui 2.2.0 新增）
layui.extend({
  mod2: '{/}http://cdn.xxx.com/lib/mod2' // {/}的意思即代表采用自有路径，即不跟随 base 路径
})
 
//使用拓展模块
layui.use(['mymod', 'mod1'], function(){
  var mymod = layui.mymod
  ,mod1 = layui.mod1
  ,mod2 = layui.mod2;
  
  mymod.hello('World!'); //弹出 Hello World!
});
```

其实关于模块的核心，就是 layui.js 的两个底层方法：
一个用于定义模块的 layui.define()，一个加载模块的 layui.use()。

# 常见问题
本篇将主要讲解使用过程中普遍遇到的“问题”，
这些问题并非是BUG，通常是需要我们自己去注意的一些点。（会结合用户反馈持续补充）

## 应该如何加载模块最科学？
事实上我们在模块规范已经有明确地说明，
你可以采用预先加载和按需加载两种模式，
但后者我们并不推荐（文档也解释原因了）。
因此我们强烈推荐的方式是：你应该在你js文件的代码最外层，就把需要用到的模块 layui.use以 一下，如：
```
/**
  你的js文件
**/
 
//我们强烈推荐你在代码最外层把需要用到的模块先加载
layui.use(['layer', 'form', 'element'], function(){
  var layer = layui.layer
  ,form = layui.form
  ,element = layui.element
 
  //……
  //你的代码都应该写在这里面
});
```

## 如何使用内部jQuery？
由于Layui部分内置模块依赖jQuery，
所以我们将jQuery1.11最稳定的一个版本作为一个内置的DOM模块（唯一的一个第三方模块）。
只有你所使用的模块有依赖到它，它才会加载，
并且如果你的页面已经script引入了jquery，它并不会重复加载。
内置的jquery模块去除了全局的$和jQuery，是一个符合layui规范的标准模块。
所以你必须通过以下方式得到：
```
//主动加载jquery模块
layui.use(['jquery', 'layer'], function(){ 
  var $ = layui.$ //重点处
  ,layer = layui.layer;
  
  //后面就跟你平时使用jQuery一样
  $('body').append('hello jquery');
});
 
//如果内置的模块本身是依赖jquery，你无需去use jquery，所以上面的写法其实可以是：
layui.use('layer', function(){ 
  var $ = layui.$ //由于layer弹层依赖jQuery，所以可以直接得到
  ,layer = layui.layer;
 
  //……
});
```
## 为什么表单不显示？
当你使用表单时，Layui会对select、checkbox、radio等原始元素隐藏，
从而进行美化修饰处理。
但这需要依赖于form组件，所以你必须加载 form，并且执行一个实例。
值得注意的是：导航的Hover效果、Tab选项卡等同理（它们需依赖 element 模块）

## 哪里有 layui 未压缩源代码？
我们的全部代码托管在GitHub（你可以通过首页的Star进入）和码云。
之所以在下载包里没有提供未压缩的源代码，是为了避免一些猿的使用混淆，
因为之前有遇到过部分可爱到极致的猿，居然同时引入了压缩过和未压缩过的layui.js，
虽然文档在“开始使用”中有相关的明确说明，
但这种问题仍然不是个例，使得我欲哭无泪啊啊啊，但毕竟我们要做“中国最容易使用的UI框架”，
因此才决定只对下载包提供我们构建后的代码，并且，由于是经过了压缩、合并等处理，所以更适合用于生产环境。

首先，多看文档啊亲！
那可是作者一个字节一个字节撸出来的，求珍惜。
你抽出一定时间仔细阅读文档，后面只会节省更多时间！ 
其次，实在无解，就请在社区反馈吧。
你也可以自己组织QQ群，在社区神马的地方拉一些 layui 的小伙伴，相互交流噢！

# 栅格系统与后台布局
在 layui 2.0 的版本中，我们加入了强劲的栅格系统和后台布局方案，
这意味着你终于可以着手采用 layui 排版你的响应式网站和后台系统了。
layui 的栅格系统采用业界比较常见的 12 等分规则，
内置移动设备、平板、桌面中等和大型屏幕的多终端适配处理，最低能支持到ie8。
而你应当更欣喜的是，layui 终于开放了它经典的后台布局方案，
快速搭建一个属于你的后台系统将变得十分轻松自如。

## 栅格系统
为了丰富网页布局，简化 HTML/CSS 代码的耦合，并提升多终端的适配能力，
layui 在 2.0 的版本中引进了自己的一套具备响应式能力的栅格系统。
我们将容器进行了 12 等分，预设了 4*12 种 CSS 排列类，
它们在移动设备、平板、桌面中/大尺寸四种不同的屏幕下发挥着各自的作用。

格布局规则：

1.采用 layui-row 来定义行，如：<div class="layui-row"></div>
2.采用类似 layui-col-md* 这样的预设类来定义一组列（column），且放在行（row）内。其中：
变量md 代表的是不同屏幕下的标记（可选值见下文）
变量* 代表的是该列所占用的12等分数（如6/12），可选值为 1 - 12
如果多个列的“等分数值”总和等于12，则刚好满行排列。如果大于12，多余的列将自动另起一行。
3.列可以同时出现最多四种不同的组合，分别是：xs（超小屏幕，如手机）、sm（小屏幕，如平板）、md（桌面中等屏幕）、lg（桌面大型屏幕），以呈现更加动态灵活的布局。
4.可对列追加类似 layui-col-space5、 layui-col-md-offset3 这样的预设类来定义列的间距和偏移。
5.最后，在列（column）元素中放入你自己的任意元素填充内容，完成布局！

```
<div class="layui-container">  
  常规布局（以中型屏幕桌面为例）：
  <div class="layui-row">
    <div class="layui-col-md9">
      你的内容 9/12
    </div>
    <div class="layui-col-md3">
      你的内容 3/12
    </div>
  </div>
   
  移动设备、平板、桌面端的不同表现：
  <div class="layui-row">
    <div class="layui-col-xs6 layui-col-sm6 layui-col-md4">
      移动：6/12 | 平板：6/12 | 桌面：4/12
    </div>
    <div class="layui-col-xs6 layui-col-sm6 layui-col-md4">
      移动：6/12 | 平板：6/12 | 桌面：4/12
    </div>
    <div class="layui-col-xs4 layui-col-sm12 layui-col-md4">
      移动：4/12 | 平板：12/12 | 桌面：4/12
    </div>
    <div class="layui-col-xs4 layui-col-sm7 layui-col-md8">
      移动：4/12 | 平板：7/12 | 桌面：8/12
    </div>
    <div class="layui-col-xs4 layui-col-sm5 layui-col-md4">
      移动：4/12 | 平板：5/12 | 桌面：4/12
    </div>
  </div>
</div>
```
响应式规则：
栅格的响应式能力，得益于CSS3媒体查询（Media Queries）的强力支持，从而针对四类不同尺寸的屏幕，进行相应的适配处理
	超小屏幕
(手机<768px)	小屏幕
(平板≥768px)	中等屏幕
(桌面≥992px)	大型屏幕
(桌面≥1200px)
.layui-container的值	auto	750px	970px	1170px
标记	xs	sm	md	lg
列对应类
* 为1-12的等分数值	layui-col-xs*	layui-col-sm*	layui-col-md*	layui-col-lg*
总列数	12
响应行为	始终按设定的比例水平排列	在当前屏幕下水平排列，如果屏幕大小低于临界值则堆叠排列

响应式公共类：

类名（class）	说明
layui-show-*-block	定义不同设备下的 display: block; * 可选值有：xs、sm、md、lg
layui-show-*-inline	定义不同设备下的 display: inline; * 可选值同上
layui-show-*-inline-block	定义不同设备下的 display: inline-block; * 可选值同上
layui-hide-*	定义不同设备下的隐藏类，即： display: none; * 可选值同上

布局容器：

将栅格放入一个带有 class="layui-container" 的特定的容器中，
以便在小屏幕以上的设备中固定宽度，让列可控。

```
<div class="layui-container">
  <div class="layui-row">
    ……
  </div>
</div>      
```

当然，你还可以不固定容器宽度。
将栅格或其它元素放入一个带有 class="layui-fluid" 的容器中，
那么宽度将不会固定，而是 100% 适应
```
<div class="layui-fluid">
  ……
</div>  
```

列间距：

通过“列间距”的预设类，来设定列之间的间距。
且一行中最左的列不会出现左边距，最右的列不会出现右边距。
列间距在保证排版美观的同时，还可以进一步保证分列的宽度精细程度。
我们结合网页常用的边距，预设了 12 种不同尺寸的边距，分别是：

layui-col-space1	列之间间隔 1px
layui-col-space3	列之间间隔 3px
layui-col-space5	列之间间隔 5px
layui-col-space8	列之间间隔 8px
layui-col-space10	列之间间隔 10px
layui-col-space12	列之间间隔 12px
layui-col-space15	列之间间隔 15px
layui-col-space18	列之间间隔 18px
layui-col-space20	列之间间隔 20px
layui-col-space22	列之间间隔 22px
layui-col-space28	列之间间隔 28px
layui-col-space30	列之间间隔 30px

下面是一个简单的例子，列间距为10px：
```
<div class="layui-row layui-col-space10">
  <div class="layui-col-md4">
    1/3
  </div>
  <div class="layui-col-md4">
    1/3
  </div>
  <div class="layui-col-md4">
    1/3
  </div>
</div>
```

如果需要的间距高于30px（一般不常见），请采用偏移，下文继续讲解

列偏移：

对列追加 类似 layui-col-md-offset* 的预设类，从而让列向右偏移。
其中 * 号代表的是偏移占据的列数，可选中为 1 - 12。 
如：layui-col-md-offset3，即代表在“中型桌面屏幕”下，让该列向右偏移3个列宽度

```
<div class="layui-row">
  <div class="layui-col-md4">
    4/12
  </div>
  <div class="layui-col-md4 layui-col-md-offset4">
    偏移4列，从而在最右
  </div>
</div>
```
请注意，列偏移可针对不同屏幕的标准进行设定，比如上述的例子，
只会在桌面屏幕下有效，当低于桌面屏幕的规定的临界值，就会堆叠排列。

栅格嵌套：

理论上，你可以对栅格进行无穷层次的嵌套，这更加增强了栅格的表现能力。
而嵌套的使用非常简单。
在列元素（layui-col-md*）中插入一个行元素（layui-row），即可完成嵌套。
下面是一个简单的例子：
```
<div class="layui-row layui-col-space5">
  <div class="layui-col-md5">
    <div class="layui-row grid-demo">
      <div class="layui-col-md3">
        内部列
      </div>
      <div class="layui-col-md9">
        内部列
      </div>
      <div class="layui-col-md12">
        内部列
      </div>
    </div>
  </div>
  <div class="layui-col-md7">
    <div class="layui-row grid-demo grid-demo-bg1">
      <div class="layui-col-md12">
        内部列
      </div>
      <div class="layui-col-md9">
        内部列
      </div>
      <div class="layui-col-md3">
        内部列
      </div>
    </div>
  </div>
</div>
```

让IE8/9兼容栅格：
事实上IE8和IE9并不支持媒体查询（Media Queries），但你可以使用下面的补丁完美兼容！
该补丁来自于开源社区：
```
<!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
<!--[if lt IE 9]>
  <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
  <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
```
将上述代码放入你页面 <body> 标签内的任意位置

## 后台布局
layui 之所以赢得如此多人的青睐，更多是在于它前后台系统通吃的能力。
既可编织出绚丽的前台页面，又可满足繁杂的后台功能需求。
layui 致力于让每一位开发者都能轻松搭建自己的后台。
下面是 layui 提供的一个现场的方案，你可以前往示例页面，预览后台布局效果
```
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <title>layout 后台大布局 - Layui</title>
  <link rel="stylesheet" href="../src/css/layui.css">
</head>
<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin">
  <div class="layui-header">
    <div class="layui-logo">layui 后台布局</div>
    <!-- 头部区域（可配合layui已有的水平导航） -->
    <ul class="layui-nav layui-layout-left">
      <li class="layui-nav-item"><a href="">控制台</a></li>
      <li class="layui-nav-item"><a href="">商品管理</a></li>
      <li class="layui-nav-item"><a href="">用户</a></li>
      <li class="layui-nav-item">
        <a href="javascript:;">其它系统</a>
        <dl class="layui-nav-child">
          <dd><a href="">邮件管理</a></dd>
          <dd><a href="">消息管理</a></dd>
          <dd><a href="">授权管理</a></dd>
        </dl>
      </li>
    </ul>
    <ul class="layui-nav layui-layout-right">
      <li class="layui-nav-item">
        <a href="javascript:;">
          <img src="http://t.cn/RCzsdCq" class="layui-nav-img">
          贤心
        </a>
        <dl class="layui-nav-child">
          <dd><a href="">基本资料</a></dd>
          <dd><a href="">安全设置</a></dd>
        </dl>
      </li>
      <li class="layui-nav-item"><a href="">退了</a></li>
    </ul>
  </div>
  
  <div class="layui-side layui-bg-black">
    <div class="layui-side-scroll">
      <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
      <ul class="layui-nav layui-nav-tree"  lay-filter="test">
        <li class="layui-nav-item layui-nav-itemed">
          <a class="" href="javascript:;">所有商品</a>
          <dl class="layui-nav-child">
            <dd><a href="javascript:;">列表一</a></dd>
            <dd><a href="javascript:;">列表二</a></dd>
            <dd><a href="javascript:;">列表三</a></dd>
            <dd><a href="">超链接</a></dd>
          </dl>
        </li>
        <li class="layui-nav-item">
          <a href="javascript:;">解决方案</a>
          <dl class="layui-nav-child">
            <dd><a href="javascript:;">列表一</a></dd>
            <dd><a href="javascript:;">列表二</a></dd>
            <dd><a href="">超链接</a></dd>
          </dl>
        </li>
        <li class="layui-nav-item"><a href="">云市场</a></li>
        <li class="layui-nav-item"><a href="">发布商品</a></li>
      </ul>
    </div>
  </div>
  
  <div class="layui-body">
    <!-- 内容主体区域 -->
    <div style="padding: 15px;">内容主体区域</div>
  </div>
  
  <div class="layui-footer">
    <!-- 底部固定区域 -->
    © layui.com - 底部固定区域
  </div>
</div>
<script src="../src/layui.js"></script>
<script>
//JavaScript代码区域
layui.use('element', function(){
  var element = layui.element;
  
});
</script>
</body>
</html>
```

# layui 颜色设计感
视觉疲劳的形成往往是由于颜色过于丰富或过于单一形成的麻木感，
而 layui 提供的颜色，清新而不乏深沉，互相柔和，不过分刺激大脑皮层的神经反应，
形成越久越耐看的微妙影像。
合理搭配，可与各式各样的网站避免违和，从而使你的Web平台看上去更为融洽。

常用主色
layui 主要是以象征包容的墨绿作为主色调，
由于它给人以深沉感，所以通常会以浅黑色的作为其陪衬，
又会以蓝色这种比较鲜艳的色调来弥补它的色觉疲劳，
整体让人清新自然，愈发耐看。
【取色意义】：我们执着于务实，不盲目攀比，又始终不忘绽放活力。
这正是 layui 所追求的价值。

场景色
事实上，layui 并非不敢去尝试一些亮丽的颜色，
但许多情况下一个它可能并不是那么合适，
所以我们把这些颜色归为“场景色”，
即按照实际场景来呈现对应的颜色，比如你想给人以警觉感，可以尝试用上面的红色。
他们一般会出现在 layui 的按钮、提示和修饰性元素，以及一些侧边元素上。

极简中性色
他们一般用于背景、边框等
layui 认为灰色系代表极简，因为这是一种神奇的颜色，几乎可以与任何元素搭配，\
不易形成视觉疲劳，且永远不会过时。低调而优雅！

内置的背景色CSS类

layui 内置了七种背景色，以便你用于各种元素中，如：徽章、分割线、导航等等
```
赤色：class="layui-bg-red"
橙色：class="layui-bg-orange"
墨绿：class="layui-bg-green"
藏青：class="layui-bg-cyan"
蓝色：class="layui-bg-blue"
雅黑：class="layui-bg-black"
银灰：class="layui-bg-gray"
```

“不热衷于视觉设计的程序猿不是一个好作家！” ——贤心

# 字体图标
layui 的所有图标全部采用字体形式，取材于阿里巴巴矢量图标库（iconfont）。
因此你可以把一个icon看作是一个普通的文字，
这意味着你直接用css控制文字属性，如color、font-size，就可以改变图标的颜色和大小。
而区分不同的图标，我们主要是采用 Unicode 字符

使用方式
通过对一个内联元素（一般推荐用 i标签）设定 class="layui-icon"，来定义一个图标，
然后对元素加上图标对应的 Unicode 字符，即可显示出你想要的图标，譬如：
```
<i class="layui-icon">&#xe60c;</i>   
其中的 &#xe60c; 即是图标对应的Unicode字符
 
你可以去定义它的颜色或者大小，如：  
<i class="layui-icon" style="font-size: 30px; color: #1E9FFF;">&#xe60c;</i>  
```
内置图标一览表（119个）

跨域问题的解决
由于浏览器存在同源策略，
所以如果layui（里面含图标字体文件）所在的地址与你当前的页面地址不在同一个域下，
即会出现图标跨域问题。
所以要么你就把Layui与网站放在同一服务器，
要么就对Layui所在的资源服务器的Response Headers加上属性：Access-Control-Allow-Origin: *

# CSS3动画类
在实用价值的前提之下，我们并没有内置过多花俏的动画。
而他们同样在 layui 的许多交互元素中，发挥着重要的作用。
layui 的动画全部采用 CSS3，因此不支持ie8和部分不支持ie9（即ie8/9无动画）

使用方式
动画的使用非常简单，直接对元素赋值动画特定的 class 类名即可。如：
```
其中 layui-anim 是必须的，后面跟着的即是不同的动画类
<div class="layui-anim layui-anim-up"></div>
 
循环动画，追加：layui-anim-loop
<div class="layui-anim layui-anim-up layui-anim-loop"></div>
```

内置CSS3动画一览表
下面是不同的动画类名，数量可能有点少的样子？
但正如开头所讲的，拒绝冗余花俏，拥抱精简实用。点击下述绿色块，可直接预览动画

从最底部往上滑入
layui-anim-up
 
微微往上滑入
layui-anim-upbit
 
平滑放大
layui-anim-scale
 
弹簧式放大
layui-anim-scaleSpring
渐现
layui-anim-fadein
 
渐隐
layui-anim-fadeout
 
360度旋转
layui-anim-rotate
 
循环动画
追加：layui-anim-loop
 结语
物不在多，有用则精。

# 按钮 - 页面元素
向任意HTML元素设定class="layui-btn"，建立一个基础按钮。
通过追加格式为layui-btn-{type}的class来定义其它按钮风格。
内置的按钮class可以进行任意组合，从而形成更多种按钮风格。
```
<button class="layui-btn">一个标准的按钮</button>
<a href="http://www.layui.com" class="layui-btn">一个可跳转的按钮</a>
```
主题
名称	组合
原始	class="layui-btn layui-btn-primary"
默认	class="layui-btn"
百搭	class="layui-btn layui-btn-normal"
暖色	class="layui-btn layui-btn-warm"
警告	class="layui-btn layui-btn-danger"
禁用	class="layui-btn layui-btn-disabled"

尺寸
尺寸	组合
大型	class="layui-btn layui-btn-lg"
默认	class="layui-btn"
小型	class="layui-btn layui-btn-sm"
迷你	class="layui-btn layui-btn-xs"

尺寸	组合
大型百搭	class="layui-btn layui-btn-lg layui-btn-normal"
正常暖色	class="layui-btn layui-btn-warm"
小型警告	class="layui-btn layui-btn-sm layui-btn-danger"
迷你禁用	class="layui-btn layui-btn-xs layui-btn-disabled"
```
<button class="layui-btn layui-btn-fluid">流体按钮（最大化适应）</button>
```

圆角
原始	class="layui-btn layui-btn-radius layui-btn-primary"
默认	class="layui-btn layui-btn-radius"
百搭	class="layui-btn layui-btn-radius layui-btn-normal"
暖色	class="layui-btn layui-btn-radius layui-btn-warm"
警告	class="layui-btn layui-btn-radius layui-btn-danger"
禁用	class="layui-btn layui-btn-radius layui-btn-disabled"

大型百搭	class="layui-btn layui-btn-lg layui-btn-radius layui-btn-normal"
小型警告	class="layui-btn layui-btn-sm layui-btn-radius layui-btn-danger"
迷你禁用	class="layui-btn layui-btn-xs layui-btn-radius layui-btn-disabled"

图标
<button class="layui-btn">
  <i class="layui-icon">&#xe608;</i> 添加
</button>
 
<button class="layui-btn layui-btn-sm layui-btn-primary">
  <i class="layui-icon">&#x1002;</i>
</button>

按钮组
将按钮放入一个class="layui-btn-group"元素中，即可形成按钮组，按钮本身仍然可以随意搭配
```
<div class="layui-btn-group">
  <button class="layui-btn">增加</button>
  <button class="layui-btn">编辑</button>
  <button class="layui-btn">删除</button>
</div>
      
<div class="layui-btn-group">
  <button class="layui-btn layui-btn-sm">
    <i class="layui-icon">&#xe654;</i>
  </button>
  <button class="layui-btn layui-btn-sm">
    <i class="layui-icon">&#xe642;</i>
  </button>
  <button class="layui-btn layui-btn-sm">
    <i class="layui-icon">&#xe640;</i>
  </button>
  <button class="layui-btn layui-btn-sm">
    <i class="layui-icon">&#xe602;</i>
  </button>
</div>
 
<div class="layui-btn-group">
  <button class="layui-btn layui-btn-primary layui-btn-sm">
    <i class="layui-icon">&#xe654;</i>
  </button>
  <button class="layui-btn layui-btn-primary layui-btn-sm">
    <i class="layui-icon">&#xe642;</i>
  </button>
  <button class="layui-btn layui-btn-primary layui-btn-sm">
    <i class="layui-icon">&#xe640;</i>
  </button>
</div>
```
按钮容器
尽管按钮在同节点并排时会自动拉开间距，
但在按钮太多的情况，效果并不是很美好。
因为你需要用到按钮容器

<div class="layui-btn-container">
  <button class="layui-btn">按钮一</button> 
  <button class="layui-btn">按钮二</button> 
  <button class="layui-btn">按钮三</button> 
</div>

你是否发现，主题、尺寸、图标、圆角的交叉组合，可以形成难以计算的按钮种类。
另外，你可能最关注的是配色，
Layui内置的六种主题的按钮颜色都是业界常用的标准配色，
如果他们仍然无法与你的网站契合，那么请先允许我“噗”一声。。。
然后你就大胆地自撸一个颜色吧！比如：粉红色或者菊花色（一个有味道的颜色）

# 表单 - 页面元素

在一个容器中设定 class="layui-form" 来标识一个表单元素块，
通过规范好的HTML结构及CSS类，来组装成各式各样的表单元素，
并通过内置的 form模块 来完成各种交互。
依赖加载模块：form 
（请注意：如果不加载form模块，select、checkbox、radio等将无法显示，并且无法使用form相关功能）

```
<form class="layui-form" action="">
  <div class="layui-form-item">
    <label class="layui-form-label">输入框</label>
    <div class="layui-input-block">
      <input type="text" name="title" required  lay-verify="required" placeholder="请输入标题" autocomplete="off" class="layui-input">
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">密码框</label>
    <div class="layui-input-inline">
      <input type="password" name="password" required lay-verify="required" placeholder="请输入密码" autocomplete="off" class="layui-input">
    </div>
    <div class="layui-form-mid layui-word-aux">辅助文字</div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">选择框</label>
    <div class="layui-input-block">
      <select name="city" lay-verify="required">
        <option value=""></option>
        <option value="0">北京</option>
        <option value="1">上海</option>
        <option value="2">广州</option>
        <option value="3">深圳</option>
        <option value="4">杭州</option>
      </select>
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">复选框</label>
    <div class="layui-input-block">
      <input type="checkbox" name="like[write]" title="写作">
      <input type="checkbox" name="like[read]" title="阅读" checked>
      <input type="checkbox" name="like[dai]" title="发呆">
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">开关</label>
    <div class="layui-input-block">
      <input type="checkbox" name="switch" lay-skin="switch">
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">单选框</label>
    <div class="layui-input-block">
      <input type="radio" name="sex" value="男" title="男">
      <input type="radio" name="sex" value="女" title="女" checked>
    </div>
  </div>
  <div class="layui-form-item layui-form-text">
    <label class="layui-form-label">文本域</label>
    <div class="layui-input-block">
      <textarea name="desc" placeholder="请输入内容" class="layui-textarea"></textarea>
    </div>
  </div>
  <div class="layui-form-item">
    <div class="layui-input-block">
      <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
      <button type="reset" class="layui-btn layui-btn-primary">重置</button>
    </div>
  </div>
</form>
 
<script>
//Demo
layui.use('form', function(){
  var form = layui.form;
  
  //监听提交
  form.on('submit(formDemo)', function(data){
    layer.msg(JSON.stringify(data.field));
    return false;
  });
});
</script>
```
UI的最终呈现得益于 Form模块 的全自动渲染，
她将原本普通的诸如select、checkbox、radio等元素重置为你所看到的模样。
或许你可以移步左侧导航的 内置模块 中的 表单 对其进行详细的了解。

表单元素本身，譬如规定的区块、CSS类、原始控件等。他们共同组成了一个表单体系。

下述是基本的行区块结构，它提供了响应式的支持。
但如果你不大喜欢，你可以换成你的结构，但必须要在外层容器中定义class="layui-form"，
form模块才能正常工作。

```
<div class="layui-form-item">
  <label class="layui-form-label">标签区域</label>
  <div class="layui-input-block">
    原始表单元素区域
  </div>
</div>
```
## 输入框
```
<input type="text" name="title" required lay-verify="required" placeholder="请输入标题" autocomplete="off" class="layui-input">   
```
required：注册浏览器所规定的必填字段 
lay-verify：注册form模块需要验证的类型 
class="layui-input"：layui.css提供的通用CSS类 

## 下拉选择框
```
<select name="city" lay-verify="">
  <option value="">请选择一个城市</option>
  <option value="010">北京</option>
  <option value="021">上海</option>
  <option value="0571">杭州</option>
</select>     
```

上述option的第一项主要是占个坑，让form模块预留“请选择”的提示空间，
否则将会把第一项（存在value值）作为默认选中项。
你可以在option的空值项中自定义文本，如：请选择分类。

你可以通过设定 selected 来设定默认选中项：
```
<select name="city" lay-verify="">
  <option value="010">北京</option>
  <option value="021" disabled>上海（禁用效果）</option>
  <option value="0571" selected>杭州</option>
</select>     
```

你还可以通过 optgroup 标签给select分组：
```
<select name="quiz">
  <option value="">请选择</option>
  <optgroup label="城市记忆">
    <option value="你工作的第一个城市">你工作的第一个城市？</option>
  </optgroup>
  <optgroup label="学生时代">
    <option value="你的工号">你的工号？</option>
    <option value="你最喜欢的老师">你最喜欢的老师？</option>
  </optgroup>
</select>
```
以及通过设定属性 lay-search 来开启搜索匹配功能
```
<select name="city" lay-verify="" lay-search>
  <option value="010">layer</option>
  <option value="021">form</option>
  <option value="0571" selected>layim</option>
  ……
</select>    
```
属性selected可设定默认项 
属性disabled开启禁用，select和option标签都支持

## 复选框
```
默认风格：
<input type="checkbox" name="" title="写作" checked>
<input type="checkbox" name="" title="发呆"> 
<input type="checkbox" name="" title="禁用" disabled> 
 
原始风格：
<input type="checkbox" name="" title="写作" lay-skin="primary" checked>
<input type="checkbox" name="" title="发呆" lay-skin="primary"> 
<input type="checkbox" name="" title="禁用" lay-skin="primary" disabled> 
```

属性title可自定义文本（温馨提示：如果只想显示复选框，可以不用设置title） 
属性checked可设定默认选中 
属性lay-skin可设置复选框的风格 
设置value="1"可自定义值，否则选中时返回的就是默认的on

## 开关
其实就是checkbox复选框的“变种”，通过设定 lay-skin="switch" 形成了开关风格
```
<input type="checkbox" name="xxx" lay-skin="switch">
<input type="checkbox" name="yyy" lay-skin="switch" lay-text="ON|OFF" checked>
<input type="checkbox" name="zzz" lay-skin="switch" lay-text="开启|关闭">
<input type="checkbox" name="aaa" lay-skin="switch" disabled
```
属性checked可设定默认开 
属性disabled开启禁用 
属性lay-text可自定义开关两种状态的文本 
设置value="1"可自定义值，否则选中时返回的就是默认的on

## 单选框
```
<input type="radio" name="sex" value="nan" title="男">
<input type="radio" name="sex" value="nv" title="女" checked>
<input type="radio" name="sex" value="" title="中性" disabled>
```
属性title可自定义文本 
属性disabled开启禁用 
设置value="xxx"可自定义值，否则选中时返回的就是默认的on

## 文本域
```
<textarea name="" required lay-verify="required" placeholder="请输入" class="layui-textarea"></textarea>
```
class="layui-textarea"：layui.css提供的通用CSS类 

## 组装行内表单
```
<div class="layui-form-item">
 
  <div class="layui-inline">
    <label class="layui-form-label">范围</label>
    <div class="layui-input-inline" style="width: 100px;">
      <input type="text" name="price_min" placeholder="￥" autocomplete="off" class="layui-input">
    </div>
    <div class="layui-form-mid">-</div>
    <div class="layui-input-inline" style="width: 100px;">
      <input type="text" name="price_max" placeholder="￥" autocomplete="off" class="layui-input">
    </div>
  </div>
  
  <div class="layui-inline">
    <label class="layui-form-label">密码</label>
    <div class="layui-input-inline" style="width: 100px;">
      <input type="password" name="" autocomplete="off" class="layui-input">
    </div>
  </div>
  
</div>
```
class="layui-inline"：定义外层行内 
class="layui-input-inline"：定义内层行内

## 忽略美化渲染
你可以对表单元素增加属性 lay-ignore 设置后，将不会对该标签进行美化渲染，即保留系统风格，比如：
```
<select lay-ignore>
  <option>…</option>
</select>
```
一般不推荐这样做。
事实上form组件所提供的接口，对其渲染过的元素，足以应付几乎所有的业务需求。
如果忽略渲染，可能会让UI风格不和谐

## 表单方框风格
通过追加 layui-form-pane 的class，来设定表单的方框风格。内部结构不变。我们的Fly社区用的就是这个风格。
```
<form class="layui-form layui-form-pane" action="">
  内部结构都一样，值得注意的是 复选框/开关/单选框 这些组合在该风格下需要额外添加 pane属性（否则会看起来比较别扭），如：
  <div class="layui-form-item" pane>
    <label class="layui-form-label">单选框</label>
    <div class="layui-input-block">
      <input type="radio" name="sex" value="男" title="男">
      <input type="radio" name="sex" value="女" title="女" checked>
    </div>
  </div>
</form>
```

Layui版本稳定后，会抽空推出一个表单元素生成工具，这样似乎就更方便地组装你的表单了呀。

# 导航相关 - 页面元素
导航一般指页面引导性频道集合，多以菜单的形式呈现，可应用于头部和侧边，是整个网页画龙点晴般的存在。
面包屑结构简单，支持自定义分隔符。
千万不要忘了加载 element模块。
虽然大部分行为都是在加载完该模块后自动完成的，
但一些交互操作，如呼出二级菜单等，需借助element模块才能使用。
你可以移步文档左侧【内置模块 - 常用元素操作 element】了解详情
依赖加载模块：element

## 水平导航
```
<ul class="layui-nav" lay-filter="">
  <li class="layui-nav-item"><a href="">最新活动</a></li>
  <li class="layui-nav-item layui-this"><a href="">产品</a></li>
  <li class="layui-nav-item"><a href="">大数据</a></li>
  <li class="layui-nav-item">
    <a href="javascript:;">解决方案</a>
    <dl class="layui-nav-child"> <!-- 二级菜单 -->
      <dd><a href="">移动模块</a></dd>
      <dd><a href="">后台模版</a></dd>
      <dd><a href="">电商平台</a></dd>
    </dl>
  </li>
  <li class="layui-nav-item"><a href="">社区</a></li>
</ul>
 
<script>
//注意：导航 依赖 element 模块，否则无法进行功能性操作
layui.use('element', function(){
  var element = layui.element;
  
  //…
});
</script>
```
设定layui-this来指向当前页面分类。
导航中的其它元素

除了一般的文字导航，我们还内置了图片和徽章的支持，如：
```
<ul class="layui-nav">
  <li class="layui-nav-item">
    <a href="">控制台<span class="layui-badge">9</span></a>
  </li>
  <li class="layui-nav-item">
    <a href="">个人中心<span class="layui-badge-dot"></span></a>
  </li>
  <li class="layui-nav-item">
    <a href=""><img src="http://t.cn/RCzsdCq" class="layui-nav-img">我</a>
    <dl class="layui-nav-child">
      <dd><a href="javascript:;">修改信息</a></dd>
      <dd><a href="javascript:;">安全管理</a></dd>
      <dd><a href="javascript:;">退了</a></dd>
    </dl>
  </li>
</ul>
```
是否瞬间上了个档次呢？

## 导航主题
通过对导航追加CSS背景类，让导航呈现不同的主题色
```
//如定义一个墨绿背景色的导航
<ul class="layui-nav layui-bg-green" lay-filter="">
  …
</ul>      
```
水平导航支持的其它背景主题有：layui-bg-cyan（藏青）、layui-bg-molv（墨绿）、layui-bg-blue（艳蓝） 
垂直导航支持的其它背景主题有：layui-bg-cyan（藏青）

## 垂直/侧边导航
```
<ul class="layui-nav layui-nav-tree" lay-filter="test">
<!-- 侧边导航: <ul class="layui-nav layui-nav-tree layui-nav-side"> -->
  <li class="layui-nav-item layui-nav-itemed">
    <a href="javascript:;">默认展开</a>
    <dl class="layui-nav-child">
      <dd><a href="javascript:;">选项1</a></dd>
      <dd><a href="javascript:;">选项2</a></dd>
      <dd><a href="">跳转</a></dd>
    </dl>
  </li>
  <li class="layui-nav-item">
    <a href="javascript:;">解决方案</a>
    <dl class="layui-nav-child">
      <dd><a href="">移动模块</a></dd>
      <dd><a href="">后台模版</a></dd>
      <dd><a href="">电商平台</a></dd>
    </dl>
  </li>
  <li class="layui-nav-item"><a href="">产品</a></li>
  <li class="layui-nav-item"><a href="">大数据</a></li>
</ul>
```
水平、垂直、侧边三个导航的HTML结构是完全一样的，不同的是：
垂直导航需要追加class：layui-nav-tree 
侧边导航需要追加class：layui-nav-tree layui-nav-side

## 导航可选属性

对导航元素结构设定可选属性，可让导航菜单项达到不同效果。目前支持的属性如下：

属性名	可选值	说明
lay-shrink	
空值（默认）
不收缩兄弟菜单子菜单
all
收缩全部兄弟菜单子菜单
展开子菜单时，是否收缩兄弟节点已展开的子菜单 （注：layui 2.2.6 开始新增） 
如：<ul class="layui-nav layui-nav-tree" lay-shrink="all"> … </ul>
lay-unselect	无需填值	点击指定导航菜单时，不会出现选中效果（注：layui 2.2.0 开始新增） 
如：<li class="layui-nav-item" lay-unselect>刷新</li>

## 面包屑
```
<span class="layui-breadcrumb">
  <a href="">首页</a>
  <a href="">国际新闻</a>
  <a href="">亚太地区</a>
  <a><cite>正文</cite></a>
</span>
```
你还可以通过设置属性 lay-separator="-" 来自定义分隔符。如： 首页- 国际新闻- 亚太地区- 正文

```
<span class="layui-breadcrumb" lay-separator="-">
  <a href="">首页</a>
  <a href="">国际新闻</a>
  <a href="">亚太地区</a>
  <a><cite>正文</cite></a>
</span>
```
当然，你还可以作为小导航来用，如：
```
<span class="layui-breadcrumb" lay-separator="|">
  <a href="">娱乐</a>
  <a href="">八卦</a>
  <a href="">体育</a>
  <a href="">搞笑</a>
  <a href="">视频</a>
  <a href="">游戏</a>
  <a href="">综艺</a>
</span>
```

# Tab选项卡 - 页面元素
导航菜单可应用于头部和侧边，Tab选项卡提供多套风格，支持响应式，支持删除选项卡等功能。
面包屑结构简单，支持自定义分隔符。
依赖加载组件：element 
（请注意：必须加载element模块，相关功能才能正常使用，详见：内置组件 - 常用元素操作）

## 默认Tab选项卡
Tab广泛应用于Web页面，因此我们也对其进行了良好的支持。Layui内置多种Tab风格，支持删除选项卡、并提供响应式支持。 
这是一个最基本的例子：
```
<div class="layui-tab">
  <ul class="layui-tab-title">
    <li class="layui-this">网站设置</li>
    <li>用户管理</li>
    <li>权限分配</li>
    <li>商品管理</li>
    <li>订单管理</li>
  </ul>
  <div class="layui-tab-content">
    <div class="layui-tab-item layui-show">内容1</div>
    <div class="layui-tab-item">内容2</div>
    <div class="layui-tab-item">内容3</div>
    <div class="layui-tab-item">内容4</div>
    <div class="layui-tab-item">内容5</div>
  </div>
</div>
 
<script>
//注意：选项卡 依赖 element 模块，否则无法进行功能性操作
layui.use('element', function(){
  var element = layui.element;
  
  //…
});
</script>
```
如果需要对Tab进行外部新增、删除、切换等操作，请移步到“内置组件-常用元素操作”页面中查阅：基础方法

## Tab简洁风格
```
<div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
  <ul class="layui-tab-title">
    <li class="layui-this">网站设置</li>
    <li>用户管理</li>
    <li>权限分配</li>
    <li>商品管理</li>
    <li>订单管理</li>
  </ul>
  <div class="layui-tab-content"></div>
</div>      
```
通过追加class：layui-tab-brief 来设定简洁风格。
值得注意的是，如果存在 layui-tab-item 的内容区域，在切换时自动定位到对应内容。
如果不存在内容区域，则不会定位到对应内容。
你通常需要设置过滤器，通过 element模块的监听tab事件来进行切换操作。
详见文档左侧【内置组件 - 基本元素操作 element】

## Tab卡片风格
```
<div class="layui-tab layui-tab-card">
  <ul class="layui-tab-title">
    <li class="layui-this">网站设置</li>
    <li>用户管理</li>
    <li>权限分配</li>
    <li>商品管理</li>
    <li>订单管理</li>
  </ul>
  <div class="layui-tab-content" style="height: 100px;">
    <div class="layui-tab-item layui-show">1</div>
    <div class="layui-tab-item">2</div>
    <div class="layui-tab-item">3</div>
    <div class="layui-tab-item">4</div>
    <div class="layui-tab-item">5</div>
    <div class="layui-tab-item">6</div>
  </div>
</div>
```
通过追加class：layui-tab-card来设定卡片风格

## Tab响应式
当容器的宽度不足以显示全部的选项时，即会自动出现展开图标，
如下以卡片风格为例（注意：所有Tab风格都支持响应式）
额，感觉像是打了个小酱油。而事实上在自适应的页面中（不固宽），它的意义才会呈现。

## 带删除的Tab
你可以对父层容器设置属性 lay-allowClose="true" 来允许Tab选项卡被删除
```
<div class="layui-tab" lay-allowClose="true">
  <ul class="layui-tab-title">
    <li class="layui-this">网站设置</li>
    <li>用户基本管理</li>
    <li>权限分配</li>
    <li>全部历史商品管理文字长一点试试</li>
    <li>订单管理</li>
  </ul>
  <div class="layui-tab-content">
    <div class="layui-tab-item layui-show">1</div>
    <div class="layui-tab-item">2</div>
    <div class="layui-tab-item">3</div>
    <div class="layui-tab-item">4</div>
    <div class="layui-tab-item">5</div>
    <div class="layui-tab-item">6</div>
  </div>
</div>
```
与默认相比没有什么特别的结构，就是多了个属性 lay-allowClose="true"

## ID焦点定位
你可以通过对选项卡设置属性 lay-id="xxx" 来作为唯一的匹配索引，
以用于外部的定位切换，如后台的左侧导航、以及页面地址 hash的匹配。

```
<div class="layui-tab" lay-filter="test1">
  <ul class="layui-tab-title">
    <li class="layui-this" lay-id="111" >文章列表</li>
    <li lay-id="222">发送信息</li>
    <li lay-id="333">权限分配</li>
    <li lay-id="444">审核</li>
    <li lay-id="555">订单管理</li>
  </ul>
  <div class="layui-tab-content">
    <div class="layui-tab-item layui-show">1</div>
    <div class="layui-tab-item">2</div>
    <div class="layui-tab-item">3</div>
    <div class="layui-tab-item">4</div>
    <div class="layui-tab-item">5</div>
  </div>
</div>
```
属性 lay-id 是扮演这项功能的主要角色，它是动态操作的重要凭据，如：

```
<script>
layui.use('element', function(){
  var element = layui.element;
  
  //获取hash来切换选项卡，假设当前地址的hash为lay-id对应的值
  var layid = location.hash.replace(/^#test1=/, '');
  element.tabChange('test1', layid); //假设当前地址为：http://a.com#test1=222，那么选项卡会自动切换到“发送消息”这一项
  
  //监听Tab切换，以改变地址hash值
  element.on('tab(test1)', function(){
    location.hash = 'test1='+ this.getAttribute('lay-id');
  });
});
</script>      
```

同样的还有增加选项卡和删除选项卡，都需要用到 lay-id，更多动态操作请阅读：element模块

无论是导航、还是Tab，都需依赖 element模块，
大部分行为都是在加载完该模块后自动完成的，但一些交互操作，如Tab事件监听等，需按照场景选择性使用。
你可以移步文档左侧【内置组件 - 基本元素操作 element】了解详情

# 进度条 - 页面元素
进度条可应用于许多业务场景，如任务完成进度、loading等等，是一种较为直观的表达元素。
依赖加载组件：element

## 常规用法
我们进度条提供了两种尺寸及多种颜色的显示风格，
其中颜色的选值可参考：背景色公共类。基本元素结构如下
```
<div class="layui-progress">
  <div class="layui-progress-bar" lay-percent="10%"></div>
</div>
 
<script>
//注意进度条依赖 element 模块，否则无法进行正常渲染和功能性操作
layui.use('element', function(){
  var element = layui.element;
});
</script>
```
属性 lay-percent ：代表进度条的初始百分比，你也可以动态改变进度，详见：进度条的动态操作

正如上述你见到的，
当对元素设置了class为 layui-progress-big 时，即为大尺寸的进度条风格。
默认风格的进度条的百分比如果开启，会在右上角显示，而大号进度条则会在内部显示。


## 显示进度比文本
通过对父级元素设置属性 lay-showPercent="yes" 来开启进度比的文本显示，支持：普通数字、百分数、分数（layui 2.1.7 新增）

```
<div class="layui-progress" lay-showPercent="true">
  <div class="layui-progress-bar layui-bg-red" lay-percent="1/3"></div>
</div>
       
<div class="layui-progress" lay-showPercent="yes">
  <div class="layui-progress-bar layui-bg-red" lay-percent="30%"></div>
</div>
 
<div class="layui-progress layui-progress-big" lay-showPercent="yes">
  <div class="layui-progress-bar layui-bg-green" lay-percent="50%"></div>
</div>
```

注意：默认情况下不会显示百分比文本，
如果你想开启，对属性lay-showPercent设置任意值即可，如：yes。
但如果不想显示，千万别设置no或者false，直接剔除该属性即可。

## 大号进度条
如果短小细长的它不大适合追求激情与视觉冲击的你，那么你完全可以选择大而粗，尽情地销魂于活塞运动。
研究表明：上述尺寸刚刚好。

```
<div class="layui-progress layui-progress-big">
  <div class="layui-progress-bar" lay-percent="20%"></div>
</div>
 
<div class="layui-progress layui-progress-big">
  <div class="layui-progress-bar layui-bg-orange" lay-percent="50%"></div>
</div>
 
<div class="layui-progress layui-progress-big" lay-showPercent="true">
  <div class="layui-progress-bar layui-bg-blue" lay-percent="80%"></div>
</div>
```

正如上述你见到的，当对元素设置了class为 layui-progress-big 时，即为大尺寸的进度条风格。默认风格的进度条的百分比如果开启，会在右上角显示，而大号进度条则会在内部显示。

如果你需要对进度条进行动态操作，如动态改变进度，那么你需要阅读：element模块


# 面板 - 页面元素

一般的面板通常是指一个独立的容器，而折叠面板则能有效地节省页面的可视面积，
非常适合应用于：QA说明、帮助文档等
依赖加载组件：element

## 折叠面板
通过对内容元素设置class为 layui-show 来选择性初始展开某一个面板，element 模块会自动呈现状态图标。
```
<div class="layui-collapse">
  <div class="layui-colla-item">
    <h2 class="layui-colla-title">杜甫</h2>
    <div class="layui-colla-content layui-show">内容区域</div>
  </div>
  <div class="layui-colla-item">
    <h2 class="layui-colla-title">李清照</h2>
    <div class="layui-colla-content layui-show">内容区域</div>
  </div>
  <div class="layui-colla-item">
    <h2 class="layui-colla-title">鲁迅</h2>
    <div class="layui-colla-content layui-show">内容区域</div>
  </div>
</div>
 
<script>
//注意：折叠面板 依赖 element 模块，否则无法进行功能性操作
layui.use('element', function(){
  var element = layui.element;
  
  //…
});
</script>
```
## 开启手风琴
在折叠面板的父容器设置属性 lay-accordion 来开启手风琴，那么在进行折叠操作时，始终只会展现当前的面板。

```
<div class="layui-collapse" lay-accordion>
  <div class="layui-colla-item">
    <h2 class="layui-colla-title">杜甫</h2>
    <div class="layui-colla-content layui-show">内容区域</div>
  </div>
  <div class="layui-colla-item">
    <h2 class="layui-colla-title">李清照</h2>
    <div class="layui-colla-content layui-show">内容区域</div>
  </div>
  <div class="layui-colla-item">
    <h2 class="layui-colla-title">鲁迅</h2>
    <div class="layui-colla-content layui-show">内容区域</div>
  </div>
</div>
```
# 表格 - 页面元素
本篇为你介绍表格的HTML使用，你将通过内置的自定义属性对其进行风格的多样化设定。请注意：这仅仅局限于呈现基础表格，
如果你急切需要的是数据表格（datatable），那么你应该详细阅读：table模块

## 常规用法
```
<table class="layui-table">
  <colgroup>
    <col width="150">
    <col width="200">
    <col>
  </colgroup>
  <thead>
    <tr>
      <th>昵称</th>
      <th>加入时间</th>
      <th>签名</th>
    </tr> 
  </thead>
  <tbody>
    <tr>
      <td>贤心</td>
      <td>2016-11-29</td>
      <td>人生就像是一场修行</td>
    </tr>
    <tr>
      <td>许闲心</td>
      <td>2016-11-28</td>
      <td>于千万人之中遇见你所遇见的人，于千万年之中，时间的无涯的荒野里…</td>
    </tr>
  </tbody>
</table>
```

## 基础属性
静态表格支持以下基础属性，可定义不同风格/尺寸的表格样式：
属性名	属性值	备注
lay-even	无	用于开启 隔行 背景，可与其它属性一起使用
lay-skin="属性值"	line （行边框风格） 
row （列边框风格） 
nob （无边框风格）	若使用默认风格不设置该属性即可
lay-size="属性值"	sm （小尺寸） 
lg （大尺寸）	若使用默认尺寸不设置该属性即可
将你所需要的基础属性写在table标签上即可，如（一个带有隔行背景，且行边框风格的大尺寸表格）：
```
<table lay-even lay-skin="line" lay-size="lg">
…
</table>
```

## 表格其它风格
除了默认的表格风格外，我们还提供了其它几种风格，你可以按照实际需求自由设定
```
<table class="layui-table" lay-skin="line">
  行边框表格（内部结构参见右侧目录“常规用法”）
</table>
 
<table class="layui-table" lay-skin="row">
  列边框表格（内部结构参见右侧目录“常规用法”）
</table>
 
<table class="layui-table" lay-even lay-skin="nob">
  无边框表格（内部结构参见右侧目录“常规用法”）
</table>
```
## 表格其它尺寸
除了默认的表格尺寸外，我们还提供了其它几种尺寸，你可以按照实际需求自由设定
```
<table class="layui-table" lay-size="sm">
  小尺寸表格（内部结构参见右侧目录“常规用法”）
</table>
 
<table class="layui-table" lay-size="lg">
  大尺寸表格（内部结构参见右侧目录“常规用法”）
</table>
```

如果你需要对表格进行排序、数据交互等一系列功能性操作，你需要进一步阅读 layui 的重要组成：table模块

# 徽章
徽章是一个修饰性的元素，它们本身细小而并不显眼，但掺杂在其它元素中就显得尤为突出了。
页面往往因徽章的陪衬，而显得十分和谐。

## 快速使用
你可能已经敏锐地发现，除去花枝招展的七种颜色，徽章具有三种不同的风格类型：小圆点、椭圆体、边框体
```
小圆点，通过 layui-badge-dot 来定义，里面不能加文字
<span class="layui-badge-dot"></span>
<span class="layui-badge-dot layui-bg-orange"></span>
<span class="layui-badge-dot layui-bg-green"></span>
<span class="layui-badge-dot layui-bg-cyan"></span>
<span class="layui-badge-dot layui-bg-blue"></span>
<span class="layui-badge-dot layui-bg-black"></span>
<span class="layui-badge-dot layui-bg-gray"></span>
 
椭圆体，通过 layui-badge 来定义。事实上我们把这个视作为主要使用方式
<span class="layui-badge">6</span>
<span class="layui-badge">99</span>
<span class="layui-badge">61728</span>
 
<span class="layui-badge">赤</span>
<span class="layui-badge layui-bg-orange">橙</span>
<span class="layui-badge layui-bg-green">绿</span>
<span class="layui-badge layui-bg-cyan">青</span>
<span class="layui-badge layui-bg-blue">蓝</span>
<span class="layui-badge layui-bg-black">黑</span>
<span class="layui-badge layui-bg-gray">灰</span>
 
边框体，通过 layui-badge-rim 来定义
<span class="layui-badge-rim">6</span>
<span class="layui-badge-rim">Hot</span>
```
# 与其它元素的搭配
徽章主要是修饰作用，因此必不可少要与几乎所有的元素搭配。我们目前对以下元素内置了徽章的排版支持：
按钮
```
<button class="layui-btn">查看消息<span class="layui-badge layui-bg-gray">1</span></button>
<button class="layui-btn">动态<span class="layui-badge-dot layui-bg-orange"></span></button>
```
导航
```
<ul class="layui-nav" style="text-align: right;"> <-- 小Tips：这里有没有发现，设置导航靠右对齐（或居中对齐）其实非常简单 -->
  <li class="layui-nav-item">
    <a href="">控制台<span class="layui-badge">9</span></a>
  </li>
  <li class="layui-nav-item">
    <a href="">个人中心<span class="layui-badge-dot"></span></a>
  </li>
</ul>
```

选项卡（所有风格都支持，这里以简约风格为例）
```
<div class="layui-tab layui-tab-brief">
  <ul class="layui-tab-title">
    <li class="layui-this">网站设置</li>
    <li>用户管理<span class="layui-badge-dot"></span></li>
    <li>最新邮件<span class="layui-badge">99+</span></li>
  </ul>
  <div class="layui-tab-content"></div>
</div>
```
而至于与其它更多元素的搭配，就由你自由把控吧！
其实，在与其它元素的搭配中，你要做的，无非就是合理运用这几点：边距 背景色，徽章必然大显神威！

# 时间线
将时间抽象到二维平面，垂直呈现一段从过去到现在的故事。

## 快速使用
```
<ul class="layui-timeline">
  <li class="layui-timeline-item">
    <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
    <div class="layui-timeline-content layui-text">
      <h3 class="layui-timeline-title">8月18日</h3>
      <p>
        layui 2.0 的一切准备工作似乎都已到位。发布之弦，一触即发。
        <br>不枉近百个日日夜夜与之为伴。因小而大，因弱而强。
        <br>无论它能走多远，抑或如何支撑？至少我曾倾注全心，无怨无悔 <i class="layui-icon"></i>
      </p>
    </div>
  </li>
  <li class="layui-timeline-item">
    <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
    <div class="layui-timeline-content layui-text">
      <h3 class="layui-timeline-title">8月16日</h3>
      <p>杜甫的思想核心是儒家的仁政思想，他有“<em>致君尧舜上，再使风俗淳</em>”的宏伟抱负。个人最爱的名篇有：</p>
      <ul>
        <li>《登高》</li>
        <li>《茅屋为秋风所破歌》</li>
      </ul>
    </div>
  </li>
  <li class="layui-timeline-item">
    <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
    <div class="layui-timeline-content layui-text">
      <h3 class="layui-timeline-title">8月15日</h3>
      <p>
        中国人民抗日战争胜利72周年
        <br>常常在想，尽管对这个国家有这样那样的抱怨，但我们的确生在了最好的时代
        <br>铭记、感恩
        <br>所有为中华民族浴血奋战的英雄将士
        <br>永垂不朽
      </p>
    </div>
  </li>
  <li class="layui-timeline-item">
    <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
    <div class="layui-timeline-content layui-text">
      <div class="layui-timeline-title">过去</div>
    </div>
  </li>
</ul>
```
关于时间线，似乎也没有什么太多可介绍的东西。你需要留意的是以下几点

图标可以任意定义（但并不推荐更改）
标题区域并不意味着一定要加粗
内容区域可自由填充。

授之以鱼不如授之以渔，时间线怎么用，就看你的了。

# 简单辅助元素 - 页面元素
本篇主要集中罗列页面中的一些简单辅助元素，如：引用块、字段集区块、横线等等，
这些元素都无需依赖任何模块

## 引用区块
目前内置了上述两种风格
```
<blockquote class="layui-elem-quote">引用区域的文字</blockquote>
<blockquote class="layui-elem-quote layui-quote-nm">引用区域的文字</blockquote>
```

## 字段集区块
同样内置了两种风格，另一种风格即该文档的标题横线：字段集一行
```
<fieldset class="layui-elem-field">
  <legend>字段集区块 - 默认风格</legend>
  <div class="layui-field-box">
    内容区域
  </div>
</fieldset>
 
<fieldset class="layui-elem-field layui-field-title">
  <legend>字段集区块 - 横线风格</legend>
  <div class="layui-field-box">
    内容区域
  </div>
</fieldset>
你可以把它看作是一个有标题的横线
```

## 横线
```
默认分割线
<hr>
 
赤色分割线
<hr class="layui-bg-red">
 
橙色分割线
<hr class="layui-bg-orange">
 
墨绿分割线
<hr class="layui-bg-green">
 
青色分割线
<hr class="layui-bg-cyan">
 
蓝色分割线
<hr class="layui-bg-blue">
 
黑色分割线
<hr class="layui-bg-black">
 
灰色分割线
<hr class="layui-bg-gray">
```