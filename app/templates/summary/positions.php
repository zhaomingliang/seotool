<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    <i class="fa fa-bar-chart-o"></i> Positionsverteilung
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-dashboard"></i>  <a href="/dashboard/index/">Dashboard</a>
                    </li>
                    <li class="active">
                        <i class="fa fa-bar-chart-o"></i> Positionsverteilung
                    </li>
                </ol>
            </div>
        </div>
        <!-- /.row -->

        <div class="well">Hier siehst du die Positionsverteilung (Project: <strong><?php echo $projectData['currentProjectURL']?></strong> ) für heute, gestern, -7 Tage, -30 Tage, -60 Tage sowie -180 Tage. Sofern Daten verfügbar sind, kannst du so sehen, wie sich deine Rankings über die Zeit verschoben haben.</div>
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
