@php
    $seatCounter=1;
@endphp
@for ($i = 0; $i < $restaurant->row; $i++)
    <div class="d-flex justify-content-center" style="width: fit-content">
        @for($j = 0; $j < $restaurant->col; $j++)
            @php
                // $seatCounter = ($i+1)*($j+1)-1;
                $foundIndex = -1;
                $ctr = 0;
                while ($ctr < count($reservations) && $foundIndex < 0) {
                    if ($reservations[ctr]->table->seats == $seatCounter) $foundIndex = $ctr;
                    $ctr++;
                }
            @endphp
            <button col="{{ $j+1 }}" row="{{ $i+1 }}" class="table-block @php echo (($foundIndex == -1) ? "available" : "occupied") @endphp" disabled>{{ $seatCounter++ }}</button>
        @endfor
    </div>
@endfor
