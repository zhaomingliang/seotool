<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    <i class="fa fa-fw fa-link"></i>反向链接 <small>添加</small>
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-Dashboard"></i>  <a href="/Dashboard/index/">仪表板</a>
                    </li>
                    <li>
                        <i class="fa fa-fw fa-link"></i> <a href="/backlinks/index/">反向链接概述</a>
                    </li>
                    <li class="active">
                        <i class="fa fa-plus"></i> 反向链接 添加
                    </li>
                </ol>
            </div>
        </div>
        <!-- /.row -->

        <div class="well">
            <p>这部分允许快速和容易建立反向链接为您的项目。源（Verlinker）显示在您的网站（链接），此外你可以指定链接的类型和源类型和关系。这些数据汇总在仪表板，所以是值得在这里兢兢业业。</p>
        </div>

        <form role="form" id="backlinkAdd">
            <div class="row">
                <div class="col-lg-8">
                    <div class="form-group">
                        <label>链接地址</label>
                        <input name="linkSource" class="form-control">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>链接文字</label>
                        <input name="linkText" class="form-control">
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="form-group">
                        <label>链接目标</label>
                        <input name="linkTo" class="form-control">
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Projektadresse</label>
                                <select name="project" class="form-control">
                                    <?php echo $projectListSelect;?>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Linktyp</label>
                                <select name="linkType" class="form-control">
                                    <?php echo $linkTypes;?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Typ der Quelle</label>
                                <select name="linkSourceType" class="form-control">
                                    <?php echo $linkSourceTypes;?>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Relation</label>
                                <select name="linkRelation" class="form-control">
                                    <?php echo $linkRelations;?>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-lg-5">
                    <div class="form-group">
                        <label>Kommentar zum Backlink</label>
                        <textarea name="linkComment" class="form-control" rows="5"></textarea>
                    </div>
                </div>

            </div>

            <div class="col-lg-12 messageHolder">
                <div id="backlinkAlert" class="alert">
                    <div id="message"></div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 text-right">
                    <button id="backlinkAdd_submit" type="submit" class="btn btn-primary"><i class="fa fa-save"></i><i class="fa fa-spinner fa-spin"></i> Backlink speichern</button>
                </div>
            </div>
        </form>
    </div>
    <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->
