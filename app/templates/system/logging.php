<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    <i class="fa fa-exclamation"></i> Crawler-Log
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-dashboard"></i>  <a href="/dashboard/index/">Dashboard</a>
                    </li>
                    <li class="active">
                        <i class="fa fa-exclamation"></i> Crawler-Log
                    </li>
                </ol>
            </div>
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Meldungen, die der PERL Logger speichert</h3>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Zeit</th>
                                        <th>Nachricht</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php echo $log;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-lg-push-9 col-lg-3 text-right">
                <button id="cleanLog" type="submit" class="btn btn-primary"> <i class="fa fa-close"></i> Log leeren</button>
            </div>
        </div>
        <div class="col-lg-12 messageHolder">
            <div class="alert">
                <div id="message"></div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->
