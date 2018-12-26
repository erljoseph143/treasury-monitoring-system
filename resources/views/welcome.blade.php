<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" value="{{csrf_token()}}">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Treasury</title>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="{{ url('metronic/assets/global/css/fonts.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{url('assets/css/dashboard.css')}}">
    {{--<link rel="stylesheet" href="{{url('css/bootstrap4/bootstrap.min.css')}}">--}}
    <link rel="stylesheet" href="{{url('bootstrap4/dataTable/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ url('metronic/assets/global/plugins/font-awesome/css/font-awesome.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ url('metronic/assets/global/plugins/simple-line-icons/simple-line-icons.min.css') }}"/>
    {{--<link rel="stylesheet" type="text/css" href="{{ url('metronic/assets/global/plugins/bootstrap/css/bootstrap.min.css') }}"/>--}}
    {{--<link rel="stylesheet" type="text/css" href="{{ url('metronic/assets/global/plugins/uniform/css/uniform.default.css') }}"/>--}}
    {{--<link rel="stylesheet" type="text/css" href="{{ url('metronic/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css') }}"/>--}}
    {{--<!-- END GLOBAL MANDATORY STYLES -->--}}

    {{--<!-- BEGIN PAGE STYLES -->--}}
    {{--<link rel="stylesheet" type="text/css" href="{{ url('metronic/assets/admin/pages/css/tasks.css') }}"/>--}}
    {{--<!-- BEGIN PAGE LEVEL STYLES -->--}}
    {{--<link rel="stylesheet" type="text/css" href="{{ url('metronic/assets/global/plugins/select2/select2.css') }}"/>--}}
    {{--<link rel="stylesheet" type="text/css" href="{{ url('metronic/assets/global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css') }}"/>--}}
    {{--<link rel="stylesheet" type="text/css" href="{{ url('metronic/assets/global/plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css') }}"/>--}}
{{--    <link rel="stylesheet" type="text/css" href="{{ url('metronic/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css') }}"/>--}}
    {{--<!-- END PAGE LEVEL STYLES -->--}}

    {{--<!-- BEGIN PLUGINS USED BY X-EDITABLE -->--}}
    {{--<link rel="stylesheet" type="text/css" href="{{ url('metronic/assets/global/plugins/bootstrap-datepicker/css/datepicker.css') }}"/>--}}
    {{--<link rel="stylesheet" type="text/css" href="{{ url('metronic/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}"/>--}}
    {{--<link rel="stylesheet" type="text/css" href="{{ url('metronic/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}"/>--}}
    {{--<link rel="stylesheet" type="text/css" href="{{ url('metronic/assets/global/plugins/bootstrap-editable/bootstrap-editable/css/bootstrap-editable.css') }}"/>--}}
    {{--<!-- END PLUGINS USED BY X-EDITABLE -->--}}

    {{--<!-- BEGIN THEME STYLES -->--}}
    {{--<!-- DOC: To use 'rounded corners' style just load 'components-rounded.css' stylesheet instead of 'components.css' in the below style tag -->--}}
    {{--<link rel="stylesheet" type="text/css" href="{{ url('metronic/assets/global/css/components.css') }}"/>--}}
    {{--<link rel="stylesheet" type="text/css" href="{{ url('metronic/assets/global/css/plugins.css') }}"/>--}}
    {{--<link rel="stylesheet" type="text/css" href="{{ url('metronic/assets/admin/layout2/css/layout.css') }}"/>--}}
    {{--<link rel="stylesheet" type="text/css" href="{{ url('metronic/assets/admin/layout2/css/themes/default.css') }}"/>--}}
    <link rel="stylesheet" type="text/css" href="{{ url('metronic/assets/admin/layout2/css/custom.css') }}"/>
    <link rel="stylesheet" href="{{url('datepicker/bootstrap-datepicker.css')}}" type="text/css">

    {{--<link rel="stylesheet" type="text/css" href="{{url('metronic/assets/global/plugins/bootstrap-datepicker/css/datepicker.css')}}"/>--}}
    <!-- END THEME STYLES -->

    <style>
        /*.row {*/
            /*display: -ms-flexbox;*/
            /*display: flex;*/
            /*-ms-flex-wrap: wrap;*/
            /*flex-wrap: wrap;*/
            /*margin-right: -4.75rem;*/
            /*margin-left: -5.75rem;*/
        /*}*/
        .table-responsive
        {
            padding:10px;
        }
        .table th, .text-wrap table th, .table td, .text-wrap table td {
            padding:4px;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }
        .table thead th, .text-wrap table thead th {
            border-top: 0;
            border-bottom-width: 1px;
             padding-top: 5px;
             padding-bottom: 5px;
        }
        .table th, .text-wrap table th {
            font-weight: bold;
        }
        table {
            border-bottom: 2px solid green;
        }
        .table .btn {
            margin-top: 0px;
            margin-left: 0px;
            margin-right: 5px;

        }
        .header-brand-img {
            height: 3rem;
        }
        .header {
            background: cadetblue;
        }
        #headerMenuCollapse {
            background: darkslategrey;
        }
        .nav-tabs .nav-link.active {
            color: aquamarine;
        }
        .nav-tabs .nav-link {
            color: gainsboro;
        }

        .form-control[readonly] {
            background-color: #fff;
            opacity: 1;
        }
    </style>
</head>
<body class="">
<div id="app">

</div>
<script>
    var $baseUrl = "{{url('/')}}";

</script>
<script src="{{url('js/app.js')}}"></script>
{{--<script type="text/javascript" src="{{ url('metronic/assets/global/plugins/datatables/media/js/jquery.dataTables.min.js') }}"></script>--}}
{{--<script type="text/javascript" src="{{ url('metronic/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js') }}"></script>--}}
<script type="text/javascript" src="{{url('bootstrap4/dataTable/js/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript" src="{{url('bootstrap4/dataTable/js/dataTables.bootstrap4.min.js')}}"></script>
<script type="text/javascript" src="{{url('datepicker/bootstrap-datepicker.js')}}"></script>
<script src="{{ url('maskmoney/jquery.maskMoney.js') }}" type="text/javascript"></script>
</body>
</html>