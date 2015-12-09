<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    <i class="fa fa-bar-chart-o"></i> Rankingwert
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-dashboard"></i>  <a href="/dashboard/index/">Dashboard</a>
                    </li>
                    <li>
                        <i class="fa fa-list"></i> <a href="/keywords/index/">Keywordübersicht</a>
                    </li>
                    <li class="active">
                        <i class="fa fa-bar-chart-o"></i> Rankingwert
                    </li>
                </ol>
            </div>
        </div>
        <!-- /.row -->

        <div class="well"><strong>Je kleiner, desto besser!</strong>. Die Werte ergeben sich aus dem Produkt aus Position und Traffic für jedes Keyword. Davon wird der Durchschnitt gebildet. Der Rankingwert zieht in den Vergleich noch das Trafficvolumen mit ein. Wurde für ein Keyword kein Ranking gefunden ( = NULL) wird es als sehr schlecht ( = Positon 150) angenommen. Ein konkretes Rechenbeispiel findet sich unten.</div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Wert der Rankings aller Konkurrenten im Vergleich</h3>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped sortable">
                                <thead>
                                    <tr>
                                        <th>Domain</th>
                                        <th>Heute</th>
                                        <th>Gestern</th>
                                        <th>-7 Tage</th>
                                        <th>-30 Tage</th>
                                        <th>-60 Tage</th>
                                        <th>-180 Tage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php echo $valueTable;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <h2>Rechenbeispiel</h2>
                <p>Im Rechenbeispiel unten werden zwei Beispieldomains verglichen. Das Keyword-Set ist identisch.</p>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Beispieldomain 1</h3>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th>Keyword</th>
                                                <th>Traffic</th>
                                                <th>Position</th>
                                                <th>Produkt</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Beispiel KW 1</td>
                                                <td>150</td>
                                                <td>20</td>
                                                <td>3000</td>
                                            </tr>
                                            <tr>
                                                <td>Beispiel KW 2</td>
                                                <td>300</td>
                                                <td>8</td>
                                                <td>2400</td>
                                            </tr>
                                            <tr>
                                                <td>Beispiel KW 3</td>
                                                <td>0</td>
                                                <td>1</td>
                                                <td>0</td>
                                            </tr>
                                            <tr>
                                                <td>Beispiel KW 4</td>
                                                <td>50</td>
                                                <td>NULL (= 150)</td>
                                                <td>7500</td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td><strong>Summe:</strong><br />12900</td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td><strong>Durchschnitt:</strong><br />12900 / Anzahl Keywords<br />= 3225</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Beispieldomain 2</h3>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th>Keyword</th>
                                                <th>Traffic</th>
                                                <th>Position</th>
                                                <th>Produkt</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Beispiel KW 1</td>
                                                <td>150</td>
                                                <td>1</td>
                                                <td>150</td>
                                            </tr>
                                            <tr>
                                                <td>Beispiel KW 2</td>
                                                <td>300</td>
                                                <td>5</td>
                                                <td>1500</td>
                                            </tr>
                                            <tr>
                                                <td>Beispiel KW 3</td>
                                                <td>0</td>
                                                <td>9</td>
                                                <td>0</td>
                                            </tr>
                                            <tr>
                                                <td>Beispiel KW 4</td>
                                                <td>50</td>
                                                <td>20</td>
                                                <td>1000</td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td><strong>Summe:</strong><br />2650</td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td><strong>Durchschnitt:</strong><br />2650/ Anzahl Keywords<br />= 662,5</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <h2>Die Aussage:</h2>
                <p>Zu erkennen ist, dass Projekt 1 beim gleichen Keywordset schlechter als Projekt 2 rankt. Beim letzten Keyword gibt es gar kein Ranking für Projekt 1. Über die Produktbildung und anschließende Berechnung des Durchschnittswerts auf Basis der Anzahl der Keywords im Keywordset lässt sich so ein Wert bestimmen. <strong>Je kleiner dieser ist, desto besser!</strong></p>
                <p>Möglich wäre es an der Stelle noch mit dem Kehrwert zu rechnen, um die Zahlen "lesbarer" zu machen. Könnte man, muss man aber nicht. Die Aussage ist so oder so die gleiche.</p>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->
