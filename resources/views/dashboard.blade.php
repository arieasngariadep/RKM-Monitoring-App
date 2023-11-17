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
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <img class="d-block w-100" src="{{asset('template')}}/assets/images/Asset 2-100.jpg" />
                {{-- <img class="d-block w-100" src="{{asset('template')}}/assets/images/under maintenance.jfif" /> --}}
            </div><!--end card-body-->
        </div><!--end card-->
    </div><!--end col-->
</div><!--end row-->
@endsection('content')
