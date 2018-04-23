<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>小飞鸟日语学习监督部</title>
        <link rel="shortcut icon" href="https://blog.mana.love/img/favicon.png">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="keywords" content="小飞鸟日语学习监督部,MANA-CHANN-BU!!!,爱菜小部,Manachannbu,愛菜ちゃん部,芦田爱菜,菜籽,飞鸟,飞鸟鸣鸾,飛鳥メイラン,Flyer Angel">
        <meta name="description" content="小飞鸟日语学习监督部,爱菜小部官方网站，作为一名菜籽，为了表达对芦田爱菜的喜爱而创立的，致力于包括但不限于芦田爱菜相关的字幕制作和资源整理的社团。">
        <meta name="author" content="Flyer Angel">
        <link rel="stylesheet" type="text/css" href="./css/style.css">
    </head>
    <body>
        <h1>小飞鸟日语学习监督部默写材料生成器v0.0.2</h1>
        <p>&copy;小飞鸟&nbsp;2017-09-18</p>
        <hr>
        <?php
//        设置时区
        ini_set('date.timezone', 'Asia/Shanghai');
        if (!empty($_REQUEST['50_tone']) && !empty($_REQUEST['word']) && !empty($_REQUEST['grammar'])) {
            echo "<p>以下是本程序生成的今天的默写内容,点击下面的三个按钮即可分条复制：</p><hr>";
            echo '<button type="button" id="copy_1" data-clipboard-target="#c1">复制第1条</button>&nbsp;';
            echo '<button type="button" id="copy_2" data-clipboard-target="#c2">复制第2条</button>&nbsp;';
            echo '<button type="button" id="copy_3" data-clipboard-target="#c3">复制第3条</button><br><br>';
            //处理单词语法的数据
//五十音
            $fifty_tone = trim($_REQUEST['50_tone']);

//单词
            $word_list = trim($_REQUEST['word']);
            $word_arr = explode("\r\n", $word_list);

//语法
            $grammar_list = trim($_REQUEST['grammar']);
            $grammar_arr = explode("\r\n", $grammar_list);

//表达方式
            $expression_list = trim($_REQUEST['expression']);
            $expression_arr = explode("\r\n", $expression_list);

//课文
            $text_list = empty($_REQUEST['text']) ? "" : trim($_REQUEST['text']);
            $text_arr = explode("\r\n", $text_list);
            $str = "<span id='c1'>皆さん、こんばんは、飛鳥メイランです。<br>童鞋们，晚上好，我是小飞鸟。<br>我们的目标是互相学习、互相监督、共同进步。<br>" . date('Y-m-d') . "</span><br><br><span id='c2'>------我是传说中滴分割线------</span><br><br><span id='c3'>今天的默写内容如下，请大家拿出纸和笔，默写完拍照发上来，小飞鸟会帮大家检查的。<br><br>";

            $str0 = "-----我是传说中滴分割线-----<br>";
//$str.=$str0;
            $hang_duan = empty($_REQUEST['hang_duan']) ? "行" : $_REQUEST['hang_duan'];
            $str1 = "1.请默写" . $fifty_tone . $hang_duan . "所有假名的平假名和片假名<br><br>";
            $str.=$str1;

            $str2 = "2.请默写下面的单词或短语<br><br>";
            $str.=$str2;
//单词随机排序
            shuffle($word_arr);

            foreach ($word_arr as $key => $value) {
                $str.=$value . "<br>";
            }
            $str3 = "<br>3.请翻译下面的句子或对话<br><br>";
//            $str3 = "<br>3.请写出下列数字对应的日语<br><br>";
//数组随机排序
            shuffle($grammar_arr);
            $str.=$str3;

            foreach ($grammar_arr as $key => $value) {
                if ($key != count($grammar_arr)) {
                    $str.=$value . "<br>";
                } else {
                    $str.=$value;
                }
            }

            if (!empty($_REQUEST['expression'])) {
                if (empty($_REQUEST['expression_additional'])) {
                    $str4 = "<br>4.请翻译下面的表达方式<br><br>";
                } else {
                    $str4 = "<br>4.请翻译下面的表达方式（" . $_REQUEST['expression_additional'] . "）<br><br>";
                }
//数组随机排序
                shuffle($expression_arr);
                $str.=$str4;

                foreach ($expression_arr as $key => $value) {
                    if ($key != count($expression_arr)) {
                        $str.=$value . "<br>";
                    } else {
                        $str.=$value;
                    }
                }
            }


            $str.="</span><br>";
            echo $str;
        } else {
            echo "请填写上面的表单，并点击生成按钮。";
        }
        ?>
        <form name="dictation" id="dictation">
            <p>请输入要默写的内容</p>
            1.五十音<br><input type="text" name="50_tone" id="50_tone"/>
            <select id="hang_duan" name="hang_duan">
                <option value="行">行</option>
                <option value="段">段</option>
            </select>
            <br>
            2.单词<br><textarea name="word" id="word" cols="100" rows="25"></textarea><br>
            3.语法<br><textarea name="grammar" id="grammar" cols="100" rows="25"></textarea><br>
            4.表达方式&nbsp;<input type="text" name="expression_additional" id="expression_additional" placeholder="请填写附加说明"/><br><textarea name="expression" id="expression" cols="100" rows="25"></textarea><br><br>
            5.课文<br><textarea name="text" id="text" cols="100" rows="25"></textarea><br><br>
            <input type="submit" name="submit" id="submit" value="生成"/>
            <input type="reset" name="reset" id="reset" value="清空"/> 
        </form>
        <br>
        <button type="button" id="show">显示表单</button>
        <button type="button" id="hide">隐藏表单</button>
        <br>
        <br>
        <hr>
        <div>&copy;2014-<?php echo date("Y"); ?>&nbsp;MANA-CHANN-BU!!! All Rights Reserved 爱菜小部 版权所有</div>
        <script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://cdn.bootcss.com/clipboard.js/1.7.1/clipboard.min.js"></script>       
        <script>
            //             预处理
            pretreatment();
            //            显示表单
            $('#show').click(function() {
                $('#dictation').show();
            });
            //            隐藏表单
            $('#hide').click(function() {
                $('#dictation').hide();
            });
//          复制1
            new Clipboard('#copy_1').on('success', function(e) {
                alert("第1条复制成功，请按键盘Ctrl+V粘贴到需要粘贴的地方\n\n" + $('#c1').text());
                e.clearSelection();
            });
//          复制2
            new Clipboard('#copy_2').on('success', function(e) {
                alert("第2条复制成功，请按键盘Ctrl+V粘贴到需要粘贴的地方\n\n" + $('#c2').text());
                e.clearSelection();
            });
//          复制3
            new Clipboard('#copy_3').on('success', function(e) {
                alert("第3条复制成功，请按键盘Ctrl+V粘贴到需要粘贴的地方\n\n" + $('#c3').text());
                e.clearSelection();
            });

            //            预处理
            function pretreatment() {
<?php if (!empty($_REQUEST['text']) && !empty($_REQUEST['word']) && !empty($_REQUEST['grammar'])): ?>
                    $('#dictation').hide();
<?php endif; ?>

<?php if (!empty($_REQUEST['50_tone'])): ?>
                    $('#50_tone').val("<?php echo trim($_REQUEST['50_tone']); ?>");
<?php endif; ?>
<?php if (!empty($_REQUEST['word'])): ?>
                    $('#word').val("<?php echo str_replace(array("\r\n", "\r", "\n"), '\r\n', trim($_REQUEST['word'])); ?>");
<?php endif; ?>
<?php if (!empty($_REQUEST['grammar'])): ?>
                    $('#grammar').val("<?php echo str_replace(array("\r\n", "\r", "\n"), '\r\n', trim($_REQUEST['grammar'])); ?>");
<?php endif; ?>
<?php if (!empty($_REQUEST['expression'])): ?>
                    $('#expression').val("<?php echo str_replace(array("\r\n", "\r", "\n"), '\r\n', trim($_REQUEST['expression'])); ?>");
<?php endif; ?>
<?php if (!empty($_REQUEST['expression_additional'])): ?>
                    $('#expression_additional').val("<?php echo trim($_REQUEST['expression_additional']); ?>");
<?php endif; ?>
<?php if (!empty($_REQUEST['text'])): ?>
                    $('#text').val("<?php echo str_replace(array("\r\n", "\r", "\n"), '\r\n', trim($_REQUEST['text'])); ?>");
<?php endif; ?>
                $('#hang_duan').val("<?php echo empty($_REQUEST['hang_duan']) ? "行" : $_REQUEST['hang_duan']; ?>");

            }

            $('#dictation').submit(function() {
                if ($('#50_tone').val() == '' || $('#word').val() == '' || $('#grammar').val() == '') {
                    alert('小飞鸟提醒您，五十音、单词、语法三项都要填写哦~~');
                    return false;
                } else {
                    $('#dictation').hide();
                    return true;
                }
            });
        </script>
    </body>
</html>


