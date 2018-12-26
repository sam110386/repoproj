<div class="table-responsive panel">
    <table class="table table-striped">
        <tr>
            <td width="120px" colspan="2" align="center"><strong>Top Performer</strong></td>
            
        </tr>
        @foreach($institutes as $institute)
        <tr>
            <td width="120px">{{$institute->name}}</td>
            <td>
                @if($institute->ratio>0)
                <div style="width:{{$institute->ratio*100}}%;background:green;float:left;color:#fff;text-align: center;">{{ $institute->total-$institute->totalfemail}}</div><div style="width:{{(1-$institute->ratio)*100}}%;background:red;float:right;color:#fff;text-align: center;">{{$institute->totalfemail}}</div>
                @else
                <div style="width:100%;background:green;float:left;color:#fff;text-align: center;">0</div>
                @endif
            </td>
        </tr>
        @endforeach
    </table>
</div>