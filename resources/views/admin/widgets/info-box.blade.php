<div {!! $attributes !!}>
    <div class="inner">
        <p><center>{{ $name }}</center></p>
        <h3><center>{{ $info }}</center></h3>

        
    </div>
    <div class="icon">
        <i class="fa fa-{{ $icon }}"></i>
    </div>
    <a href="{{ $link }}" class="small-box-footer">
        {{ trans('admin.more') }}&nbsp;
        <i class="fa fa-arrow-circle-right"></i>
    </a>
</div>