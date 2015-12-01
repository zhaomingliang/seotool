
</div>
<!-- /#wrapper -->

<!-- jQuery -->
<script src="/js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="/js/bootstrap.min.js"></script>

<!-- Custom JS -->
<script src="/js/script.js"></script>

<!-- Morris Charts JavaScript -->
<script src="/js/raphael.min.js"></script>
<script src="/js/morris.min.js"></script>

<script src="/js/sorttable.js"></script>
<script>
<?php echo $rankingLineJSData;?>
</script>

<!-- Modal -->
<div class="modal fade" id="keywordModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-close red"></i></span></button>
                <h4 class="modal-title" id="myModalLabel">Keyword "<span id="modal-kw"></span>" bearbeiten</h4>

            </div>
            <div class="modal-body">
                <form id="keywordsUpdate" role="form">
                    <input type="hidden" name="kid" value="">
                    <div class="form-group">
                        <label>Keyword</label>
                        <input name="kwName" value="" class="form-control">
                        <p class="help-block">Hier korrigierst du den Keywordtext bzw. den Suchbegriff</p>
                    </div>
                    <div class="form-group">
                        <label>Suchvolumen</label>
                        <input name="kwSV" value="" class="form-control">
                        <p class="help-block">Hier kannst du das Suchvolumen des Keywords eintragen</p>
                    </div>
                    <div class="col-lg-12 messageHolder">
                        <div class="alert">
                            <div id="message"></div>
                        </div>
                    </div>
                    <button id="keywordsUpdate_submit" type="submit" class="btn btn-primary"> <i class="fa fa-save"></i><i class="fa fa-spinner fa-spin"></i> Keyword aktualisieren</button>
                </form>
            </div>
        </div>
    </div>
</div>

</body>

</html>