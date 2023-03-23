@extends('adminlte::page')

@push('css-head')

@endpush

@section('title', 'List Images')

@section('content_header')

@stop

@section('content')
<?php
//Columns must be a factor of 12 (1,2,3,4,6,12)
$numOfCols = 4;
$rowCount = 0;
$bootstrapColWidth = 12 / $numOfCols;
?>
<div class="row">
<?php
foreach ($images as $image){
?>  
        <div class="col-md-<?php echo $bootstrapColWidth; ?>">
            <div class="thumbnail">
           <a href="{{secure_asset($image->path)}}" target="_bank">
             <img src="{{secure_asset($image->path)}}"> 
            </a>
                <div class="caption">{{$image->created_at}}</div>
            </div>
        </div>
<?php
    $rowCount++;
    if($rowCount % $numOfCols == 0) echo '</div><div class="row">';
}
?>
</div>


<div class="text-center">
        <?php echo $images->render(); ?>
    </div>

@stop

@push('js-footer')

@endpush


@section('scripts')

@endsection