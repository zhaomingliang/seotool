<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    <i class="fa fa-sitemap"></i> 编辑数据
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-Dashboard"></i>  <a href="/Dashboard/index/">仪表板</a>
                    </li>
                    <li>
                        <i class="fa fa-sitemap"></i> <a href="/projects/index/">项目概况</a>
                    </li>
                    <li class="active">
                        <i class="fa fa-edit"></i> 编辑数据
                    </li>
                </ol>
            </div>
        </div>
        <!-- /.row -->

        <div class="well">
            <p>编辑功能保持相当简单 - 你可以改变互联网地址或增加竞争对手，编辑或删除。整个项目可在项目概况被删除。所有数据含关键字和跟踪将会丢失。</p>
        </div>

        <form role="form" id="projectUpdate">

            <div class="col-lg-6">
                <label>Hauptprojekt</label>
                <div class="form-group input-group">
                    
                    <?php echo $mainProjectArea; ?>
                </div>
            </div>

            <div class="col-lg-6">
                <label>Konkurrenzprojekte</label>
                <?php echo $competitionArea; ?>
            </div>
            <!-- /.row -->
            <div class="col-lg-12 messageHolder">
                <div class="alert">
                    <div id="message"></div>
                </div>
            </div>
            
            <div class="col-lg-12 text-right">
                <button id="projectUpdate_submit" type="submit" class="btn btn-primary"><i class="fa fa-save"></i><i class="fa fa-spinner fa-spin"></i> 存储数据</button>
            </div>

        </form>
    </div>
    <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->
