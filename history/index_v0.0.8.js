/**
 项目JS主入口
 以依赖layui的layer和form模块为例
 **/
layui.define(['layer', 'form', 'element', 'util'], function (exports) {
    var layer = layui.layer
            , element = layui.element
            , util = layui.util
            , $ = layui.$
            , form = layui.form;
    var localData = layui.data('flyer_japanese');
    console.log(localData);
    initForm();
    consoleMyLog();

//    个性化console打印
    function consoleMyLog() {
        console.log('%c小飞鸟日语学习监督部%c,由爱菜家、希望之神小飞鸟于2017年09月07日成立，以互相学习，互相监督，共同进步为目标。\n采用极具实践性、持续性、高效性的小飞鸟&啊叶联合日语学习模式，于2017年09月11日起正式实施。\n', 'color:#FF5722;font-size:20px;', 'color:#1E9FFF;font-size:16px;');
        console.log('%c', 'padding:80px 150px;background:url(https://ooo.0o0.ooo/2017/06/27/5951e19dce0d3.png) no-repeat;line-height:200px;height:1px;');
        console.log('%c爱菜镇console', 'color:#5FB878;font-size:18px;');
    }

//    五十音随机化
    function fiftyTone() {
//        console.log('测试');
        var hang_duan;
        var fifty_tone;
//        这样定义行出现的概率高一些
        var arr0 = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14];
        var index1 = Math.floor((Math.random() * arr0.length));
//        console.log(index1);
        if (index1 <= 4) {
            index1 = 1;
        } else {
            index1 = 0;
        }
        hang_duan = (index1 == 0) ? '行' : '段';
        var arr = new Array();
        arr[0] = ['あ', 'か', 'さ', 'た', 'な', 'は', 'ま', 'や', 'ら', 'わ', 'が', 'ざ', 'だ', 'ば', 'ぱ'];
        arr[1] = ['あ', 'い', 'う', 'え', 'お'];
        index2 = Math.floor((Math.random() * arr[index1].length));
        fifty_tone = arr[index1][index2];
        var r = {
            'fifty_tone': fifty_tone,
            'hang_duan': hang_duan,
        };
//        console.log(arr);
//        console.log(r);
        return r;
    }


//    初始化，设置表单
    function initForm() {
        if (typeof localData['cn_name'] !== 'undefined') {
            $('cite').text(localData['cn_name']);
            $('.local-name').text(localData['cn_name']);
        }
        var fifty_tone = fiftyTone();
        setDefault('input', 'cn_name');
        setDefault('input', 'jp_name');
        setDefault('select', 'pb_time');
        setDefault('input', '50_tone', fifty_tone.fifty_tone);
        setDefault('radio', 'hang_duan', fifty_tone.hang_duan);
        setDefault('textarea', 'word');
        setDefault('textarea', 'grammar');
        setDefault('textarea', 'expression');
        setDefault('textarea', 'expression_additional');
        setDefault('textarea', 'friend');
        setDefault('textarea', 'daily_sentence');
//       如果generate_time跟今天不一致，则说明需要清空5，6,7
        if (typeof localData['generate_time'] !== 'undefined' && localData['generate_time'] != util.toDateString(new Date().getTime(), 'yyyy-MM-dd')) {
            clean567();
            console.log('需要清空5,6,7');
        }

        form.render();
    }

//    设置时间
    function setTime() {
        var hour = new Date().getHours();
        if (hour <= 9) {
            t = 1;
        } else if (hour <= 18) {
            t = 2;
        } else {
            t = 0;
        }
        return t;
    }

//    设置默认值
    function setDefault(type, name, value) {
        if (typeof localData[name] !== 'undefined') {
            if (isEmpty(value)) {
                value = localData[name];
            }

            if (type == 'radio') {
                $('input[name=' + name + '][value=' + value + ']').attr('checked', true);
            } else if (type == 'textarea') {
                $('textarea[name=' + name + ']').val(value);
            } else {
                if (type == 'select') {
                    value = setTime();
                }
                $(type + '[name=' + name + ']').val(value);
            }
        }
    }

//    将值设为空
    function setEmpty(type, name) {
        if (type == 'textarea') {
            $('textarea[name=' + name + ']').val("");
        } else {
            $(type + '[name=' + name + ']').val("");
        }
    }

//    判断是否为空
    function isEmpty($value) {
        if (typeof $value == 'undefined' || $value == '') {
            return true;
        }
        return false;
    }

//    获取中文时间
    function getCnTime($i) {
        var r;
        if ($i == 0) {
            r = '晚上';
        } else if ($i == 1) {
            r = '早上';
        } else {
            r = '大家';
        }
        r += '好';
        return r;
    }

//    获取日文时间
    function getJpTime($i) {
        var r;
        if ($i == 0) {
            r = 'こんばんは';
        } else if ($i == 1) {
            r = 'おはようございます';
        } else {
            r = 'こんにちは';
        }
        return r;
    }

//    数组随机排序
    lib = {}
    lib.range = function (min, max) {
        return min + Math.floor(Math.random() * (max - min + 1));
    }

    Array.prototype.shuffle = function (n) {
        var len = this.length,
                num = n ? Math.min(n, len) : len,
                arr = this.slice(0),
                temp,
                index;
        for (var i = 0; i < len; i++) {
            index = lib.range(i, len - 1);
            temp = arr[i];
            arr[i] = arr[index];
            arr[index] = temp;
        }
        return arr.slice(0, num);
    }

//    将字符串分割成数组在随机排序在合并成数组返回
    function getshuffleString(str) {
        var arr = str.split('\n');
        arr = arr.shuffle();
        str = arr.join('\n');
        return str;
    }

//    清空567
    $('.clean567').on('click', function () {
        clean567();
        layer.msg('5、6、7项清空成功');
    });

    function clean567() {
        setEmpty('textarea', 'word');
        setEmpty('textarea', 'grammar');
        setEmpty('textarea', 'expression');
        setEmpty('input', 'expression_additional');
    }

//    复制文本
    function copyText(selector, txt, i) {
        var clipboard = new Clipboard(selector, {
            // 点击copy按钮，直接通过text直接返回复印的内容
            text: function () {
                return txt;
            }
        });

        clipboard.on('success', function (e) {
            if (i == 0) {
                layer.msg('一键复制成功，请按键盘Ctrl+V粘贴到需要粘贴的地方\n\n');
            } else {
                layer.msg('第' + i + '条复制成功，请按键盘Ctrl+V粘贴到需要粘贴的地方\n\n');
            }
        });

        clipboard.on('error', function (e) {
            console.log(e);
        });
    }

    //监听提交
    form.on('submit(generate)', function (data) {
//        layer.msg(JSON.stringify(data.field));
//        console.log(data);

        data = data.field;
//        数据存储localStorage
        layui.data('flyer_japanese', {
            key: 'cn_name'
            , value: $.trim(data.cn_name)
        });
        layui.data('flyer_japanese', {
            key: 'jp_name'
            , value: $.trim(data.jp_name)
        });
        layui.data('flyer_japanese', {
            key: 'pb_time'
            , value: $.trim(data.pb_time)
        });
        layui.data('flyer_japanese', {
            key: '50_tone'
            , value: $.trim(data['50_tone'])
        });
        layui.data('flyer_japanese', {
            key: 'hang_duan'
            , value: $.trim(data.hang_duan)
        });
        layui.data('flyer_japanese', {
            key: '50_tone_time'
            , value: util.toDateString(new Date().getTime(), 'yyyy-MM-dd')
        });
        layui.data('flyer_japanese', {
            key: 'word'
            , value: $.trim(data.word)
        });
        layui.data('flyer_japanese', {
            key: 'grammar'
            , value: $.trim(data.grammar)
        });
        layui.data('flyer_japanese', {
            key: 'expression'
            , value: $.trim(data.expression)
        });
        layui.data('flyer_japanese', {
            key: 'expression_additional'
            , value: $.trim(data.expression_additional)
        });
        layui.data('flyer_japanese', {
            key: 'friend'
            , value: $.trim(data.friend)
        });
        layui.data('flyer_japanese', {
            key: 'daily_sentence'
            , value: $.trim(data.daily_sentence)
        });

        layui.data('flyer_japanese', {
            key: 'daily_sentence_time'
            , value: util.toDateString(new Date().getTime(), 'yyyy-MM-dd')
        });

//        生成日期，便于判断是否执行去年清空5,6,7
        layui.data('flyer_japanese', {
            key: 'generate_time'
            , value: util.toDateString(new Date().getTime(), 'yyyy-MM-dd')
        });

        if (isEmpty(data['50_tone']) || isEmpty(data.word) || isEmpty(data.grammar)) {
            layer.msg('温馨提示\n五十音、单词、语法三项都要填写哦~~');
        } else {
//            数据生成与复制
            var u = {
                'cn_name': isEmpty(data.cn_name) ? '小飞鸟' : data.cn_name,
                'jp_name': isEmpty(data.jp_name) ? '飛鳥メイラン' : data.jp_name,
                'cn_time': getCnTime(data.pb_time),
                'jp_time': getJpTime(data.pb_time),
                '50_tone': data['50_tone'],
                'hang_duan': data.hang_duan,
                'word': data.word,
                'grammar': data.grammar,
                'expression': data.expression,
                'expression_additional': data.expression_additional,
                'friend': data.friend,
                'daily_sentence': data.daily_sentence,
            };
            var msg1 = '皆さん、' + u.jp_time + '、' + u.jp_name + 'です。\n';
            msg1 += '童鞋们，' + u.cn_time + '，我是' + u.cn_name + '。\n';
            msg1 += '我们的目标是互相学习、互相监督、共同进步。\n' + util.toDateString(new Date().getTime(), 'yyyy-MM-dd') + '\n\n';

            var msg2 = '------我是传说中滴分割线------\n\n';

            var msg3 = '今天的默写内容如下，请大家拿出纸和笔，默写完拍照发上来，' + u.cn_name + '会帮大家检查的。\n\n';
            msg3 += '1.请默写' + u['50_tone'] + u.hang_duan + '所有假名的平假名和片假名\n\n';
            msg3 += '2.请默写下面的单词或短语\n\n';
            var word = getshuffleString(u.word);
            var grammar = getshuffleString(u.grammar);

            msg3 += word;
            msg3 += '\n\n3.请翻译下面的句子或对话\n\n';
            msg3 += grammar + '\n\n';
            if (!isEmpty(u.expression)) {
                var expression = getshuffleString(u.expression);
                if (isEmpty(u.expression_additional)) {
                    msg3 += '4.请翻译下面的表达方式\n\n';
                } else {
                    msg3 += '4.请翻译下面的表达方式（' + u.expression_additional + '）\n\n';
                }
                msg3 += expression + '\n\n';
            }

            var msg4 = data.friend + '\n\n';
            var msg5 = '皆さん、' + u.jp_time + '。\n\n';
            var msg6 = '每日一句：\n';
            msg6 += u.daily_sentence;
            var last_msg = msg1 + msg2 + msg3 + msg4 + msg5 + msg6;
            copyText('.copy_all', last_msg, 0);
            copyText('.copy_1', $.trim(msg1), 1);
            copyText('.copy_2', $.trim(msg2), 2);
            copyText('.copy_3', $.trim(msg3), 3);
            copyText('.copy_4', $.trim(msg4), 4);
            copyText('.copy_5', $.trim(msg5), 5);
            copyText('.copy_6', $.trim(msg6), 6);
//            console.log(last_msg);
            layer.msg('恭喜，您需要的默写材料生成成功！\n\n请点击「一键复制」按钮复制全部内容，或者按从左到右顺序分别点击「复制第1-6条」按钮分条复制(=^_^=)');
        }

        return false;
    });

//  layer.msg('Hello World');

//    时钟
    $(function () {
        var clock = $('#clock');
        //定义数字数组0-9
        var digit_to_name = ['zero', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'];
        //定义星期
        var weekday = ['周日', '周一', '周二', '周三', '周四', '周五', '周六'];

        var digits = {};

        //定义时分秒位置
        var positions = [
            'h1', 'h2', ':', 'm1', 'm2', ':', 's1', 's2'
        ];

        //构建数字时钟的时分秒

        var digit_holder = clock.find('.digits');

        $.each(positions, function () {

            if (this == ':') {
                digit_holder.append('<div class="dots">');
            }
            else {

                var pos = $('<div>');

                for (var i = 1; i < 8; i++) {
                    pos.append('<span class="d' + i + '">');
                }

                digits[this] = pos;

                digit_holder.append(pos);
            }

        });

        // 让时钟跑起来
        (function update_time() {

            //调用moment.js来格式化时间
            var now = moment().format("HHmmss");

            digits.h1.attr('class', digit_to_name[now[0]]);
            digits.h2.attr('class', digit_to_name[now[1]]);
            digits.m1.attr('class', digit_to_name[now[2]]);
            digits.m2.attr('class', digit_to_name[now[3]]);
            digits.s1.attr('class', digit_to_name[now[4]]);
            digits.s2.attr('class', digit_to_name[now[5]]);

            var date = moment().format("YYYY年MM月DD日");
            var week = weekday[moment().format('d')];
            $(".date").html(date + ' ' + week);


            // 每秒钟运行一次
            setTimeout(update_time, 1000);

        })();
    });
//    时钟


    exports('index', {}); //注意，这里是模块输出的核心，模块名必须和use时的模块名一致
});