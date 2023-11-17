<?php
    $uri1 = Request::segment(1);
    $uri2 = Request::segment(2);
    $uri3 = Request::segment(3);
    $role = Session::get('role_id');
    $kelompok_id = Session::get('kelompok_id');
?>

<div class="left-sidenav">
    <ul class="metismenu left-sidenav-menu">
        <li class="<?= ($uri1 == 'dashboard' ? 'mm-active' : ''); ?>">
            <a href="<?= route('dashboard') ?>"><i class="ti-bar-chart"></i><span>Dashboard</span></a>
        </li>

        <?php if(($role == 1 && $kelompok_id == 6) || $role == 7) : ?>
        <li class="<?= ($uri1 == 'formUploadBND013' ? 'mm-active' : ''); ?>">
            <a href="<?= route('formUploadBND013') ?>"><i class="dripicons-browser-upload"></i><span>Upload Data BND013</span></a>
        </li>
        <?php endif; ?>

        <?php if(($role == 1 && $kelompok_id == 6) || $role == 7) : ?>
        <li class="<?= ($uri2 == 'formUploadBND01QANew' ? 'mm-active' : ''); ?>">
            <a href="<?= route('formUploadBND01QANew') ?>"><i class="dripicons-browser-upload"></i><span>Upload Data BND01 New</span></a>
        </li>
        <?php endif; ?>

        
        <?php if(($role == 1 && $kelompok_id == 6) || $role == 7) : ?>
        <li class="<?= ($uri1 == 'formUploadPaymentReject' ? 'mm-active' : ''); ?>">
            <a href="<?= route('formUploadKKTC') ?>"><i class="dripicons-browser-upload"></i><span>Upload Data BND Payment & BND Reject</span></a>
        </li>
        <?php endif; ?>

        <li class="<?= ($uri1 == 'BND013L' ? 'mm-active' : ''); ?>">
            <a href="<?= route('getListBND013L') ?>"><i class="dripicons-checklist"></i><span>List Data BND013L</span></a>
        </li>

        <li class="<?= ($uri1 == 'BND013QR' ? 'mm-active' : ''); ?>">
            <a href="<?= route('getListBND013QR') ?>"><i class="dripicons-list"></i><span>List Data BND013QR</span></a>
        </li>

        <li class="<?= ($uri1 == 'BND01QA' ? 'mm-active' : ''); ?>">
            <a href="<?= route('getListBND01QA') ?>"><i class="dripicons-list"></i><span>List Data BND01QA</span></a>
        </li>

        <li class=" <?=($uri1 == 'BND01QANew' ? 'mm-active' : '');?>">
            <a href=" <?=route('getListBND01QANew') ?>"><i class="dripicons-list"></i><span>List Data BND01QA New</span></a>
        </li>

        <li class=" <?=($uri1 == 'KartuKredit' ? 'mm-active' : '');?>">
            <a href=" <?=route('getListKartuKredit') ?>"><i class="dripicons-list"></i><span>BND Payment</span></a>
        </li>

        <li class=" <?=($uri1 == 'TapCash' ? 'mm-active' : '');?>">
            <a href=" <?=route('getListTapCash') ?>"><i class="dripicons-list"></i><span>BND Reject</span></a>
        </li>
       
        <li class="<?= ($uri1 == 'Duplicate' ? 'mm-active' : '') ?>">
            <a href="<?= route('formCekDuplicate') ?>"><i class="dripicons-basketball"></i><span>Cek Duplicate</span></a>
        </li>

        <li class="<?= ($uri1 == 'reportCek' ? 'mm-active' : '') ?>">
            <a href="<?= route('getReportItem') ?>"><i class="dripicons-search"></i><span>Cek Report</span></a>
        </li>
        
        <?php if($role == 1 || $role == 7) : ?>
        <li class="<?= ($uri1 == 'user' ? 'mm-active' : ''); ?>">
            <a href="<?= route('getAllUser') ?>"><i class="dripicons-user-group"></i><span>User</span></a>
        </li>
        <?php endif; ?>
    </ul>
</div>
