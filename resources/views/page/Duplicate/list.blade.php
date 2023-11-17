@extends('layout.index')

@section('breadcrumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">List Duplicate</li>
    </ol>
@endsection('breadcrumbs')

@section('titleTab', 'List Duplicate')
@section('title', 'List Duplicate')

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
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <div class="col-md-5 text-left">
                    <form class="form-inline" action="<?= route('prosesExportReportDuplicate') ?>" method="POST">
                        @csrf
                        <div class="col-md-4 mb-3 text-right">
                            <input type="submit" class="btn btn-secondary waves-effect waves-light" style="width: 200px" name="submit" value="Download Report">
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="thead-default">
                            <tr>
                                <th>ORDERID</th>
                                <th>LAST_UPDATED_TIME</th>
                                <th>INITIATION_TIME</th>
                                <th>STATUS</th>
                                <th>REASON_TYPE</th>
                                <th>TRANSACTION_AMOUNT</th>
                                <th>MDR</th>
                                <th>NETT_AMOUNT</th>
                                <th>ORGANIZATION_NAME</th>
                                <th>ORGANIZATION_SHORTCODE</th>
                                <th>PARTNERMERCHANTID</th>
                                <th>MERCHANTTRXID</th>
                            </tr>
                        </thead>
                        @if(isset($duplicate))
                        <tbody>
                            @if(count($duplicate) > 0)
                                @foreach($duplicate as $list)
                                    <tr>
                                        <td>{{ $list->orderId }}</td>
                                        <td>{{ $list->last_updated_time }}</td>
                                        <td>{{ $list->initiation_time }}</td>
                                        <td>{{ $list->status }}</td>
                                        <td>{{ $list->reason_type }}</td>
                                        <td>{{ $list->transaction_amount }}</td>
                                        <td>{{ $list->mdr }}</td>
                                        <td>{{ $list->nett_amount }}</td>
                                        <td>{{ $list->organization_name }}</td>
                                        <td>{{ $list->organization_shortcode }}</td>
                                        <td>{{ $list->partner_merchant_id }}</td>
                                        <td>{{ $list->merchant_trx_id }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr><td colspan="12" class="text-center ">No Result Found</td></tr>
                            @endif
                        </tbody>
                        @endif
                    </table>

                    <br><br>
                
                    @if(isset($duplicate))
                    <div class="row">
                        <div class="col-md-5">
                            @if(count($duplicate) > 0)
                            <div class="pull-left">
                                Showing {{ $duplicate->firstItem() }} to {{ $duplicate->lastItem() }} of {{ number_format($duplicate->total()) }} entries
                            </div>
                            @else
                            <div class="pull-left">
                                Showing 0 to 0 of {{ $duplicate->total() }} entries
                            </div>
                            @endif
                        </div>
                        <div class="col-md-7">
                            <div class="pull-right">
                                {{ $duplicate->links('layout.pagination') }}
                            </div>
                        </div>
                    </div>
                    @endif

                </div>
            </div>
        </div><!--end card-->
    </div><!--end col-->
</div><!--end row-->

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="thead-default">
                            <tr>
                                <th>ORDERID</th>
                                <th>LAST_UPDATED_TIME</th>
                                <th>INITIATION_TIME</th>
                                <th>STATUS</th>
                                <th>REASON_TYPE</th>
                                <th>TRANSACTION_AMOUNT</th>
                                <th>MDR</th>
                                <th>NETT_AMOUNT</th>
                                <th>ORGANIZATION_NAME</th>
                                <th>ORGANIZATION_SHORTCODE</th>
                                <th>PARTNERMERCHANTID</th>
                                <th>MERCHANTTRXID</th>
                            </tr>
                        </thead>
                        @if(isset($linkAja))
                        <tbody>
                            @if(count($linkAja) > 0)
                                @foreach($linkAja as $list)
                                    <tr>
                                        <td>{{ $list->orderId }}</td>
                                        <td>{{ $list->last_updated_time }}</td>
                                        <td>{{ $list->initiation_time }}</td>
                                        <td>{{ $list->status }}</td>
                                        <td>{{ $list->reason_type }}</td>
                                        <td>{{ $list->transaction_amount }}</td>
                                        <td>{{ $list->mdr }}</td>
                                        <td>{{ $list->nett_amount }}</td>
                                        <td>{{ $list->organization_name }}</td>
                                        <td>{{ $list->organization_shortcode }}</td>
                                        <td>{{ $list->partner_merchant_id }}</td>
                                        <td>{{ $list->merchant_trx_id }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr><td colspan="12" class="text-center ">No Result Found</td></tr>
                            @endif
                        </tbody>
                        @endif
                    </table>

                    <br><br>
                
                    @if(isset($linkAja))
                    <div class="row">
                        <div class="col-md-5">
                            @if(count($linkAja) > 0)
                            <div class="pull-left">
                                Showing {{ $linkAja->firstItem() }} to {{ $linkAja->lastItem() }} of {{ number_format($linkAja->total()) }} entries
                            </div>
                            @else
                            <div class="pull-left">
                                Showing 0 to 0 of {{ $linkAja->total() }} entries
                            </div>
                            @endif
                        </div>
                        <div class="col-md-7">
                            <div class="pull-right">
                                {{ $linkAja->links('layout.pagination') }}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div><!--end card-->
    </div><!--end col-->
</div><!--end row-->
@endsection('content')
