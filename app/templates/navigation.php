<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="/Dashboard/index/">SEO Tool <strong style="color:#fff">v2</strong></a> 
    </div>
    <!-- Top Menu Items -->
    <ul class="nav navbar-right top-nav">

        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-link"></i> <?php echo $currentProjectNameSet;?> <b class="caret"></b></a>
            <ul class="dropdown-menu scrollable-menu">
                <?php echo $projectList;?>
            </ul>
        </li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> 用户 <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li>
                    <a href="/logout/"><i class="fa fa-fw fa-power-off"></i> 注销</a>
                </li>
            </ul>
        </li>
    </ul>

    <!--侧边栏菜单 -->
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav side-nav">
            <li>
                <a href="/Dashboard/index/"><i class="fa fa-fw fa-Dashboard"></i> Dashboard</a>
            </li>
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#summary"><i class="fa fa-fw fa-bar-chart-o"></i> 摘要 <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="summary" class="collapse">
                    <li>
                        <a href="/summary/ranking/">排行指数</a>
                    </li>
                    <li>
                        <a href="/summary/competition/">竞争指数</a>
                    </li>
                    <li>
                        <a href="/summary/valueindex/">排行价值指数</a>
                    </li>
                    <li>
                        <a href="/summary/positions/">位置分布</a>
                    </li>
                    <li>
                        <a href="/summary/keywords/">加工关键词</a>
                    </li>

                </ul>
            </li>
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#keywords"><i class="fa fa-fw fa-list"></i> 关键词 <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="keywords" class="collapse">
                    <li>
                        <a href="/keywords/index/">调查</a>
                    </li>
                    <li>
                        <a href="/summary/value/">等级值</a>
                    </li>
                    <li>
                        <a href="/keywords/competition/">竞赛</a>
                    </li>
                    <li>
                        <a href="/keywords/chances/">机会关键字</a>
                    </li>
                    <li>
                        <a href="/keywords/export/">出口</a>
                    </li>
                    <li>
                        <a href="/keywords/add/">添加关键字</a>
                    </li>

                </ul>
            </li>
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#projects"><i class="fa fa-fw fa-sitemap"></i> 工程 <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="projects" class="collapse">
                    <li>
                        <a href="/projects/index/">项目概况</a>
                    </li>
                    <li>
                        <a href="/projects/add/">添加项目</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#backlinks"><i class="fa fa-fw fa-link"></i> 反向链接 <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="backlinks" class="collapse">
                    <li>
                        <a href="/backlinks/index/">调查</a>
                    </li>
                    <li>
                        <a href="/backlinks/add/">添加反向链接</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#system"><i class="fa fa-fw fa-wrench"></i> 制 <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="system" class="collapse">
                    <li>
                        <a href="/settings/index/">设置</a>
                    </li>
                    <li>
                        <a href="/system/index/">状态</a>
                    </li>
                    <li>
                        <a href="/system/logging/">记录</a>
                    </li>
                </ul>
            </li>


        </ul>
    </div>
    <!-- /.navbar-collapse -->
</nav>
