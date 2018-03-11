<!doctype html>
<html>
<head>
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <style>
        .msg-list-w, .user-list-w
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
                        <div class="msg-list-w">

                        </div>
                    </div>
                </div>
            </div>
            {{-- 群聊 end --}}
            {{-- 在线人数面板 start --}}
            <div class="col-sm-4 col-xs-4">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">在线用户</h3>
                    </div>
                    <div class="panel-body">
                        <div id="userlist" class="user-list-w">

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
                        <textarea id="dialog" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="form-gourp">
                        <select class="form-control" id="client_list">
                            <option value="0">所有人</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">发送</button>
                </form>
            </div>
        </div>
    </div>
</body>
<script src="http://apps.bdimg.com/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script>
    if(typeof console == "undefined")
    {
        this.console = { log: function (msg) {
            alert(msg)
        }}
    }
    var ws, name, client_list = {}
    function connect()
    {
        ws = new WebSocket("ws://192.168.80.129:8282");
        //链接socket服务器
        ws.open = onopen;
        //接受消息
        ws.onmessage = onmessage;
        //关闭链接
        ws.onclose = function()
        {
            console.log("链接关闭，定时重连")
            connect();
        }
        ws.onerror = function()
        {
            console.log("出现错误")
        }
    }

    // 创建连接
    function onopen()
    {
        if(!name)
        {
            show_prompt();
        }

        var login_data = new Array();
        login_data['type'] = 'login';
        login_data['client_name'] = name.replace(/"/g, '\\"')
        login_data['room_id'] = "{{ $room_id }}"

        login_data = JSON.stringify(login_data);
        ws.send(login_data);
        console.log("websocket握手成功，发送登录数据:" + login_data)
    }

    // 服务端发来消息
    function onmessage(e)
    {
        console.log(e.data)
        var data = JSON.parse(e.data)
        switch (data['type'])
        {
            case 'ping':
                ws.send("{ 'type':'pong' }")
                break;

            case 'login':
                say(data['client_id'], data['client_name'], data['client_name']+" 加入了聊天室", data['time'])

                if(data['client_list'])
                {
                    client_list = data['client_list']
                }else{
                    client_list[data['client_id']] = data['client_name']
                }

                flush_client_list();

                console.log(data['client_name'] + "登录成功")
                break;

            case 'say':
                say(data['from_client_id'], data['from_client_name'], data['content'], data['time'])
                break;

            case 'logout':
                say(data['from_client_id'], data['from_client_name'], data['from_client_name'] + ' 退出了', data['time'])

                delete client_list[data['from_client_id']]

                flush_client_list();
                break;
        }

    }

    // 输入姓名
    function show_prompt()
    {
        name = prompt("输入你的名字", "")
        if(!name || name == "null" )
        {
            name = "游客"
        }
    }

    // 提交对话
    function on_submit()
    {
        var input = $(".dialog")
        var to_client_id = $("#client_list option:selected").val();
        var to_client_name = $("#client_list option:selected").text();
        var post_data = new Array();
        post_data['type'] = 'say'
        post_data['to_client_id'] = to_client_id
        post_data['to_client_name'] = to_client_name
        post_data['content'] = input[0].value.replace(/"/g, '\\"').replace(/\n/g, '\\n').replace(/\r/g, '\\r')
        post_data = JSON.stringify(post_data)

        ws.send(post_data)
        input.val("")
        input.focus();
    }

    // 刷新用户列表框
    function flush_client_list() {
        var userlist_window = $("#userlist");
        var client_list_select = $("#client_list")
        userlist_window.empty()
        client_list_select.empty()

        for (var key in client_list)
        {
            userlist_window.append('<p class="text-center">' + client_listp[key] + '</p>')
            client_list_select.append('<option value="'+ key+'">' + client_list[key] + '</option>');
        }

        $("#client_list").val(client_list_select)
    }

    function say(from_client_id, from_client_name, content, time)
    {

    }





</script>
</html>