@extends('layout.index')

@section('breadcrumbs')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= route('dashboard') ?>">Dashboard</a></li>
    <li class="breadcrumb-item">QRIS BND013</li>
    <li class="breadcrumb-item active">Upload Data</li>
</ol>
@endsection('breadcrumbs')

@section('titleTab', 'QR BND013 | Form Upload Duplicate')
@section('title', 'Form Upload Duplicate')

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
            <form action="<?= route('prosesUploadDuplicate') ?>" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="card-body">
                    <h4 class="mt-0 header-title">Form Upload Duplicate</h4>
                    <div class="form-group mb-2 row">
                        <input type="file" id="input-file-now" class="dropify" name="file_import[]" required multiple />
                    </div> <!--end row-->
                </div><!--end card-body-->
                <div class="d-flex justify-content-center mb-4">
                    <button type="submit" class="btn btn-secondary waves-effect" style="width:200px;"><i class="mdi mdi-send mr-2"></i>&nbsp Submit</button>
                </div>
            </form>
        </div><!--end card-->
    </div><!--end col-->
</div><!--end row-->
@endsection('content')
