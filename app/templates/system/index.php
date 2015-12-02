<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    <i class="fa fa-exclamation"></i> Systemstatus
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-dashboard"></i>  <a href="/dashboard/index/">Dashboard</a>
                    </li>
                    <li class="active">
                        <i class="fa fa-exclamation"></i> Systemstatus
                    </li>
                </ol>
            </div>
        </div>
        <!-- /.row -->

        <?php echo $systemWarning;?>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Informationen zur Keyword-Aktualisierung des Systems</h3>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Aktualisierungszeiten</th>
                                        <th>Anzahl Keywords</th>
                                        <th>Dauer/KW (min.)</th>
                                        <th>Dauer/KW (max.)</th>
                                        <th>Gesamtdauer (min.)</th>
                                        <th>Gesamtdauer (max.)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php echo $updateTimeInfo;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->


    </div>
    <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->
