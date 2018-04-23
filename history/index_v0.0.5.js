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
    initForm();
    console.log(localData);

//    初始化，设置表单
    function initForm() {
        if (typeof localData['cn_name'] !== 'undefined') {
            $('cite').text(localData['cn_name']);
            $('.local-name').text(localData['cn_name']);
        }
        setDefault('input', 'cn_name');
        setDefault('input', 'jp_name');
        setDefault('select', 'pb_time');
        setDefault('input', '50_tone');
        setDefault('radio', 'hang_duan');
        setDefault('textarea', 'word');
        setDefault('textarea', 'grammar');
        setDefault('textarea', 'expression');
        setDefault('textarea', 'expression_additional');
        setDefault('textarea', 'friend');
        setDefault('textarea', 'daily_sentence');
        form.render();
    }

    function setDefault(type, name) {
        if (typeof localData[name] !== 'undefined') {
            value = localData[name];
            if (type == 'radio') {
                $('input[name=' + name + '][value=' + value + ']').attr('checked', true);
            } else if (type == 'textarea') {
                $('textarea[name=' + name + ']').val(value);
            } else {
                $(type + '[name=' + name + ']').val(value);
            }
        }
    }

    function setEmpty(type, name) {
        if (type == 'textarea') {
            $('textarea[name=' + name + ']').val("");
        } else {
            $(type + '[name=' + name + ']').val("");
        }
    }

//    判断为空
    function isEmpty($value) {
        if (typeof $value == 'undefined' || $value == '') {
            return true;
        }
        return false;
    }

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
                layer.msg('第'+i+'条复制成功，请按键盘Ctrl+V粘贴到需要粘贴的地方\n\n');
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

        if (isEmpty(data['50_tone']) || isEmpty(data.word) || isEmpty(data.grammar)) {
            layer.msg('温馨提示\n五十音、单词、语法三项都要填写哦~~');
        } else {
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
            copyText('.copy_1', msg1, 1);
            copyText('.copy_2', msg2, 2);
            copyText('.copy_3', msg3, 3);
            copyText('.copy_4', msg4, 4);
            copyText('.copy_5', msg5, 5);
            copyText('.copy_6', msg6, 6);
            console.log(last_msg);
//            layer.msg(msg3);
        }

        return false;
    });

//  layer.msg('Hello World');

    exports('index', {}); //注意，这里是模块输出的核心，模块名必须和use时的模块名一致
});