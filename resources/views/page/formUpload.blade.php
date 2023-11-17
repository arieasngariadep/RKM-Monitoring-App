@extends('layout.index')

@section('breadcrumbs')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= route('dashboard') ?>">Dashboard</a></li>
    <li class="breadcrumb-item">QRIS BND013</li>
    <li class="breadcrumb-item active">Upload Data</li>
</ol>
@endsection('breadcrumbs')

@section('titleTab', 'QR BND013 | Upload Data BND013')
@section('title', 'Upload Data BND013')

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
            <form action="<?= route('prosesUploadData') ?>" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="card-body">
                    <h4 class="mt-0 header-title">Upload Data BND013</h4>
                    <div class="form-group mb-0 row">
                        <label class="col-md-2 my-1 control-label mb-4">Pilih Jenis File Upload  :</label>
                        <div class="col-md-9">
                            <div class="form-check-inline my-1">
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="customRadio7" name="jenis_report" class="custom-control-input" value="BND013L">
                                    <label class="custom-control-label" for="customRadio7">BND013L</label>
                                </div>
                            </div>
                            <div class="form-check-inline my-1">
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="customRadio8" name="jenis_report" class="custom-control-input" value="BND013QR">
                                    <label class="custom-control-label" for="customRadio8">BND013QR</label>
                                </div>
                            </div>
                        </div>
                    </div> <!--end row-->
                    <input type="file" id="input-file-now" class="dropify" name="file_import[]" required multiple />
                </div><!--end card-body-->
                <div class="d-flex justify-content-center mb-4">
                    <button type="submit" class="btn btn-secondary waves-effect" style="width:200px;"><i class="mdi mdi-send mr-2"></i>&nbsp Submit</button>
                </div>
            </form>
        </div><!--end card-->
    </div><!--end col-->
</div><!--end row-->
@endsection('content')
