<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    <i class="fa fa-sitemap"></i> 项目概况
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-Dashboard"></i>  <a href="/Dashboard/index/">Dashboard</a>
                    </li>
                    <li class="active">
                        <i class="fa fa-sitemap"></i> 项目概况
                    </li>
                </ol>
            </div>
        </div>
        <!-- /.row -->

        <div class="well">
            <p>在项目概述你可以看到所有你已经创建的项目。在同一行中，也显示了你竞争对手的规模。此外，你会发现，将被跟踪这个Keywpord包括关键字的总数。而竞争对手。在右边，你可以编辑或完全删除相应的项目。通过从将被彻底删除的项目删除所有数据 - 这也是真正的竞争，而关键字数据</p>
        </div>
        
        <div class="col-lg-3">
            <div class="form-group input-group">
                <span class="input-group-btn"><button class="btn btn-default" type="button"><i class="fa fa-search"></i></button></span>
                <input id="search" placeholder="Projekt suchen..." type="text" class="form-control">
            </div>
        </div>
        <div class="col-lg-push-6 col-lg-3 text-right">
            <a type="button" class="btn btn-primary" href="/projects/add/"> <i class="fa fa-plus"></i>添加项目</a>
        </div>
        
        <div class="col-lg-12">
            <div class="table-responsive">
                <table id="searchableTable" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>主要项目</th>
                            <th>竞赛</th>
                            <th>关键字</th>
                            <th>添加</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php echo $projectsTable; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.row -->
        
        <div class="col-lg-12 text-right">
                <a type="button" class="btn btn-primary" href="/projects/add/"> <i class="fa fa-plus"></i> 添加项目</a>
        </div>
        <!-- /.row -->
        
    </div>
    <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->
