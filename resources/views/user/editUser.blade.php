@extends('layout.index')

@section('breadcrumbs')
    <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?= route('getAllUser') ?>">List User</a></li>
        <li class="breadcrumb-item active">Update User</li>
    </ol>
@endsection('breadcrumbs')

@section('titleTab', 'Update User')
@section('title', 'Update User')

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
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="mt-0">Update User</h5>
                <form class="form-horizontal auth-form my-4" action="<?= route('prosesUpdateUser') ?>" method="POST">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-sm-12 col-lg-6">
                            <div class="form-group row">
                                <label for="fullName" class="col-sm-3 col-form-label">Full Name</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="text" value="<?= $user->name ?>" id="fullName"  name="fullName" placeholder="Full Name">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-sm-3 col-form-label">Password</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="password" id="password" name="password">
                                </div>
                            </div>
                            <div class="form-group row mt-4">
                                <label class="col-sm-3 col-form-label">Role</label>
                                <div class="col-sm-8">
                                    <select id="role_id" name="role_id" class="form-control" required>
                                        <option value="">Please Select Option</option>
                                        <?php
                                            foreach($roleList as $list){
                                                if($user['role_id'] == $list['role_id']){
                                                    $sel = 'selected';
                                                }else{
                                                    $sel = '';
                                                }
                                                echo "
                                                    <option value='".$list['role_id']."' $sel>".$list['role_name']."</option>
                                                ";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 col-lg-6">
                            <div class="form-group row">
                                <label for="email" class="col-sm-3 col-form-label">Email</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="email" value="<?= $user->email ?>" id="email" name="email">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="confirm_password" class="col-sm-3 col-form-label">Confirm Password</label>
                                <div class="col-sm-8">
                                    <input class="form-control" type="password" id="confirm_password" name="confirm_password">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Kelompok</label>
                                <div class="col-sm-8">
                                    <select id="kelompok_id" name="kelompok_id" class="form-control" required>
                                        <option value="">Please Select Option</option>
                                         <?php
                                            foreach($kelompokList as $list){
                                                if($user['kelompok_id'] == $list['id']){
                                                    $sel = 'selected';
                                                }else{
                                                    $sel = '';
                                                }
                                                echo "
                                                    <option value='".$list['id']."' $sel>".$list['kelompok']."</option>
                                                ";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3 text-right">
                            <input type="text" class="form-control" id="id" name="id" value="<?= $user->userId ?>" hidden />
                            <button type="submit" class="btn btn-primary waves-effect waves-light" style="width: 200px">Submit</button>
                        </div>
                        <div class="col-md-6 mb-3">
                            <input type="reset" class="btn btn-dark waves-effect waves-light" style="width: 200px">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->
@endsection('content')
