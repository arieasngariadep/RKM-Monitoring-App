@extends('layout.index')

@section('breadcrumbs')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= route('dashboard') ?>">Dashboard</a></li>
    <li class="breadcrumb-item">QRIS BND013</li>
    <li class="breadcrumb-item active">List BND013L</li>
</ol>
@endsection('breadcrumbs')

@section('titleTab', 'QR BND013 | List Data BND013L')
@section('title', 'List Data BND013L')

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
                <p class="text-muted mb-3">List Data BND013L</p> 
                <form action="<?= route('getListBND013L') ?>" method="GET">
                    <div class="form-material">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input autocomplete="off" type="text" class="form-control" placeholder="Txn Date" name="txn_dte" value="<?= $txn_dte ?>" />
                                </div>
                            </div><!--end col-->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input autocomplete="off" type="text" class="form-control" placeholder="Report Date" name="report_dte" value="<?= $report_dte ?>" />
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
                                <input autocomplete="off" type="text" class="form-control" placeholder="Auth Code" id="auth_cd" name="auth_cd" value="<?= $auth_cd ?>" />
                            </div>
                            <div class="col-md-3"> 
                                <input autocomplete="off" type="text" class="form-control" placeholder="Description" id="description" name="description" value="<?= $description ?>" />
                            </div>
                            <div class="col-md-3"> 
                                <input autocomplete="off" type="text" class="form-control" placeholder="Amount" id="amount" name="amount" value="<?= $amount ?>" />
                            </div>
                            <div class="col-md-3"> 
                                <button type="submit" class="btn btn-primary" style="width: 270px; height: 38px;"><i class="dripicons-search"></i> Cari</button>
                            </div>
                        </div><!--end row-->
                    </div>
                </form>
            </div>

            <div class="row mb-2">
                <div class="col-md-5 text-right">
                    <a type="button" class="btn btn-success btn-square btn-outline-dashed waves-effect waves-light" href="../public/template/format_searchbulk.xlsx"><i class="dripicons-cloud-download mr-2"></i>&nbsp;Download Format</a>
                </div>
                <div class="col-md-2 text-center">
                    <button class="btn btn-dark" style="width: 200px; height: 38px;" href="#" data-toggle="modal" data-animation="bounce" data-target=".search-bulk-linkaja"><i class="dripicons-search"></i>&nbsp;&nbsp;Search Bulk</button>
                </div>
                <div class="col-md-5 text-left">
                    <form action="<?= route('prosesExportReportSearchBulkBND013L') ?>" method="POST">
                        @csrf
                        <div class="col-md-4 mb-3 text-right">
                            <input type="submit" class="btn btn-secondary waves-effect waves-light" style="width: 200px" name="submit" value="Download Report">
                        </div>
                    </form>
                </div>
            </div>

            <hr class="mt-1 mb-1">

            <div class="card-body table-responsive">
                <table class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>REPORT-DTE</th>
                            <th>ORG</th>
                            <th>MERCH-ID</th>
                            <th>CARD-NBR</th>
                            <th>AMOUNT</th>
                            <th>TC</th>
                            <th>TXN-DTE</th>
                            <th>AUTH-CD</th>
                            <th>DESCRIPTION</th>
                        </tr>
                    </thead>
                    @if(isset($listBnd))
                    <tbody>
                        @if(count($listBnd) > 0)
                            @foreach($listBnd as $bnd)
                                <tr>
                                    <td>{{ $bnd->report_dte }}</td>
                                    <td>{{ $bnd->org }}</td>
                                    <td>{{ $bnd->merch_id }}</td>
                                    <td>{{ $bnd->card_nbr }}</td>
                                    <td>{{ $bnd->amount }}</td>
                                    <td>{{ $bnd->tc }}</td>
                                    <td>{{ $bnd->txn_dte }}</td>
                                    <td>{{ $bnd->auth_cd }}</td>
                                    <td>{{ $bnd->description }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr><td colspan="9" class="text-center ">No Result Found</td></tr>
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
