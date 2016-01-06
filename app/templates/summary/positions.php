<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    <i class="fa fa-bar-chart-o"></i> 位置分布
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-Dashboard"></i>  <a href="/Dashboard/index/">Dashboard</a>
                    </li>
                    <li class="active">
                        <i class="fa fa-bar-chart-o"></i>位置分布
                    </li>
                </ol>
            </div>
        </div>
        <!-- /.row -->

        <div class="well">以下是位置分布（项目： <strong><?php echo $projectData['currentProjectURL']?></strong> ）对于今天，昨天，-7天-30天-60天，以及-180天。那些有数据的，所以你可以看到你的排名已经转移随着时间的推移。</div>
        <div class="row">
            <div class="col-lg-12">
                <?php echo $chartDataHTML;?>
            </div>
        </div>
        <!-- /.row -->


    </div>
    <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->
