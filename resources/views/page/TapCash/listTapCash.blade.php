@extends('layout.index')

@section('breadcrumbs')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= route('dashboard') ?>">Dashboard</a></li>
    <li class="breadcrumb-item active">List BND Reject</li>
</ol>
@endsection('breadcrumbs')

@section('titleTab', 'List BND Reject')
@section('title', 'List BND Reject')

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
    <div class="col-lg-12 col-sm-12">
        <div class="card">
            <div class="card-body">
                <p class="text-muted mb-3">List BND Reject</p> 
                <form action="<?= route('getListTapCash') ?>" method="GET">
                    <div class="form-material">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input autocomplete="off" type="text" id="txn_date" class="form-control" placeholder="Txn Date" name="txn_date" value="<?= $txn_date ?>" />
                                </div>
                            </div><!--end col-->
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <input autocomplete="off" type="text" id="proc_date" class="form-control" placeholder="Start Proc Date" name="start_proc_date" value="<?= $start_proc_date ?>" />
                                    </div>
                                </div><!--end col-->
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <input autocomplete="off" type="text" id="proc_date" class="form-control" placeholder="End Proc Date" name="end_proc_date" value="<?= $end_proc_date ?>" />
                                    </div>
                                </div><!--end col-->
                            <div class="col-md-3"> 
                                <input autocomplete="off" type="text" class="form-control" placeholder="MID" id="mid" name="mid" value="<?= $mid ?>" />
                            </div>
                            <div class="col-md-3"> 
                                <input autocomplete="off" type="text" class="form-control" placeholder="Card Number" id="cardnum" name="cardnum" value="<?= $cardnum ?>" />
                            </div>
                        </div><!--end row-->
                        <div class="row">
                            <div class="col-md-3"> 
                                <input autocomplete="off" type="text" class="form-control" placeholder="Auth" id="auth" name="auth" value="<?= $auth ?>" />
                            </div>
                            <div class="col-md-3"> 
                                <input autocomplete="off" type="text" class="form-control" placeholder="Amount" id="amount" name="amount" value="<?= $amount ?>" />
                            </div>
                            <div class="col-md-3"> 
                                <input autocomplete="off" type="text" class="form-control" placeholder="Nama Report" id="report_name" name="report_name" value="<?= $report_name ?>" />
                            </div>
                            <div class="col-md-3"> 
                                <button type="submit" class="btn btn-primary" style="width: 270px; height: 38px;"><i class="dripicons-search"></i> Cari</button>
                            </div>
                        </div><!--end row-->
                    </div>
                </form>
            </div>

            <div class="row mb-4">
                <div class="col-md-4 text-right">
                    <a type="button" class="btn btn-success btn-square btn-outline-dashed waves-effect waves-light" href="../Excel/format_searchbulk_TC.xlsx"><i class="dripicons-cloud-download mr-2"></i>&nbsp;Download Format</a>
                </div>
                <div class="col-md-2 text-center">
                    <button class="btn btn-dark" style="width: 200px; height: 38px;" href="#" data-toggle="modal" data-animation="bounce" data-target=".search-bulk-tc"><i class="dripicons-search"></i>&nbsp;&nbsp;Search Bulk</button>
                </div>
                <?php if($txn_date != NULL || $start_proc_date != NULL && $end_proc_date || $mid != NULL || $cardnum != NULL || $auth != NULL || $amount != NULL || $report_name != NULL) : ?>
                <div class="col-md-2 text-left">
                    <form class="form-inline" action="<?=route('prosesExportReportSearchTC')?>" method="POST">
                        @csrf
                        <input type="text" class="form-controle" name="txn_date" value="<?= $txn_date ?>" hidden />
                        <input type="text" class="form-controle" name="start_proc_date" value="<?= $start_proc_date ?>" hidden />
                        <input type="text" class="form-controle" name="end_proc_date" value="<?= $end_proc_date ?>" hidden />
                        <input type="text" class="form-controle" name="mid" value="<?= $mid ?>" hidden />
                        <input type="text" class="form-controle" name="cardnum" value="<?= $cardnum ?>" hidden />
                        <input type="text" class="form-controle" name="auth" value="<?= $auth ?>" hidden />
                        <input type="text" class="form-controle" name="amount" value="<?= $amount ?>" hidden />
                        <input type="text" class="form-controle" name="report_name" value="<?= $report_name ?>" hidden />
                        <div class="col-md-4 mb-3 text-right">
                            <input type="submit" class="btn btn-secondary waves-effect waves-light" style="width: 200px" name="submit" value="Download Report">
                        </div>
                    </form>
                </div>
                @if(Session::get('kelompok_id') == 6 || Session::get('role_id') == 7)
                <div class="col-md-4 text-left">
                    <form action="<?=route('prosesDeleteTC')?>" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <input type="text" class="form-controle" name="txn_date" value="<?= $txn_date ?>" hidden />
                        <input type="text" class="form-controle" name="start_proc_date" value="<?= $start_proc_date ?>" hidden />
                        <input type="text" class="form-controle" name="end_proc_date" value="<?= $end_proc_date ?>" hidden />
                        <input type="text" class="form-controle" name="mid" value="<?= $mid ?>" hidden />
                        <input type="text" class="form-controle" name="cardnum" value="<?= $cardnum ?>" hidden />
                        <input type="text" class="form-controle" name="auth" value="<?= $auth ?>" hidden />
                        <input type="text" class="form-controle" name="amount" value="<?= $amount ?>" hidden />
                        <input type="text" class="form-controle" name="report_name" value="<?= $report_name ?>" hidden />
                        <div class="col-md-4 text-right">
                            <button type="submit" class="btn btn-danger" style="width: 180px; height: 38px;">
                                <i class="dripicons-trash"></i>&nbsp;&nbsp;Delete Data
                            </button>
                        </div>
                    </form>
                </div>
                @endif;
                <?php endif; ?>
            </div>

            <hr class="mt-1 mb-1">

            <div class="card-body table-responsive">
                <table class="table table-bordered mb-0 table-centered">
                    <thead>
                        <tr>
                            <th>MID</th>
                            <th>NAMA MERCHANT</th>
                            <th>NAMA BANK</th>
                            <th>NO REK</th>
                            <th>NAMA REK</th>
                            <th>0O-BATCH</th>
                            <th>TXN DATE</th>
                            <th>AUTH</th>
                            <th>CARD NUMBER</th>
                            <th>AMOUNT</th>
                            <th>RATE</th>
                            <th>DISC. AMOUNT</th>
                            <th>NET AMOUNT</th>
                            <th>PROC DATE</th>
                            <th>NAMA REPORT</th>
                            <th>JENIS REPORT</th>
                        </tr>
                    </thead>
                    @if (is_array($listTC) || is_object($listTC))
                    <tbody>
                        @if(count($listTC) > 0)
                        @foreach($listTC as $val)
                        <tr>
                            <td>{{ $val->mid }}</td>
                            <td>{{ $val->mname }}</td>
                            <td>{{ $val->bankName }}</td>
                            <td>{{ $val->noRek }}</td>
                            <td>{{ $val->namaRek }}</td>
                            <td>{{ $val->oo_batch }}</td>
                            <td>{{ $val->txn_date }}</td>
                            <td>{{ $val->auth }}</td>
                            <td>{{ $val->cardnum }}</td>
                            <td>{{ $val->amount }}</td>
                            <td>{{ $val->rate }}</td>
                            <td>{{ $val->disc_amount }}</td>
                            <td>{{ $val->net_amount }}</td>
                            <td>{{ $val->proc_date }}</td>
                            <td>{{ $val->report_name }}</td>
                            <td>{{ $val->report_type }}</td>
                        </tr>
                        @endforeach
                        @else
                            <tr><td colspan="16" class="text-center ">No Result Found</td></tr>
                        @endif
                    </tbody>
                    @endif
                </table>

                <br><br>
                
                @if(isset($listTC))
                <div class="row">
                    <div class="col-md-5">
                        @if(count($listTC) > 0)
                        <div class="pull-left">
                            Showing {{ $listTC->firstItem() }} to {{ $listTC->lastItem() }} of {{ number_format($listTC->total()) }} entries
                        </div>
                        @else
                        <div class="pull-left">
                            Showing 0 to 0 of {{ $listTC->total() }} entries
                        </div>
                        @endif
                    </div>
                    <div class="col-md-7">
                        <div class="pull-right">
                            {{ $listTC->links('layout.pagination') }}
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div><!--end row-->
@endsection('content')
