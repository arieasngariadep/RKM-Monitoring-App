@extends('layout.index')

@section('breadcrumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Dashboard</li>
    </ol>
@endsection('breadcrumbs')

@section('titleTab', 'Dashboard')
@section('title', 'Dashboard')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <?php if($alert): ?>
            <div class="card">
                <div class="card-body">
                    <?= $alert ?>
                </div>
            </div>
        <?php endif;?>
    </div>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="card card-eco">
            <div class="card-body">
                <h4 class="title-text mt-0">LinkAja | Hari ini ( <?= $now ?> )</h4>
                <div class="d-flex justify-content-between">
                    <h3 class="font-weight-bold"><?= number_format($linkAja->jumlah_item, 0, '', '.') ?></h3>
                    <i class="dripicons-user-group card-eco-icon text-pink align-self-center"></i>
                </div>
                <p class="mb-0 text-muted text-truncate" style="font-size: 22px"><span class="text-success">Rp. <?= number_format($linkAja->jumlah_amount, 0, '', '.') ?></span></p>
            </div><!--end card-body-->
        </div><!--end card-->
    </div><!--end col-->
    <div class="col-lg-6">
        <div class="card card-eco">
            <div class="card-body">
                <h4 class="title-text mt-0">QRIS | Hari ini ( <?= $now ?> )</h4>
                <div class="d-flex justify-content-between">
                    <h3 class="font-weight-bold"><?= number_format($qris->jumlah_item, 0, '', '.') ?></h3>
                    <i class="dripicons-wallet card-eco-icon text-success  align-self-center"></i>
                </div>
                <p class="mb-0 text-muted text-truncate" style="font-size: 22px"><span class="text-success">Rp. <?= number_format($qris->jumlah_amount, 0, '', '.') ?></span></p>
            </div><!--end card-body-->
        </div><!--end card-->
    </div><!--end col-->
</div><!--end row-->

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="title-text mt-0">Cek Report</h4>
                <form action="<?= route('getReportItem')?>" method="GET">
                    {{ csrf_field() }}
                        <div>
                            <select class="form_select" id="categories" type="text" name="categories">
                                <option value="BND013QR">BND013QR</option>
                                <option value="BND013L">BND013L</option>
                                <option value="BND01QA">BND01QA</option>
                                <option value="BND01QANew">BND01QANew</option>
                            </select>    
                        </div>
                        
                        <div class="form-material">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input autocomplete="off" type="text" id="reportDate" class="form-control" placeholder="Report Date" name="reportDate"/>
                                </div>
                            </div><!--end col-->
                        </div>
                    <div>   
                        <div class="col-md-3"> 
                            <button type="submit" class="btn btn-success" style="width: 270px; height: 38px;"><i class="dripicons-search"></i> Proses </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php if($category): ?>
<div class="row">
    <div class="col-lg-6">
        <div class="card card-eco">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h1 class="font-weight-bold"><?= $category ?> : <?= $reportDate ?></h1>
                </div>
                <div class="d-flex justify-content-between">
                    <h3 class="font-weight">Item : <?=number_format($reportItem->jumlah_item,0,'','.') ?></h3>
                </div>
                <p class="mb-0 text-muted text-truncate" style="font-size: 22px"><span class="text-success">Nominal : Rp.<?=number_format($reportItem->jumlah_amount,0,'','.')?></span></p>
            </div><!--end card-body-->
        </div><!--end card-->
    </div><!--end col-->
</div>
<?php endif;?>
@endsection('content')
