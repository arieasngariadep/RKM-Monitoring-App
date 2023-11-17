<?php
namespace App\Helpers;

class Alerts {
    public static function alertDanger($msg){
        if($msg){
            $alert = '<div class="alert icon-custom-alert alert-outline-pink b-round fade show" role="alert">
            <i class="mdi mdi-alert-outline alert-icon"></i>
            <div class="alert-text">
                <strong>Failed !</strong> '.$msg.'
            </div>

            <div class="alert-close">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true"><i class="mdi mdi-close text-danger"></i></span>
                </button>
            </div>
        </div>';
        }else{
            $alert = false;
        }
        return $alert;
    }
    public static function alertSuccess($msg){
        if($msg){
            $alert = ' <div class="alert icon-custom-alert alert-outline-success alert-success-shadow" role="alert">
            <i class="mdi mdi-check-all alert-icon"></i>
            <div class="alert-text">
                <strong>Success!</strong> '.$msg.'
            </div>
        </div>';
        }else{
            $alert = false;
        }
        return $alert;
    }
    public static function alertInfo($msg){
        if($msg){
            $alert = '<div class="alert alert-outline-purple b-round" role="alert">
            <strong>Warning!</strong> '.$msg.'
        </div>';
        }else{
            $alert = false;
        }
        return $alert;
    }
}
