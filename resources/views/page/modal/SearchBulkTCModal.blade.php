<div class="modal fade search-bulk-tc" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
                            <form action="<?= route('prosesUploadSearchBulkTC')?>" method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label text-right">Kolom to Search</label>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="checkbox checkbox-primary checkbox-circle">
                                            <input id="checkbox-20a" type="checkbox" name="kolom[]" value="cardnum">
                                            <label for="checkbox-20a">Card Number</label>
                                        </div>
                                        <div class="checkbox checkbox-primary checkbox-circle">
                                            <input id="checkbox-21a" type="checkbox" name="kolom[]" value="txn_date">
                                            <label for="checkbox-21a">Txn Date</label>
                                        </div>
                                        <div class="checkbox checkbox-success checkbox-circle">
                                            <input id="checkbox-22a" type="checkbox" name="kolom[]" value="proc_date">
                                            <label for="checkbox-22a">Proc Date</label>
                                        </div>
                                        <div class="checkbox checkbox-primary checkbox-circle">
                                            <input id="checkbox-23a" type="checkbox" name="kolom[]" value="amount">
                                            <label for="checkbox-23a">Amount</label>
                                        </div>
                                        <div class="checkbox checkbox-primary checkbox-circle">
                                            <input id="checkbox-24a" type="checkbox" name="kolom[]" value="disc_amount">
                                            <label for="checkbox-24a">Disc Amount</label>
                                        </div>
                                        <div class="checkbox checkbox-success checkbox-circle">
                                            <input id="checkbox-25a" type="checkbox" name="kolom[]" value="auth">
                                            <label for="checkbox-25a">Auth</label>
                                        </div>
                                        <div class="checkbox checkbox-dark checkbox-circle">
                                            <input id="checkbox-26a" type="checkbox" name="kolom[]" value="report_name">
                                            <label for="checkbox-26a">Report Name</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="checkbox checkbox-warning checkbox-circle">
                                            <input id="checkbox-27a" type="checkbox" name="kolom[]" value="rate">
                                            <label for="checkbox-27a">Rate</label>
                                        </div>
                                        <div class="checkbox checkbox-danger checkbox-circle">
                                            <input id="checkbox-28a" type="checkbox" name="kolom[]" value="mid">
                                            <label for="checkbox-28a">MID</label>
                                        </div>
                                        <div class="checkbox checkbox-purple checkbox-circle">
                                            <input id="checkbox-29a" type="checkbox" name="kolom[]" value="namaRek">
                                            <label for="checkbox-29a">Nama Rek</label>
                                        </div>
                                        <div class="checkbox checkbox-purple checkbox-circle">
                                            <input id="checkbox-30a" type="checkbox" name="kolom[]" value="noRek">
                                            <label for="checkbox-30a">No Rek</label>
                                        </div>
                                        <div class="checkbox checkbox-pink checkbox-circle">
                                            <input id="checkbox-31a" type="checkbox" name="kolom[]" value="mname">
                                            <label for="checkbox-31a">Merchant Name</label>
                                        </div>
                                        <div class="checkbox checkbox-dark checkbox-circle">
                                            <input id="checkbox-32a" type="checkbox" name="kolom[]" value="bankName">
                                            <label for="checkbox-32a">Bank Name</label>
                                        </div>
                                        <div class="checkbox checkbox-dark checkbox-circle">
                                            <input id="checkbox-33a" type="checkbox" name="kolom[]" value="report_type">
                                            <label for="checkbox-33a">Report Type</label>
                                        </div>
                                        <div class="checkbox checkbox-dark checkbox-circle">
                                            <input id="checkbox-34a" type="checkbox" name="kolom[]" value="net_amount">
                                            <label for="checkbox-34a">Nett Amount</label>
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