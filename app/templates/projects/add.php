<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    <i class="fa fa-sitemap"></i> 添加项目
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-Dashboard"></i>  <a href="/Dashboard/index/">Dashboard</a>
                    </li>
                    <li>
                        <i class="fa fa-sitemap"></i> <a href="/projects/index/">Projektübersicht</a>
                    </li>
                    <li class="active">
                        <i class="fa fa-plus"></i> 添加项目
                    </li>
                </ol>
            </div>
        </div>
        <!-- /.row -->

        <div class="well">
            <p>在这里，您可以把您的项目和它的竞争者很容易进入。请确保您所有的项目地址 <strong>以http：//或https ：</strong>难道你忘了，你可以假设的结果将是不正确的。举个例子：你穿了只“ domain.de ” ，并在你的排名前面的“ tolle-domain.de ” ，他们将被识别和使用。你使用，但“ http://domain.de ”不会发生。</p>
        </div>

        <form role="form" id="projectAdd">

            <div class="col-lg-6">
                <label>Hauptprojekt</label>
                <div class="form-group input-group">
                    <span class="input-group-addon"><i class="fa fa-link"></i></span><input name="project" class="form-control" placeholder="URL zu deinem Projekt">
                </div>
            </div>

            <div class="col-lg-6">
                <label>Konkurrenzprojekte</label>
                <div class="form-group input-group">
                    <span class="input-group-addon"><i class="fa fa-link"></i></span><input name="comp1" class="form-control" placeholder="URL zu Konkurrent 1">
                </div>
                <div class="form-group input-group">
                    <span class="input-group-addon"><i class="fa fa-link"></i></span><input name="comp2" class="form-control" placeholder="URL zu Konkurrent 2">
                </div>
                <div class="form-group input-group">
                    <span class="input-group-addon"><i class="fa fa-link"></i></span><input name="comp3" class="form-control" placeholder="URL zu Konkurrent 3">
                </div>
                <div class="form-group input-group">
                    <span class="input-group-addon"><i class="fa fa-link"></i></span><input name="comp4" class="form-control" placeholder="URL zu Konkurrent 4">
                </div>
                <div class="form-group input-group">
                    <span class="input-group-addon"><i class="fa fa-link"></i></span><input name="comp5" class="form-control" placeholder="URL zu Konkurrent 5">
                </div>
            </div>
            <!-- /.row -->
            
            <div class="col-lg-12 messageHolder">
                <div class="alert">
                    <div id="message"></div>
                </div>
            </div>

            <div class="col-lg-12 text-right">
                <button id="projectAdd_submit" type="submit" class="btn btn-primary"><i class="fa fa-save"></i><i class="fa fa-spinner fa-spin"></i> 存储数据</button>
            </div>

        </form>
    </div>
    <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->
