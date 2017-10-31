<?php
return array (
		'pay_url' => 'http://zf.szjhzxxkj.com/ownPay/pay',//支付系统网关地址
		'df_url' => 'http://payment.szjhzxxkj.com/payment/api_pay_single',//代付系统网关地址
		'merchantNo' => '500008170689', //商户号
		'backUrl' => 'http://' . $_SERVER['SERVER_NAME'] ."/Cashier/pay/jhz.php",//页面返回URL
		'pageUrl' => 'http://' . $_SERVER['SERVER_NAME'] ."/Cashier/pay/jhz.php",//服务器返回URL
		
		
		'private_key' => '-----BEGIN PRIVATE KEY-----
MIICdwIBADANBgkqhkiG9w0BAQEFAASCAmEwggJdAgEAAoGBAJ2TUM67PRRJPXyi7idveSFot5KcSsqHFsvtfXTgq4W7MY/IeUgdsIGosU+s2iTGXxHbYtjnI6H6HG8Tk9hJs/KF5kMD+V384bnmPi7q/Q5CzkFP0JE7laindmm1DehIkMLAExU+fklylyC+16UCIN4yxk3CtMuv0e0IKicne5S9AgMBAAECgYEAhZ5G9pa1i38zoX2zv0L6j0bx62OW1DhLL2/aY4KkT8lVlJwlo+5xHvGCMZLchDSmp0jGgDE3+QFSnSoXw190M4Oq6VXX9bLCVRSekRQfIzMxCPEQ0FB5PDVZinGaQvOvYbhGru3Bgo1mMZrr+gAidcI1Ns5qj4csginpSZIpqwECQQD/dVLOLNnywyatYRzGpmOdwml+Rsav60fv3bkMTfxCyk7ls6LEhkiCmeFOH9fTeJjzoT0bzzGQFTBXBSQEFi19AkEAnejbKffIWyOs3yOEA0WObZUP/FpJYr0GzvGQtRxFhzQ5kDI9+5TSuZUZJT8CQPwSyuhiAo5v5ZyRZcw20ACoQQJBALPXqvYPSVjI3p/M8G9BkHvt9Eq8FQCgSUKq+62X8XIr7yNzNbHZP48COkW/0TfFfRh3eQfs892VrTR2IAbofhkCQE7V5S0jrpyJyBGy+oJjpILjC5MSRFcORirlATjaP4ALu71YyAclOrs6S86DkY1+C6fPsrbSA91feFuZQ7g+y8ECQCA8phM6B0VoRzTueDZdHgZy3039BH0HaUAnrcC+QSok+yFlQwDdU+Eoee6iSssYWe3BnCb5IINiDxAt2yl7a0Q=
-----END PRIVATE KEY-----',
		'public_key' => "-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCL4nMv6qK7Lt1MzfK20LrVd/0g0pXIvV281sT16s4xIWEg/Hfv0su0MHdbTobZfHcziyO/xdmItCzkcJOIIskuC3QukNrWnt7kf1wZ1OmIMWAcS5s9wnMd0QcpDpcyfZfJvlZgFDtgJtApXvCBBVIEX65W1FnmlZ7wccO3Ca+J8QIDAQAB
-----END PUBLIC KEY-----",
);
?>
