@extends('layout.index')

@section('breadcrumbs')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= route('dashboard') ?>">Dashboard</a></li>
    <li class="breadcrumb-item active">List BND01QA</li>
</ol>
@endsection('breadcrumbs')

@section('titleTab', 'QA BND01 | List Data BND01QA')
@section('title', 'List Data BND01QA')

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
                <p class="text-muted mb-3">List Data BND01QA</p> 
                <form action="<?= route('getListBND01QA') ?>" method="GET">
                    <div class="form-material">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input autocomplete="off" type="text" id="txn_dte" class="form-control" placeholder="Txn Date" name="txn_dte" value="<?= $txn_dte ?>" />
                                </div>
                            </div><!--end col-->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input autocomplete="off" type="text" id="report_dte" class="form-control" placeholder="Report Date" name="report_dte" value="<?= $report_dte ?>" />
                                </div>
                            </div><!--end col-->
                            <div class="col-md-3"> 
                                <input autocomplete="off" type="text" class="form-control" placeholder="Merch Id" id="merch_id" name="merch_id" value="<?= $merch_id ?>" />
                            </div>
                            <div class="col-md-3"> 
                                <input autocomplete="off" type="text" class="form-control" placeholder="Card Number" id="card_nbr" name="card_nbr" value="<?= $card_nbr ?>" />
                            </div>
                        </div><!--end row-->
                        <div class="row">
                            <div class="col-md-3"> 
                                <input autocomplete="off" type="text" class="form-control" placeholder="RRN" id="rrn" name="rrn" value="<?= $rrn ?>" />
                            </div>
                            <div class="col-md-3"> 
                                <input autocomplete="off" type="text" class="form-control" placeholder="Description" id="description" name="description" value="<?= $description ?>" />
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
                    <a type="button" class="btn btn-success btn-square btn-outline-dashed waves-effect waves-light" href="../Excel/format_searchbulk_BND01QA.xlsx"><i class="dripicons-cloud-download mr-2"></i>&nbsp;Download Format</a>
                </div>
                <div class="col-md-2 text-center">
                    <button class="btn btn-dark" style="width: 200px; height: 38px;" href="#" data-toggle="modal" data-animation="bounce" data-target=".search-bulk-qa"><i class="dripicons-search"></i>&nbsp;&nbsp;Search Bulk</button>
                </div>
                <?php if($txn_dte != NULL || $report_dte != NULL || $merch_id != NULL || $card_nbr != NULL || $rrn != NULL || $description != NULL) : ?>
                <div class="col-md-2 text-left">
                    <form class="form-inline" action="<?= route('prosesExportReportSearchBND01QA') ?>" method="POST">
                        @csrf
                        <input type="text" class="form-controle" name="txn_dte" value="<?= $txn_dte ?>" hidden />
                        <input type="text" class="form-controle" name="report_dte" value="<?= $report_dte ?>" hidden />
                        <input type="text" class="form-controle" name="merch_id" value="<?= $merch_id ?>" hidden />
                        <input type="text" class="form-controle" name="card_nbr" value="<?= $card_nbr ?>" hidden />
                        <input type="text" class="form-controle" name="rrn" value="<?= $rrn ?>" hidden />
                        <input type="text" class="form-controle" name="description" value="<?= $description ?>" hidden />
                        <div class="col-md-4 mb-3 text-right">
                            <input type="submit" class="btn btn-secondary waves-effect waves-light" style="width: 200px" name="submit" value="Download Report">
                        </div>
                    </form>
                </div>
                @if(Session::get('kelompok_id') == 6 || Session::get('role_id') == 7)
                <div class="col-md-4 text-left">
                    <form action="{{ route('prosesDeleteBnd01QA') }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <input type="text" class="form-controle" name="txn_dte" value="<?= $txn_dte ?>" hidden />
                        <input type="text" class="form-controle" name="report_dte" value="<?= $report_dte ?>" hidden />
                        <input type="text" class="form-controle" name="merch_id" value="<?= $merch_id ?>" hidden />
                        <input type="text" class="form-controle" name="card_nbr" value="<?= $card_nbr ?>" hidden />
                        <input type="text" class="form-controle" name="rrn" value="<?= $rrn ?>" hidden />
                        <input type="text" class="form-controle" name="description" value="<?= $description ?>" hidden />
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
                            <th>REPORT-DTE</th>
                            <th>MERCH-ID</th>
                            <th>CARD-NBR</th>
                            <th>AMOUNT</th>
                            <th>TXN-DTE</th>
                            <th>RRN</th>
                            <th>DESCRIPTION</th>
                        </tr>
                    </thead>
                    @if(isset($listBnd))
                    <tbody>
                        @if(count($listBnd) > 0)
                            @foreach($listBnd as $bnd)
                                <tr>
                                    <td>{{ $bnd->report_dte }}</td>
                                    <td>{{ $bnd->merch_id }}</td>
                                    <td>{{ $bnd->card_nbr }}</td>
                                    <td>{{ $bnd->amount }}</td>
                                    <td>{{ $bnd->txn_dte }}</td>
                                    <td>{{ $bnd->rrn }}</td>
                                    <td>{{ $bnd->description }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr><td colspan="10" class="text-center ">No Result Found</td></tr>
                        @endif
                    </tbody>
                    @endif
                </table>

                <br><br>
                
                @if(isset($listBnd))
                <div class="row">
                    <div class="col-md-5">
                        @if(count($listBnd) > 0)
                        <div class="pull-left">
                            Showing {{ $listBnd->firstItem() }} to {{ $listBnd->lastItem() }} of {{ number_format($listBnd->total()) }} entries
                        </div>
                        @else
                        <div class="pull-left">
                            Showing 0 to 0 of {{ $listBnd->total() }} entries
                        </div>
                        @endif
                    </div>
                    <div class="col-md-7">
                        <div class="pull-right">
                            {{ $listBnd->links('layout.pagination') }}
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div><!--end row-->
@endsection('content')
