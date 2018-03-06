<!doctype html>
<html>
<head>

</head>
<body>
    <header></header>

    <article>
        <section>
            <a href="javascript:WebSocketTest()">运行 WebSocket</a>
        </section>
    </article>

    <footer></footer>
</body>

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
</script>
</html>