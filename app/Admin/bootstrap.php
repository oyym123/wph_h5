<?php
use App\Admin\Extensions\Form\uEditor;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Grid\Column;
use Encore\Admin\Form;
/**
 * Laravel-admin - admin builder based on Laravel.
 * @author z-song <https://github.com/z-song>
 *
 * Bootstraper for Admin.
 *
 * Here you can remove builtin form field:
 * Encore\Admin\Form::forget(['map', 'editor']);
 *
 * Or extend custom form field:
 * Encore\Admin\Form::extend('php', PHPEditor::class);
 *
 * Or require js and css assets:
 * Admin::css('/packages/prettydocs/css/styles.css');
 * Admin::js('/packages/prettydocs/js/main.js');
 *
 */

Form::extend('ueditor', uEditor::class);
Admin::js('/vendor/laravel-admin/AdminLTE/plugins/select2/select2.full.min.js');
Encore\Admin\Form::forget(['map']);
Column::extend('color', function ($value, $color) {
    return "<span style='color: $color'>$value</span>";
});


