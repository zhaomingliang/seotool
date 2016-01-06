<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    <i class="fa fa-bar-chart-o"></i> 摘要 <small>竞赛 <?php echo $projectData['currentProjectURL'];?></small>
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-Dashboard"></i>  <a href="/Dashboard/index/">Dashboard</a>
                    </li>
                    <li class="active">
                        <i class="fa fa-fw fa-bar-chart-o"></i> Vergleich mit der Konkurrenz
                    </li>
                </ol>
            </div>
        </div>
        <!-- /.row -->

        <div class="well">
            <p>竞争指数是类似于正常排名指数。对于每个竞争者的平均仓位计算和绘制。静置竞争对手，没有数据可用，它不能被视为在图表中！越多的排名和竞争对手都存在，慢可以创建图表是 - 这是尤其如此，在很长的时间间隔！</p>
        </div>

        <div class="row">
            <div class="col-lg-3">
                <div class="form-group">
                    <select id="dateSelecter" class="form-control">
                        <?php echo $datePicker;?>
                    </select>
                </div>        </div>
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> <?php echo $projectData['currentProjectURL'];?> </h3>
                    </div>
                    <div class="panel-body">
                        <div id="summary-competition"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->

        <div class="alert alert-success">
            <i class="fa fa-question-circle"></i> <strong>图中的两条红线</strong> 标记位置1和25中的平均排名之间的面积要小，这也意味着关键字具有很好的名额是很高的。排名指数的计算是非常简单：如果两个关键字跟踪，其中包括在5位，另一种是30位，总和为35。这是通过关键词的数量除以 - 以便创建索引。因此，在本情况下，将17.5！
        </div>

        <div class="alert alert-danger">
            <i class="fa fa-info-circle"></i> <strong>计算能力或完成日期：</strong> 越大选定的时间间隔，该时间越长，从数据库和再循环汇总数据。添加到图的这一渲染 - 在某些情况下，它可能会因此发生，你的服务器失败，出现“第XX秒的最长执行时间超出”。遗憾的是这里唯一的解决办法是定制服务器和PHP设置。这种效果也加剧了更高的关键字的数目和竞争者的数量。
        </div>
    </div>
    <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->
