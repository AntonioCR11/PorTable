{{-- RESTAURANT NAME --}}
<p class="m-0" style="font-family: helvetica_bold;font-size: 2em" id="restaurant_name">{{$restaurant->full_name}}</p>
{{-- TIME --}}
<div id="time_container" class="time_container mt-3">
    @for ($i = 0; $i<$restaurant->shifts;$i++)
        <button id="time_{{$restaurant->start_time+$i}}" class="btn btn-outline-dark mb-1" onclick="timeClicked({{$restaurant->start_time+$i}})">
            {{$restaurant->start_time+$i.": 00"}}
        </button>
    @endfor
</div>
{{-- RESTAURANT INFO --}}
<div class="restaurant_info">
    <p class="m-0 mt-3" style="font-family: helvetica_bold;font-size: 1.5em">Description</p>
    <p style="color: rgb(110, 110, 110)">{{$restaurant->description}} <br> <span class="m-0 mt-3" style="font-family: helvetica_bold;font-size: 1.1em">Reservation Price : {{$restaurant->price}}</span></p>
</div>
{{-- RESERVATION DETAIL --}}
<div class="reservation_detail">
    <p class="m-0 mt-3" style="font-family: helvetica_bold;font-size: 1.5em">Reservation Detail</p>
    <form action="/customer/bookTable/{{$restaurant->id}}" method="POST">
        @csrf
        <input id="selected_table" type="text" class="form-control mt-3 p-3" placeholder="Selected Table..." readonly name="table_number">
        <input type="date" class="form-control mt-3 p-3" name="reservation_date" onchange="changeReservationDate({{$restaurant->id}},this.value)">
        <input id="selected_time" type="text" class="form-control mt-3 p-3" placeholder="Selected Time..." readonly name="reservation_time">
        <button type="submit" class="btn w-100 mt-3 p-3" style="background-color: #ed3b27;color:white;">Book Table!</button>
    </form>
</div>
