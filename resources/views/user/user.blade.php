@extends('layout.index')

@section('breadcrumbs')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">List User</li>
    </ol>
@endsection('breadcrumbs')

@section('titleTab', 'List User')
@section('title', 'List User')

@section('content')

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <?= $alert ?>
                <div class="text-right mb-2">
                    <a href="<?= route('formAddUser') ?>" class="btn btn-purple btn-round"><i class="dripicons-plus"></i> Add New</a>
                </div>
                <div class="table-responsive">
                    <table id="datatable" class="table table-hover mb-0">
                        <thead class="thead-default">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Kelompok</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $no = 1;
                                foreach($userList as $list){
                                    $button = "
                                    <a target='_blank' href='".route('formUpdateUser', ['id' => $list->userId])."' class='btn btn-outline-warning' data-toggle='tooltip' data-placement='top' title='' data-original-title='Edit'>
                                        <i class='mdi mdi-account-edit'></i>
                                    </a> |
                                    <a href='".route('deleteUser', ['id' => $list->userId])."' class='btn btn-outline-danger' data-toggle='tooltip' data-placement='top' title='' data-original-title='Hapus'>
                                        <i class='mdi mdi-account-remove'></i>
                                    </a>";
                                    echo "
                                        <tr>
                                            <td>$no</td>
                                            <td>".$list['name']."</td>
                                            <td>".$list['email']."</td>
                                            <td>".$list['role_name']."</td>
                                            <td>".$list['kelompok']."</td>
                                            <td class='text-center'>$button</td>
                                        </tr>
                                    ";
                                    $no++;
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            </div>
        </div><!--end card-->
    </div><!--end col-->
</div><!--end row-->
@endsection('content')
