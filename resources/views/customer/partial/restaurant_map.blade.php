@for ($i = 0; $i<$row_length;$i++)
    <div class="d-flex">
        @for ($j = 0; $j<$col_length;$j++)
            <div class="p-1" style="width: 70px;">
                @if (in_array(($i*$col_length)+($j+1),$reserved_tableId))
                    <div id="table_{{($i*$col_length)+($j+1)}}" class="btn w-100 d-flex justify-content-center align-items-center" style="height: 60px;background-color: #ed3b27;color:white;">
                        {{($i*$col_length)+($j+1)}}
                    </div>
                @else
                    <div id="table_{{($i*$col_length)+($j+1)}}" onclick="tableClicked({{($i*$col_length)+($j+1)}})" class="btn w-100 d-flex justify-content-center align-items-center" style="height: 60px;background-color: #6C4AB6;color:white;">
                        {{($i*$col_length)+($j+1)}}
                    </div>
                @endif
            </div>
        @endfor
    </div>
@endfor
