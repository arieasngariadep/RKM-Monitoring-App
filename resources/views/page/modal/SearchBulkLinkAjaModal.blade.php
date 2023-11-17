<div class="modal fade search-bulk-linkaja" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myLargeModalLabel">Form Upload Search bulk&nbsp;&nbsp;<span style="color:red;">(Data dalam file Excel)</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <div class="general-label">
                            <form action="<?= route('prosesUploadSearchBulkBnd013L') ?>" method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label text-right">Kolom to Search</label>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="checkbox checkbox-primary checkbox-circle">
                                            <input id="checkbox-1s" type="checkbox" name="kolom[]" value="txn_dte">
                                            <label for="checkbox-1s">Txn Date</label>
                                        </div>
                                        <div class="checkbox checkbox-success checkbox-circle">
                                            <input id="checkbox-2s" type="checkbox" name="kolom[]" value="report_dte">
                                            <label for="checkbox-2s">Report Date</label>
                                        </div>
                                        <div class="checkbox checkbox-warning checkbox-circle">
                                            <input id="checkbox-3s" type="checkbox" name="kolom[]" value="merch_id">
                                            <label for="checkbox-3s">MID</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="checkbox checkbox-danger checkbox-circle">
                                            <input id="checkbox-4s" type="checkbox" name="kolom[]" value="card_nbr">
                                            <label for="checkbox-4s">Card Number</label>
                                        </div>
                                        <div class="checkbox checkbox-purple checkbox-circle">
                                            <input id="checkbox-5s" type="checkbox" name="kolom[]" value="auth_cd">
                                            <label for="checkbox-5s">Atuh Code</label>
                                        </div>
                                        <div class="checkbox checkbox-dark checkbox-circle">
                                            <input id="checkbox-7s" type="checkbox" name="kolom[]" value="description">
                                            <label for="checkbox-7s">Description</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <input type="file" id="input-file-now" class="dropify" name="file_import" required />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 text-center">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div> 
                            </form>           
                        </div>
                    </div><!--end card-body-->
                </div><!--end card-->
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->