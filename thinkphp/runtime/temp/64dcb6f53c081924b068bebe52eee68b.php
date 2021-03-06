<?php /*a:2:{s:76:"D:\phpstudy_pro\WWW\community\application\admin\view\feedback\feed_list.html";i:1601630625;s:71:"D:\phpstudy_pro\WWW\community\application\admin\view\public\header.html";i:1601212227;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>社区管理平台</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/layuiadmin/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="/layuiadmin/style/admin.css" media="all">
    <link rel="stylesheet" href="/layuiadmin/style/login.css" media="all">
    <script type="text/javascript">
        // if(sessionStorage.getItem("session")=="" ||sessionStorage.getItem("session")==undefined){
        //     location.href = './user/login.html'; //后台主页
        // }
    </script>
    <script>
        /^http(s*):\/\//.test(location.href) || alert('请先部署到 localhost 下再访问');
    </script>
</head>
<body>

  <div class="layui-fluid">
    <div class="layui-card">
      <div class="layui-card-body">
        <script type="text/html" id="barDemo">
          <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
        </script>
        <table class="layui-hide" id="test" lay-filter="test"></table>
        <script type="text/html" id="imgTpl"> 
          <img style="display: inline-block; width: 50%; height: 100%;" src= {{ d.avatar }}>
        </script>
      </div>
    </div>
  </div>

  <script src="/layuiadmin/layui/layui.js"></script>
  <script>
  layui.config({
    base: '../../../layuiadmin/' //静态资源所在路径
  }).extend({
    index: 'lib/index' //主入口模块
  }).use(['index', 'useradmin', 'table'], function(){
    var $ = layui.$
    ,form = layui.form,setter = layui.setter
    ,table = layui.table;


    table.render({
      elem: '#test'
      ,url:'/admin/feedback/getList'
      ,toolbar: '#toolbarDemo' //开启头部工具栏，并为其绑定左侧模板
      ,defaultToolbar: ['filter', 'exports', 'print', { //自定义头部工具栏右侧图标。如无需自定义，去除该参数即可
        title: '提示'
        ,layEvent: 'LAYTABLE_TIPS'
        ,icon: 'layui-icon-tips'
      }],
      limit:'20'
      ,title: '用户数据表'
      ,cols: [[
        {type: 'checkbox', fixed: 'left'}
        ,{field:'Id', title:'ID', width:60, fixed: 'left', unresize: true, sort: true}
        ,{field:'username', title:'用户名', width:80, edit: 'text'}
        ,{field:'content', title:'内容', width:180 }
        ,{field:'images', title:'图片地址', width:150, edit: 'text'}
        ,{field:'create_time', title:'加入时间', width:160}
        ,{title:'操作', toolbar: '#barDemo'}
      ]]
      ,page: true
    });


    //监听行工具事件
    table.on('tool(test)', function(obj){
      var data = obj.data;
      //console.log(obj)
      if(obj.event === 'del'){
        layer.confirm('真的删除行么', function(index){
          $.ajax({
            type: 'get',
            url: setter.api + '/admin/feedback/delete',
            data: data,
            success: function(res) {
              if (res.code == 200) {
                obj.del();
                layer.close(index);
                layer.msg('删除成功', {
                  offset: '15px',
                  icon: 1,
                  time: 1000
                });
              } else {
                layer.msg('修改失败', {
                  offset: '15px',
                  icon: 2
                })
              }
            }
          });

        });
      } else if(obj.event === 'edit'){
        sessionStorage.setItem('userItem',JSON.stringify(obj.data))
        layer.open({
          type: 2,
          area: ['100%', '100%'],
          content: '/admin/feedback/feedEdit' //这里content是一个URL，如果你不想让iframe出现滚动条，你还可以content: ['http://sentsin.com', 'no']
        });
      }
    });


  });
  </script>
</body>
</html>
