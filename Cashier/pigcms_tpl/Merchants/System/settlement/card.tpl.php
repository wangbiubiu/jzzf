<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商家证件</title>
    <style type="text/css">
        img{max-width: 700px;}
        li,ul{list-style: none;padding: 0;}
        li{padding-bottom: 10px;margin-bottom: 10px;border-top: 1px solid #777;}
        a{text-decoration: none;}
    </style>
    <script type="text/javascript">
        function preview(oper) {
            if (oper < 10){
                bdhtml=window.document.body.innerHTML;//获取当前页的html代码
                sprnstr="<!--startprint"+oper+"-->";//设置打印开始区域
                eprnstr="<!--endprint"+oper+"-->";//设置打印结束区域
                prnhtml=bdhtml.substring(bdhtml.indexOf(sprnstr)+18); //从开始代码向后取html

                prnhtml=prnhtml.substring(0,prnhtml.indexOf(eprnstr));//从结束代码向前取html
                window.document.body.innerHTML=prnhtml;
                window.print();
                window.document.body.innerHTML=bdhtml;
            }
            else{
                window.print();
            }
        }
    </script>
</head>
<body>
<div style="text-align: center;line-height: 100px;font-size: 20px;color:#f10;width: 700px;margin:auto;">
    商家信息<a href="javascript:preview(1);;" style="color:#f60;font-size: 14px;margin-left: 20px;"> 【打印】</a>
</div>
<!--startprint1-->
<ul style="width: 100%;margin: auto;text-align: center;">
    <li>
        <div style="line-height: 30px;">
            身份证正面：
        </div>
        <div>
            <img src="{pg:$bank.imgzheng}"/>
        </div>
    </li>
    <li>
        <div style="line-height: 30px;">
            身份证反面：
        </div>
        <div>
            <img src="{pg:$bank.imgfan}"/>
        </div>
    </li>
    <li>
        <div style="line-height: 30px;">
            手持身份证：
        </div>
        <div>
            <img src="{pg:$bank.shouimg}"/>
        </div>
    </li>
    <li>
        <div style="line-height: 30px;">
            银行卡正面：
        </div>
        <div>
            <img src="{pg:$bank.bankzheng}"/>
        </div>
    </li>
    <li>
        <div style="line-height: 30px;">
            银行卡反面：
        </div>
        <div>
            <img src="{pg:$bank.bankfan}"/>
        </div>
    </li>
</ul>
<!--endprint1-->
</body>
</html>