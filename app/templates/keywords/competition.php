<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    <i class="fa fa-list"></i> 竞争对手的排名
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-Dashboard"></i>  <a href="/Dashboard/index/">仪表盘</a>
                    </li>
                    <li class="active">
                        <i class="fa fa-fw fa-list"></i> 比赛综述
                    </li>
                </ol>
            </div>
        </div>
        <!-- /.row -->


        <div class="well">
            <p>Für den <strong><?php echo $selectedDate;?> </strong> siehst du hier <strong>dein Hauptprojekt</strong> verglichen mit der Konkurrenz. Siehst du noch keine Daten, so bedeutet es, dass der Keyword Crawler dieses Projekt heute noch nicht verarbeitet hat. Hab also etwas Geduld. Beobachtest du nur eine kleine Anzahl an Keywords, lohnt es sich das Tracking über Nacht zu aktivieren - siehe hierzu <a href="/settings/cronjob/">Cronjob-Einstellungen</a>!</p>
        </div>

        <div class="alert alert-danger">
            <strong>Wichtig: </strong> 如果许多关键字必须在这里下载可能需要几秒钟，并产生一种“延迟”的出现。
        </div>

        <div class="col-lg-3">
            <div class="form-group input-group">
                <span class="input-group-btn"><button class="btn btn-default" type="button"><i class="fa fa-search"></i></button></span>
                <input id="search" placeholder="Keyword/URL-Suche..." type="text" class="form-control">
            </div>
        </div>
        <div class="col-lg-3">
            <?php echo $selectedDateHTML;?>
        </div>
        <div class="col-lg-push-3 col-lg-3 text-right">
            <a type="button" class="btn btn-primary" href="/keywords/add/"> <i class="fa fa-plus"></i> 添加关键字</a>
        </div>

        <div class="col-lg-12">
            <div class="table-responsive">
                <table id="searchableTable" class="table table-bordered table-hover sortable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Keyword</th>
                            <th>SV</th>
                            <?php echo $tblHeaderCompetiton;?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php echo $rankingTable;?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.row -->

        <div class="col-lg-12 text-right">
            <a type="button" class="btn btn-primary" href="/keywords/add/"> <i class="fa fa-plus"></i> 添加关键字</a>
        </div>
        <!-- /.row -->

    </div>
    <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->
