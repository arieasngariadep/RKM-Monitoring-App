@extends('layout.index')

@section('breadcrumbs')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= route('dashboard') ?>">Dashboard</a></li>
    <li class="breadcrumb-item">QRIS BND013</li>
    <li class="breadcrumb-item active">Download Report</li>
</ol>
@endsection('breadcrumbs')

@section('titleTab', 'QR BND013 | Download Report')
@section('title', 'Download Report')

@section('content')
<div class="row">
    <div class="col-lg-12 col-xl-12">
        <?php if($alert): ?>
        <div class="card m-b-30">
            <div class="card-body">
                <?= $alert ?>
            </div>
        </div>
        <?php endif;?>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="mt-0 header-title">Download</h4>
                <form action="<?= route('downloadReportPage') ?>" method="GET">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right">Txn Date</label>
                                <div class="col-sm-10">
                                    <input autocomplete="off" type="text" id="txn_dte" class="form-control" placeholder="Txn Date Start" name="txn_dte1" value="<?= $txn_dte1 ?>" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right">Report Date</label>
                                <div class="col-sm-10">
                                    <input autocomplete="off" type="text" id="report_dte" class="form-control" placeholder="Report Date Start" name="report_dte1" value="<?= $report_dte1 ?>" />
                                </div><!--end col-->
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right">Jenis Report</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="jenis" required>
                                        <option value="">Please Select Option</option>
                                        <option value="BND013L" <?= ($jenis == 'BND013L' ? 'selected' : '') ?>>BND013L</option>
                                        <option value="BND013QR" <?= ($jenis == 'BND013QR' ? 'selected' : '') ?>>BND013QR</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right">Merch ID</label>
                                <div class="col-sm-10">
                                    <input autocomplete="off" type="text" class="form-control" placeholder="Merch Id" id="merch_id" name="merch_id" value="<?= $merch_id ?>" />
                                </div><!--end col-->
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right">RRN</label>
                                <div class="col-sm-10">
                                    <input autocomplete="off" type="text" class="form-control" placeholder="RRN" id="rrn" name="rrn" value="<?= $rrn ?>" />
                                </div><!--end col-->
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right">Txn Date</label>
                                <div class="col-sm-10">
                                    <input autocomplete="off" type="text" id="txn_dte2" class="form-control" placeholder="Txn Date End" name="txn_dte2" value="<?= $txn_dte2 ?>" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right">Report Date</label>
                                <div class="col-sm-10">
                                    <input autocomplete="off" type="text" id="report_dte2" class="form-control" placeholder="Report Date End" name="report_dte2" value="<?= $report_dte2 ?>" />
                                </div><!--end col-->
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right">Card Number</label>
                                <div class="col-sm-10">
                                    <input autocomplete="off" type="text" class="form-control" placeholder="Card Number" id="card_nbr" name="card_nbr" value="<?= $card_nbr ?>" />
                                </div><!--end col-->
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right">Auth Code</label>
                                <div class="col-sm-10">
                                    <input autocomplete="off" type="text" class="form-control" placeholder="Auth Code" id="auth_cd" name="auth_cd" value="<?= $auth_cd ?>" />
                                </div><!--end col-->
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right">Description</label>
                                <div class="col-sm-10">
                                    <input autocomplete="off" type="text" class="form-control" placeholder="Description" id="description" name="description" value="<?= $description ?>" />
                                </div><!--end col-->
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-3 text-right">
                            <button type="submit" class="btn btn-primary waves-effect waves-light" style="width: 250px">Proses</button>
                        </div>
                </form>

                <?php if($jenis != NULL || $txn_dte1 != NULL || $txn_dte2 != NULL || $report_dte1 != NULL || $report_dte2 != NULL || $merch_id != NULL || $card_nbr != NULL || $auth_cd != NULL || $rrn != NULL || $description != NULL) : ?>

                <?php if(($role == 1 && $kelompok_id == 6) || $role == 7) : ?>
                <form action="<?= route('deleteDataReport') ?>" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <input type="text" class="form-controle" name="jenis" value="<?= $jenis ?>" hidden />
                    <input type="text" class="form-controle" name="txn_dt1e" value="<?= $txn_dte1 ?>" hidden />
                    <input type="text" class="form-controle" name="txn_dte2" value="<?= $txn_dte2 ?>" hidden />
                    <input type="text" class="form-controle" name="report_dte1" value="<?= $report_dte1 ?>" hidden />
                    <input type="text" class="form-controle" name="report_dte2" value="<?= $report_dte2 ?>" hidden />
                    <input type="text" class="form-controle" name="merch_id" value="<?= $merch_id ?>" hidden />
                    <input type="text" class="form-controle" name="card_nbr" value="<?= $card_nbr ?>" hidden />
                    <input type="text" class="form-controle" name="auth_cd" value="<?= $auth_cd ?>" hidden />
                    <input type="text" class="form-controle" name="rrn" value="<?= $rrn ?>" hidden />
                    <input type="text" class="form-controle" name="description" value="<?= $description ?>" hidden />
                    <div class="col-md-4 mb-3 text-right">
                        <input type="submit" class="btn btn-danger waves-effect waves-light" style="width: 250px" name="submit" value="Delete Data">
                    </div>
                </form>
                <?php endif; ?>

                <form action="<?= route('prosesExportReport') ?>" method="POST">
                    @csrf
                    <input type="text" class="form-controle" name="jenis" value="<?= $jenis ?>" hidden />
                    <input type="text" class="form-controle" name="txn_dte1" value="<?= $txn_dte1 ?>" hidden />
                    <input type="text" class="form-controle" name="txn_dte2" value="<?= $txn_dte2 ?>" hidden />
                    <input type="text" class="form-controle" name="report_dte1" value="<?= $report_dte1 ?>" hidden />
                    <input type="text" class="form-controle" name="report_dte2" value="<?= $report_dte2 ?>" hidden />
                    <input type="text" class="form-controle" name="merch_id" value="<?= $merch_id ?>" hidden />
                    <input type="text" class="form-controle" name="card_nbr" value="<?= $card_nbr ?>" hidden />
                    <input type="text" class="form-controle" name="auth_cd" value="<?= $auth_cd ?>" hidden />
                    <input type="text" class="form-controle" name="rrn" value="<?= $rrn ?>" hidden />
                    <input type="text" class="form-controle" name="description" value="<?= $description ?>" hidden />
                    <div class="col-md-4 mb-3 text-right">
                        <input type="submit" class="btn btn-secondary waves-effect waves-light" style="width: 250px" name="submit" value="Download Report">
                    </div>
                </form>
            </div>
                <?php endif; ?>
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->
@endsection('content')
