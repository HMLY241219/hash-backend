<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge,chrome=1">
    <title>{$site_name}</title>
    <link href="{__LAYUI__}/css/layui.css" rel="stylesheet">
    <link href="{__LAYADMIN__}/src/css/admin.css" rel="stylesheet">
    <style>
        .layadmin-pagetabs .layui-tab-title li:after,
        .layadmin-pagetabs .layui-tab-title li.layui-this:after,
        .layui-nav-tree .layui-this, .layui-nav-tree .layui-this > a,
        .layui-nav-tree .layui-nav-child dd.layui-this,
        .layui-nav-tree .layui-nav-child dd.layui-this a,
        .layui-nav-tree .layui-nav-bar {background-color: #009688 !important;}

        .layadmin-pagetabs .layui-tab-title li:hover,
        .layadmin-pagetabs .layui-tab-title li.layui-this {color: #009688 !important;}

        .layui-layout-admin .layui-logo {background-color: #20222A !important;}

        .layui-badge-dot {
            position: absolute;
            top: 5px;
            right: 5px;
            background-color: #FF5722;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            color: white;
            text-align: center;
            line-height: 12px;
            font-size: 10px;
        }

        .message-list {
            list-style: none; /* 移除默认的列表样式 */
            padding: 0; /* 移除默认的内边距 */
            margin: 0; /* 移除默认的外边距 */
            background-color: #f4f4f4; /* 设置背景色 */
            border-radius: 5px; /* 设置边框圆角 */
            overflow-y: auto; /* 如果内容过多，允许垂直滚动 */
            max-height: 300px; /* 设置列表的最大高度 */
        }

        .message-list li {
            padding: 10px; /* 设置内边距 */
            border-bottom: 1px solid #ddd; /* 设置底部边框 */
        }

        .message-list li:last-child {
            border-bottom: none; /* 移除最后一个列表项的底部边框 */
        }
    </style>
</head>
<body class="layui-layout-body">
<div id="LAY_app">
    <div class="layui-layout layui-layout-admin">
        <div class="layui-header">
            <!-- 头部区域 -->
            <ul class="layui-nav layui-layout-left">
                <li class="layui-nav-item layadmin-flexible" lay-unselect>
                    <a href="javascript:;" layadmin-event="flexible" title="侧边伸缩">
                        <i class="layui-icon layui-icon-shrink-right" id="LAY_app_flexible"></i>
                    </a>
                </li>
                <li class="layui-nav-item" lay-unselect>
                    <a href="javascript:;" layadmin-event="refresh" title="刷新">
                        <i class="layui-icon layui-icon-refresh-3"></i>
                    </a>
                </li>
            </ul>
            <ul class="layui-nav layui-layout-right" lay-filter="layadmin-layout-right">
                <li class="layui-nav-item layui-hide-xs" lay-unselect>
                    <a href="javascript:;" layadmin-event="note">
                        <i class="layui-icon layui-icon-note"></i>
                    </a>
                </li>

                <li class="layui-nav-item layui-hide-xs" lay-unselect>
                    <a href="javascript:;" layadmin-event="fullscreen">
                        <i class="layui-icon layui-icon-screen-full"></i>
                    </a>
                </li>

                {if condition ="($_admin.type == 0)"}
                <li class="layui-nav-item layui-hide-xs" lay-unselect>
                    <a href="javascript:;" layadmin-event="">
                    <span class="layui-badge-dot" id="message-count">0</span>
                    </a>
                </li>
                {/if}

                <li class="layui-nav-item" lay-unselect>
                    <a href="javascript:;">
                        <cite>{$_admin.real_name} [{$role_name}]</cite>
                    </a>
                    <dl class="layui-nav-child">
                        <dd><a lay-href="{:url('setting.systemAdmin/admin_info')}">个人资料</a></dd>
                        <dd><a href="{:url('auth/logout')}">退出系统</a></dd>
                    </dl>
                </li>

                <li class="layui-nav-item layui-hide-xs" lay-unselect>
                    <a href="javascript:;"><i class="layui-icon layui-icon-more-vertical"></i></a>
                </li>
                <li class="layui-nav-item layui-show-xs-inline-block layui-hide-sm" lay-unselect>
                    <a href="javascript:;" layadmin-event="more"><i class="layui-icon layui-icon-more-vertical"></i></a>
                </li>
            </ul>
        </div>

        <!-- 侧边菜单 -->
        <div class="layui-side layui-side-menu">
            <div class="layui-side-scroll">
                <div class="layui-logo">
                    <span>769GAME</span>
                </div>

                <ul class="layui-nav layui-nav-tree" lay-shrink="all" id="LAY-system-side-menu" lay-filter="layadmin-system-side-menu">
                    <li data-name="home" class="layui-nav-item layui-nav-itemed">
                        <a lay-href="{:url('index/main')}" lay-tips="仪表盘" lay-direction="2">
                            <i class="layui-icon layui-icon-console"></i>
                            <cite>仪表盘</cite>
                        </a>
                    </li>

                    {volist name="menu_list" id="vo"}
                    <li data-name="{$vo.controller}" class="layui-nav-item">
                        <a href="{$vo.url}" lay-tips="{$vo.menu_name}" lay-direction="2">
                            <i class="layui-icon layui-icon-{$vo.icon}"></i>
                            <cite>{$vo.menu_name}</cite>
                        </a>
                        <dl class="layui-nav-child">
                            {volist name="vo.child" id="v1"}
                            <dd>
                                <a {$v1.child?'href':'lay-href'}="{$v1.url}" title="{$v1.controller}">{$v1.menu_name}</a>
                                {if($v1.child)}
                                <dl class="layui-nav-child">
                                    {volist name="v1.child" id="v2"}
                                    <dd><a lay-href="{$v2.url}" title="{$v2.controller}">{$v2.menu_name}</a></dd>
                                    {/volist}
                                </dl>
                                {/if}
                            </dd>
                            {/volist}
                        </dl>
                    </li>
                    {/volist}

                </ul>
            </div>
        </div>

        <!-- 页面标签 -->
        <div class="layadmin-pagetabs" id="LAY_app_tabs">
            <div class="layui-icon layadmin-tabs-control layui-icon-prev" layadmin-event="leftPage"></div>
            <div class="layui-icon layadmin-tabs-control layui-icon-next" layadmin-event="rightPage"></div>
            <div class="layui-icon layadmin-tabs-control layui-icon-down">
                <ul class="layui-nav layadmin-tabs-select" lay-filter="layadmin-pagetabs-nav">
                    <li class="layui-nav-item" lay-unselect>
                        <a href="javascript:;"></a>
                        <dl class="layui-nav-child layui-anim-fadein">
                            <dd layadmin-event="closeThisTabs"><a href="javascript:;">关闭当前标签页</a></dd>
                            <dd layadmin-event="closeOtherTabs"><a href="javascript:;">关闭其它标签页</a></dd>
                            <dd layadmin-event="closeAllTabs"><a href="javascript:;">关闭全部标签页</a></dd>
                        </dl>
                    </li>
                </ul>
            </div>
            <div class="layui-tab" lay-unauto lay-allowClose="true" lay-filter="layadmin-layout-tabs">
                <ul class="layui-tab-title" id="LAY_app_tabsheader">
                    <li lay-id="{:url('index/main')}" lay-attr="" class="layui-this"> <i class="layui-icon layui-icon-console"></i> </li>
                </ul>
            </div>
        </div>


        <!-- 主体内容 -->
        <div class="layui-body" id="LAY_app_body">
            <div class="layadmin-tabsbody-item layui-show">
                <iframe src="{:url('Index/main')}" name="iframe_crmeb_main" frameborder="0" class="J_iframe layadmin-iframe" data-id="{:Url('Index/main')}" seamless></iframe>
            </div>
        </div>

        <!-- 辅助元素，一般用于移动设备下遮罩 -->
        <div class="layadmin-body-shade" layadmin-event="shade"></div>
    </div>
</div>
<script src="{__LAYUI__}/layui.js"></script>
<script>
    layui.use('all', function () {
        var $ = layui.jquery
            ,element = layui.element
            ,setter = layui.setter
            ,view = layui.view
            ,device = layui.device()

            ,$win = $(window), $body = $('body')
            ,container = $('#LAY_app')

            ,SHOW = 'layui-show', HIDE = 'layui-hide', THIS = 'layui-this', DISABLED = 'layui-disabled', TEMP = 'template'
            ,APP_BODY = '#LAY_app_body', APP_FLEXIBLE = 'LAY_app_flexible'
            ,FILTER_TAB_TBAS = 'layadmin-layout-tabs'
            ,APP_SPREAD_SM = 'layadmin-side-spread-sm', TABS_BODY = 'layadmin-tabsbody-item'
            ,ICON_SHRINK = 'layui-icon-shrink-right', ICON_SPREAD = 'layui-icon-spread-left'
            ,SIDE_SHRINK = 'layadmin-side-shrink', SIDE_MENU = 'LAY-system-side-menu'

            //通用方法
            ,admin = {
                v: '1.9.0'
                ,mode: 'spa'

                //xss 转义
                ,escape: function(html){
                    return String(html || '').replace(/&(?!#?[a-zA-Z0-9]+;)/g, '&amp;')
                        .replace(/</g, '&lt;').replace(/>/g, '&gt;')
                        .replace(/'/g, '&#39;').replace(/"/g, '&quot;');
                }

                //事件
                ,on: function(events, callback){
                    return layui.onevent.call(this, 'admin', events, callback);
                }

                //弹出面板
                ,popup: function(options){
                    var success = options.success,skin = options.skin;

                    delete options.success;
                    delete options.skin;

                    return layer.open($.extend({
                        type: 1
                        ,title: '提示'
                        ,content: ''
                        ,id: 'LAY-system-view-popup'
                        ,skin: 'layui-layer-admin' + (skin ? ' ' + skin : '')
                        ,shadeClose: true
                        ,closeBtn: false
                        ,success: function(layero, index){
                            var elemClose = $('<i class="layui-icon" close>&#x1006;</i>');
                            layero.append(elemClose);
                            elemClose.on('click', function(){
                                layer.close(index);
                            });
                            typeof success === 'function' && success.apply(this, arguments);
                        }
                    }, options))
                }

                //右侧面板
                ,popupRight: function(options){
                    //layer.close(admin.popup.index);
                    return admin.popup.index = layer.open($.extend({
                        type: 1
                        ,id: 'LAY_adminPopupR'
                        ,anim: -1
                        ,title: false
                        ,closeBtn: false
                        ,offset: 'r'
                        ,shade: 0.1
                        ,shadeClose: true
                        ,skin: 'layui-anim layui-anim-rl layui-layer-adminRight'
                        ,area: '300px'
                    }, options));
                }

                //屏幕类型
                ,screen: function(){
                    var width = $win.width();
                    if(width > 1200){
                        return 3; //大屏幕
                    } else if(width > 992){
                        return 2; //中屏幕
                    } else if(width > 768){
                        return 1; //小屏幕
                    } else {
                        return 0; //超小屏幕
                    }
                }

                //侧边伸缩
                ,sideFlexible: function(status){
                    var app = container
                        ,iconElem =  $('#'+ APP_FLEXIBLE)
                        ,screen = admin.screen();

                    //设置状态，PC：默认展开、移动：默认收缩
                    if(status === 'spread'){
                        //切换到展开状态的 icon，箭头：←
                        iconElem.removeClass(ICON_SPREAD).addClass(ICON_SHRINK);

                        //移动：从左到右位移；PC：清除多余选择器恢复默认
                        if(screen < 2){
                            app.addClass(APP_SPREAD_SM);
                        } else {
                            app.removeClass(APP_SPREAD_SM);
                        }

                        app.removeClass(SIDE_SHRINK)
                    } else {
                        //切换到搜索状态的 icon，箭头：→
                        iconElem.removeClass(ICON_SHRINK).addClass(ICON_SPREAD);

                        //移动：清除多余选择器恢复默认；PC：从右往左收缩
                        if(screen < 2){
                            app.removeClass(SIDE_SHRINK);
                        } else {
                            app.addClass(SIDE_SHRINK);
                        }

                        app.removeClass(APP_SPREAD_SM)
                    }

                    layui.event.call(this, 'admin', 'side({*})', {
                        status: status
                    });
                }

                //重置主体区域表格尺寸
                ,resizeTable: function(delay){
                    var that = this, runResizeTable = function(){
                        that.tabsBody(admin.tabsPage.index).find('.layui-table-view').each(function(){
                            var tableID = $(this).attr('lay-id');
                            layui.table.resize(tableID);
                        });
                    };
                    if(!layui.table) return;
                    delay ? setTimeout(runResizeTable, delay) : runResizeTable();
                }

                //记录最近一次点击的页面标签数据
                ,tabsPage: {}

                //获取标签页的头元素
                ,tabsHeader: function(index){
                    return $('#LAY_app_tabsheader').children('li').eq(index || 0);
                }

                //获取页面标签主体元素
                ,tabsBody: function(index){
                    return $(APP_BODY).find('.'+ TABS_BODY).eq(index || 0);
                }

                //切换页面标签主体
                ,tabsBodyChange: function(index){
                    admin.tabsHeader(index).attr('lay-attr', layui.router().href);
                    admin.tabsBody(index).addClass(SHOW).siblings().removeClass(SHOW);
                    events.rollPage('auto', index);
                }

                //resize事件管理
                ,resize: function(fn){
                    var router = layui.router()
                        ,key = router.path.join('-');

                    if(admin.resizeFn[key]){
                        $win.off('resize', admin.resizeFn[key]);
                        delete admin.resizeFn[key];
                    }

                    if(fn === 'off') return; //如果是清除 resize 事件，则终止往下执行

                    fn(), admin.resizeFn[key] = fn;
                    $win.on('resize', admin.resizeFn[key]);
                }
                ,resizeFn: {}
                ,runResize: function(){
                    var router = layui.router()
                        ,key = router.path.join('-');
                    admin.resizeFn[key] && admin.resizeFn[key]();
                }
                ,delResize: function(){
                    this.resize('off');
                }

                //关闭当前 pageTabs
                ,closeThisTabs: function(){
                    if(!admin.tabsPage.index) return;
                    $(TABS_HEADER).eq(admin.tabsPage.index).find('.layui-tab-close').trigger('click');
                }

                //全屏
                ,fullScreen: function(){
                    var ele = document.documentElement
                        ,reqFullScreen = ele.requestFullScreen || ele.webkitRequestFullScreen
                        || ele.mozRequestFullScreen || ele.msRequestFullscreen;
                    if(typeof reqFullScreen !== 'undefined' && reqFullScreen) {
                        reqFullScreen.call(ele);
                    };
                }

                //退出全屏
                ,exitScreen: function(){
                    var ele = document.documentElement
                    if (document.exitFullscreen) {
                        document.exitFullscreen();
                    } else if (document.mozCancelFullScreen) {
                        document.mozCancelFullScreen();
                    } else if (document.webkitCancelFullScreen) {
                        document.webkitCancelFullScreen();
                    } else if (document.msExitFullscreen) {
                        document.msExitFullscreen();
                    }
                }

                //纠正单页路由格式
                ,correctRouter: function(href){
                    //if(!/^\//.test(href)) href = '/' + href;

                    //纠正首尾
                    return href.replace(/^(\/+)/, '/')
                        .replace(new RegExp('\/index$'), '/'); //过滤路由最后的默认视图文件名（如：index）
                }

                //……
            };

        //事件
        var events = admin.events = {
            //伸缩
            flexible: function(othis){
                var iconElem = othis.find('#'+ APP_FLEXIBLE)
                    ,isSpread = iconElem.hasClass(ICON_SPREAD);
                admin.sideFlexible(isSpread ? 'spread' : null); //控制伸缩
                admin.resizeTable(350);
            }

            //刷新
            ,refresh: function(){
                const src = $("#LAY_app_body .layui-show iframe").attr("src");
                $("#LAY_app_body .layui-show iframe").attr("src", src);
            }

            //便签
            ,note: function(othis){
                var mobile = admin.screen() < 2
                    ,note = layui.data('layuiAdmin').note;

                events.note.index = admin.popup({
                    title: '便签'
                    ,shade: 0
                    ,offset: [
                        '41px'
                        ,(mobile ? null : (othis.offset().left - 250) + 'px')
                    ]
                    ,anim: -1
                    ,id: 'LAY_adminNote'
                    ,skin: 'layadmin-note layui-anim layui-anim-upbit'
                    ,content: '<textarea placeholder="内容"></textarea>'
                    ,resize: false
                    ,success: function(layero, index){
                        var textarea = layero.find('textarea')
                            ,value = note === undefined ? '便签中的内容会存储在本地，这样即便你关掉了浏览器，在下次打开时，依然会读取到上一次的记录。是个非常小巧实用的本地备忘录' : note;

                        textarea.val(value).focus().on('keyup', function(){
                            layui.data('layuiAdmin', {
                                key: 'note'
                                ,value: this.value
                            });
                        });
                    }
                })
            }

            //全屏
            ,fullscreen: function(othis){
                var SCREEN_FULL = 'layui-icon-screen-full'
                    ,SCREEN_REST = 'layui-icon-screen-restore'
                    ,iconElem = othis.children("i");

                if(iconElem.hasClass(SCREEN_FULL)){
                    admin.fullScreen();
                    iconElem.addClass(SCREEN_REST).removeClass(SCREEN_FULL);
                } else {
                    admin.exitScreen();
                    iconElem.addClass(SCREEN_FULL).removeClass(SCREEN_REST);
                }
            }

            //返回上一页
            ,back: function(){
                history.back();
            }

            //左右滚动页面标签
            ,rollPage: function(type, index){
                var tabsHeader = $('#LAY_app_tabsheader')
                    ,liItem = tabsHeader.children('li')
                    ,scrollWidth = tabsHeader.prop('scrollWidth')
                    ,outerWidth = tabsHeader.outerWidth()
                    ,tabsLeft = parseFloat(tabsHeader.css('left'));

                //右左往右
                if(type === 'left'){
                    if(!tabsLeft && tabsLeft <=0) return;

                    //当前的left减去可视宽度，用于与上一轮的页标比较
                    var  prefLeft = -tabsLeft - outerWidth;

                    liItem.each(function(index, item){
                        var li = $(item)
                            ,left = li.position().left;

                        if(left >= prefLeft){
                            tabsHeader.css('left', -left);
                            return false;
                        }
                    });
                } else if(type === 'auto'){ //自动滚动
                    (function(){
                        var thisLi = liItem.eq(index), thisLeft;

                        if(!thisLi[0]) return;
                        thisLeft = thisLi.position().left;

                        //当目标标签在可视区域左侧时
                        if(thisLeft < -tabsLeft){
                            return tabsHeader.css('left', -thisLeft);
                        }

                        //当目标标签在可视区域右侧时
                        if(thisLeft + thisLi.outerWidth() >= outerWidth - tabsLeft){
                            var subLeft = thisLeft + thisLi.outerWidth() - (outerWidth - tabsLeft);
                            liItem.each(function(i, item){
                                var li = $(item)
                                    ,left = li.position().left;

                                //从当前可视区域的最左第二个节点遍历，如果减去最左节点的差 > 目标在右侧不可见的宽度，则将该节点放置可视区域最左
                                if(left + tabsLeft > 0){
                                    if(left - tabsLeft > subLeft){
                                        tabsHeader.css('left', -left);
                                        return false;
                                    }
                                }
                            });
                        }
                    }());
                } else {
                    //默认向左滚动
                    liItem.each(function(i, item){
                        var li = $(item)
                            ,left = li.position().left;

                        if(left + li.outerWidth() >= outerWidth - tabsLeft){
                            tabsHeader.css('left', -left);
                            return false;
                        }
                    });
                }
            }

            //向右滚动页面标签
            ,leftPage: function(){
                events.rollPage('left');
            }

            //向左滚动页面标签
            ,rightPage: function(){
                events.rollPage();
            }

            //关闭当前标签页
            ,closeThisTabs: function(){
                admin.closeThisTabs();
            }

            //关闭其它标签页
            ,closeOtherTabs: function(type){
                var TABS_REMOVE = 'LAY-system-pagetabs-remove';
                if(type === 'all'){
                    $(TABS_HEADER+ ':gt(0)').remove();
                    $(APP_BODY).find('.'+ TABS_BODY+ ':gt(0)').remove();
                } else {
                    $(TABS_HEADER).each(function(index, item){
                        if(index && index != admin.tabsPage.index){
                            $(item).addClass(TABS_REMOVE);
                            admin.tabsBody(index).addClass(TABS_REMOVE);
                        }
                    });
                    $('.'+ TABS_REMOVE).remove();
                }
            }

            //关闭全部标签页
            ,closeAllTabs: function(){
                events.closeOtherTabs('all');
                //location.hash = '';
            }

            //遮罩
            ,shade: function(){
                admin.sideFlexible();
            }
        };

        //初始
        !function(){
            //禁止水平滚动
            $body.addClass('layui-layout-body');

            //移动端强制不开启页面标签功能
            if(admin.screen() < 1){
                delete setter.pageTabs;
            }
        }();

        //admin.prevRouter = {}; //上一个路由

        // hash 改变侧边状态
        admin.on('hash(side)', function(router){
            var path = router.path, getData = function(item){
                    return {
                        list: item.children('.layui-nav-child')
                        ,name: item.data('name')
                        ,jump: item.data('jump')
                    }
                }
                ,sideMenu = $('#'+ SIDE_MENU)
                ,SIDE_NAV_ITEMD = 'layui-nav-itemed'

                //捕获对应菜单
                ,matchMenu = function(list){
                    var pathURL = admin.correctRouter(path.join('/'));
                    list.each(function(index1, item1){
                        var othis1 = $(item1)
                            ,data1 = getData(othis1)
                            ,listChildren1 = data1.list.children('dd')
                            ,matched1 = path[0] == data1.name || (index1 === 0 && !path[0])
                            || (data1.jump && pathURL == admin.correctRouter(data1.jump));

                        listChildren1.each(function(index2, item2){
                            var othis2 = $(item2)
                                ,data2 = getData(othis2)
                                ,listChildren2 = data2.list.children('dd')
                                ,matched2 = (path[0] == data1.name && path[1] == data2.name)
                                || (data2.jump && pathURL == admin.correctRouter(data2.jump));

                            listChildren2.each(function(index3, item3){
                                var othis3 = $(item3)
                                    ,data3 = getData(othis3)
                                    ,matched3 = (path[0] ==  data1.name && path[1] ==  data2.name && path[2] == data3.name)
                                    || (data3.jump && pathURL == admin.correctRouter(data3.jump))

                                if(matched3){
                                    var selected = data3.list[0] ? SIDE_NAV_ITEMD : THIS;
                                    othis3.addClass(selected).siblings().removeClass(selected); //标记选择器
                                    return false;
                                }

                            });

                            if(matched2){
                                var selected = data2.list[0] ? SIDE_NAV_ITEMD : THIS;
                                othis2.addClass(selected).siblings().removeClass(selected); //标记选择器
                                return false
                            }

                        });

                        if(matched1){
                            var selected = data1.list[0] ? SIDE_NAV_ITEMD : THIS;
                            othis1.addClass(selected).siblings().removeClass(selected); //标记选择器
                            return false;
                        }

                    });
                }

            //重置状态
            sideMenu.find('.'+ THIS).removeClass(THIS);

            //移动端点击菜单时自动收缩
            if(admin.screen() < 2) admin.sideFlexible();

            //开始捕获
            matchMenu(sideMenu.children('li'));
        });

        //侧边导航点击事件
        element.on('nav(layadmin-system-side-menu)', function(elem){
            if(elem.siblings('.layui-nav-child')[0] && container.hasClass(SIDE_SHRINK)){
                admin.sideFlexible('spread');
                layer.close(elem.data('index'));
            };
            admin.tabsPage.type = 'nav';
        });

        //选项卡的更多操作
        element.on('nav(layadmin-pagetabs-nav)', function(elem){
            var dd = elem.parent();
            dd.removeClass(THIS);
            dd.parent().removeClass(SHOW);
        });

        //同步路由
        var setThisRouter = function(othis){
            var layid = othis.attr('lay-id')
                ,attr = othis.attr('lay-attr')
                ,index = othis.index();

            admin.tabsBodyChange(index);
        },TABS_HEADER = '#LAY_app_tabsheader>li';

        //页面标签点击
        $body.on('click', TABS_HEADER, function(){
            var othis = $(this),index = othis.index();

            admin.tabsPage.type = 'tab';
            admin.tabsPage.index = index;

            //如果是iframe类型的标签页
            if(othis.attr('lay-attr') === 'iframe'){
                return admin.tabsBodyChange(index);
            };


            setThisRouter(othis); //同步路由
            admin.runResize(); //执行resize事件，如果存在的话
            admin.resizeTable(); //重置当前主体区域的表格尺寸
        });

        // tabspage 删除
        element.on('tabDelete(layadmin-layout-tabs)', function(obj){
            var othis = $(TABS_HEADER+ '.layui-this');

            obj.index && admin.tabsBody(obj.index).remove();
            setThisRouter(othis);

            //移除resize事件
            admin.delResize();
        });

        //页面跳转
        $body.on('click', '*[lay-href]', function(){
            var othis = $(this), title = othis.text(), href = othis.attr('lay-href');

            admin.tabsPage.elem = othis;
            //admin.prevRouter[router.path[0]] = router.href; //记录上一次各菜单的路由信息

            //遍历页签选项卡
            var matchTo,tabs = $('#LAY_app_tabsheader>li');

            tabs.each(function(index){
                var li = $(this),layid = li.attr('lay-id');

                if(layid === href){
                    matchTo = true;
                    admin.tabsPage.index = index;
                }
            });

            //如果未在选项卡中匹配到，则追加选项卡
            if(!matchTo){
                $(APP_BODY).append(`<div class="layadmin-tabsbody-item layui-show"><iframe src="${href}" frameborder="0" class="J_iframe layadmin-iframe"></iframe></div>`);

                admin.tabsPage.index = tabs.length;
                element.tabAdd(FILTER_TAB_TBAS, {
                    title: `<span>${title}</span>`
                    ,id: href
                    ,attr: ''
                });
            }

            this.container = admin.tabsBody(admin.tabsPage.index);

            //定位当前tabs
            element.tabChange(FILTER_TAB_TBAS, href);
            admin.tabsBodyChange(admin.tabsPage.index);

        });

        //点击事件
        $body.on('click', '*[layadmin-event]', function(){
            var othis = $(this),attrEvent = othis.attr('layadmin-event');
            events[attrEvent] && events[attrEvent].call(this, othis);
        });

        //tips
        $body.on('mouseenter', '*[lay-tips]', function(){
            var othis = $(this);

            if(othis.parent().hasClass('layui-nav-item') && !container.hasClass(SIDE_SHRINK)) return;

            var tips = othis.attr('lay-tips')
                ,offset = othis.attr('lay-offset')
                ,direction = othis.attr('lay-direction')
                ,index = layer.tips(tips, this, {
                tips: direction || 1
                ,time: -1
                ,success: function(layero, index){
                    if(offset){
                        layero.css('margin-left', offset + 'px');
                    }
                }
            });
            othis.data('index', index);
        }).on('mouseleave', '*[lay-tips]', function(){
            layer.close($(this).data('index'));
        });

        //窗口resize事件
        var resizeSystem = layui.data.resizeSystem = function(){
            //layer.close(events.note.index);
            layer.closeAll('tips');

            if(!resizeSystem.lock){
                setTimeout(function(){
                    admin.sideFlexible(admin.screen() < 2 ? '' : 'spread');
                    delete resizeSystem.lock;
                }, 100);
            }

            resizeSystem.lock = true;
        }
        $win.on('resize', layui.data.resizeSystem);

    })

    //消息
    layui.use(['jquery', 'layer'], function(){
        var $ = layui.$, layer = layui.layer;

        var message_list = [];
        // 假设获取消息数的API
        $.get("{:url('messageGet')}", function(data){
            if(data.count > 0){
                $('#message-count').text(data.count).show();
                blinkNumber('#message-count');
                message_list = data.list;
            }
        });

        // 点击红点时弹出消息列表
        $('#message-count').on('click', function(){
            var messageListHtml = '<ul class="message-list">'; // 开始创建消息列表的HTML内容
            $.each(message_list, function(index, message){
                messageListHtml += '<li>' + '<a lay-href="' + message.url + '">' + message.text + '</a><span style="color: red"> ' + message.count +'</span></li>';
            });
            messageListHtml += '</ul>'; // 结束消息列表的HTML内容

            var index = layer.open({
                type: 1,
                title: '告警',
                content: messageListHtml,
                area: ['300px', 'auto']
            });

            $('.message-list').off('click').on('click', function(){
                layer.close(index); // 关闭当前弹窗
            });
        });
    });

    //闪烁
    function blinkNumber(element) {
        $(element).fadeOut(500, function() {
            $(this).fadeIn(500, function() {
                blinkNumber(this);
            });
        });
    }
</script>
<script src="{__FRAME_PATH}js/jquery.min.js"></script>
<script src="{__FRAME_PATH}js/bootstrap.min.js"></script>
<script src="{__STATIC_PATH}plug/helper.js"></script>
<script src="{__FRAME_PATH}js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="{__FRAME_PATH}js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="{__FRAME_PATH}js/plugins/layer/layer.min.js"></script>
<script src="{__FRAME_PATH}js/hplus.min.js"></script>
<script src="{__FRAME_PATH}js/contabs.min.js"></script>
<script src="{__FRAME_PATH}js/plugins/pace/pace.min.js"></script>

{include file="public/style"}
<script src="{__FRAME_PATH}js/index.js"></script>
</body>
</html>


