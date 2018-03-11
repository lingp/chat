<!doctype html>
<html>
<head>
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <style>
        .msg-list, .user-list
        {
            height: 20em;
            max-height: 30em;
            overflow: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <nav class="navbar navbar-default" role="navigation">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">聊天室练习</a>
                </div>
                <div>
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="#">基于workerman</a></li>
                        <li><a href="#">基于php原生socket</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="row">
            {{-- 群聊 start --}}
            <div class="col-sm-7 col-xs-7">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">群聊</h3>
                    </div>
                    <div class="panel-body">
                        <div class="msg-list">

                        </div>
                    </div>
                </div>
            </div>
            {{-- 群聊 end --}}
            {{-- 在线人数面板 start --}}
            <div class="col-sm-4 col-xs-4">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">在线人数</h3>
                    </div>
                    <div class="panel-body">
                        <div class="user-list">

                        </div>
                    </div>
                </div>
            </div>
            {{-- 在线人数面板 end --}}
        </div>
        <div class="row">
            <div class="col-sm-11 col-xs-11">
                <form role="form">
                    <div class="form-group">
                        <textarea class="form-control" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">发送<utton>
                </form>
            </div>

        </div>
    </div>


</body>
<script src="http://apps.bdimg.com/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script>
    function WebSocketTest()
    {
        if('WebSocket' in window)
        {
            alert('你的浏览器支持 WebSocket');
            var ws = new WebSocket('ws://192.168.153.139:8282');
            console.log(ws);
            //建立连接
            ws.onopen = function()
            {

            }

            //接受消息
            ws.onmessage = function()
            {

            }

            //关闭连接
            ws.close = function()
            {

            }

        }else
        {
            alert('您的浏览器不支持 WebSocket');
        }
    }
    
    function send() {
        
    }
    
    function confirm() {
        
    }
</script>
</html>