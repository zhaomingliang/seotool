<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    <i class="fa fa-list"></i> 添加关键字
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-Dashboard"></i>  <a href="/Dashboard/index/">Dashboard</a>
                    </li>
                    <li>
                        <i class="fa fa-fw fa-list"></i> <a href="/keywords/index/">关键字概述</a>
                    </li>
                    <li class="active">
                        <i class="fa fa-plus"></i> 添加关键字
                    </li>
                </ol>
            </div>
        </div>
        <!-- /.row -->

        <div class="well">
            <p><?php echo $addInformation;?></p>
        </div>

        <form role="form" id="keywordsAdd">

            <input type="hidden" name="currentProjectsParentID" value="<?php echo $projectData['currentProjectParentID'];?>" />
            <div class="form-group">
                <label>Keywords hier zeilenweise eintragen</label>
                <textarea class="form-control" name="keywords" rows="25"></textarea>
            </div>
            <!-- /.row -->

            <div class="col-lg-12 messageHolder">
                <div class="alert">
                    <div id="message"></div>
                </div>
            </div>

            <div class="col-lg-12 text-right">
                <button id="keywordsAdd_submit" type="submit" class="btn btn-primary"><i class="fa fa-save"></i><i class="fa fa-spinner fa-spin"></i> Keywords speichern</button>
            </div>

        </form>
    </div>
    <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->
