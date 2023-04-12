<div class="ticket">
    {{-- TEMPLATE CARD --}}
    <div class="mb-3 me-2 " style="position: relative;width: 400px">
        <a class="text-dark p-0"  style="text-decoration: none;" href="/customer/restaurant/{{$activeReservation->restaurant->full_name}}">
            {{-- RESTAURANT EVENT --}}
            <div class="number_container" style="position: absolute;top:30px;right:5%;">
                <div class="event_label text-light p-3 rounded-3 text-center navigation" style="background-color: #6C4AB6; ">{{$activeReservation->table->seats}}</div>
                <div class="cancel_container">
                    {{-- CANCEL BTN --}}
                    <a id="opencancel_{{$activeReservation->id}}" onclick="opencancel({{$activeReservation->id}})" >
                        <button class="btn event_label text-light p-1 rounded-3 text-center navigation" style="background-color: #ed3b27; ">Cancel</button>
                    </a>
                    {{-- CONFIRMATION --}}
                    <div id="cancelconfirmation_{{$activeReservation->id}}" class="cancel_confirmation bg-light p-2 rounded-3 d-none">
                        <p class="m-0">Cancel?</p>
                        <a onclick="cancel_reservation({{$activeReservation->id}})" >
                            <button class="btn event_label text-light p-1 rounded-3 text-center navigation" style="background-color: #06c700; ">Yes</button>
                        </a>
                        <a onclick="closecancel({{$activeReservation->id}})" >
                            <button class="btn btn-dark m-0 event_label text-light p-1 rounded-3 text-center navigation">No</button>
                        </a>
                    </div>
                </div>
            </div>
            {{-- CARD CONTENT --}}
            <div class="restaurant_card bg-light p-3" >
                <div class="image_container" style="height: 18rem">
                    @php
                        $activeReservation_restaurant = $activeReservation->restaurant->full_name;
                    @endphp
                    <img class="" src="{{asset("storage/images/restaurant/$activeReservation_restaurant/restaurant_1.jpg")}}" alt="" width="100%" height="100%">
                </div>

                {{-- RESTAURANT INFO --}}
                <div class="row m-0 mt-2 overflow-auto" style="height: 5rem">
                    <div class="col-10">
                        <div class="restaurant_info" >
                            <p class="m-0" style="font-family: helvetica_bold;font-size: 1.5em">{{$activeReservation->restaurant->full_name}}</p>
                            <p class="m-0" style="font-family: helvetica_regular;font-size: 0.8em;color: rgb(111, 111, 111);">{{$activeReservation->restaurant->description}}</p>
                        </div>
                    </div>
                    <div class="col-2 d-flex justify-content-end align-items-center">
                        <p class="m-0">1</p>
                        <img  src="{{asset('storage/images/customer/person.png')}}" alt="" width="30px" height="30px">
                    </div>
                </div>

                <hr>
                {{-- TRANSACTION DETAIL --}}
                <div class="code d-flex justify-content-end">
                    <div class="text-end">
                        {{-- <p class="m-0" style="font-family: helvetica_bold;font-size: 1.1em;">Transaction code : 1PKhfWqLiADhSb7</p> --}}
                        <p class="m-0" style="font-family: helvetica_regular;">Order Price : Rp {{$activeReservation->restaurant->price}}</p>
                        <p class="m-0" style="font-family: helvetica_regular;">Reservation date : {{$activeReservation->reservation_date_time}}</p>
                    </div>
                </div>
            </div>
        </a>
    </div>

</div>
