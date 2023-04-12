{{--
    RESERVATION POPUP :
    view ini akan muncul apabila salah satu dari tombol reserve pada card dalam catalog ditekan
    reservation popup berisi peta yang sudah, belum terisi dan juga form detail pemesanan

    FLow :
    customer dapat memilih meja yang akan direservasi dengan cara menekan meja yang available
    data dari meja tersebut kemudian akan masuk kedalam form
    ketika form disubmit maka transaksi baru akan terbuat
--}}
<div class=" popup_container position-fixed w-100 d-flex align-items-end flex-column d-none" style="background-color: rgb(0, 0, 0, 0.4);z-index: 100;">
    {{-- CLOSE BUTTON --}}
    <div class="close d-flex justify-content-end align-items-center w-100 px-5" style="height: 10vh;">
        <div class="btn btn-outline-light" onclick="close_popup()">X</div>
    </div>
    {{-- BLANK SPACE FOR ANIMATION --}}
    <div class="blank w-100" style="height: 90vh" >

    </div>
    <div class="popup bg-light w-100 p-5 overflow-auto" style="border-top-left-radius: 20px;border-top-right-radius: 20px;">

        <div class="row m-0 h-100">
            {{-- AVAILABLE TABLE --}}
            <div class="col-sm-12 col-md-6 d-flex flex-column justify-content-center align-items-center h-100">
                <div class="table_container">
                    {{-- SELECT TABLE --}}
                    <div class="w-100 mb-3">
                        <p class="m-0" style="font-family: helvetica_bold;font-size: 2em">Select Table</p>
                    </div>
                    {{-- RESTAURANT MAP --}}
                    <div class="map_container" id="map_container">
                        {{--  ini merupakan container untuk map dari suatu restoran yang diisi menggunakan AJAX --}}

                    </div>
                    {{-- DESCRIPTION --}}
                    <div class="w-100 mt-3">
                        <p class="m-0" style="font-family: helvetica_bold;font-size: 1.5em">Description</p>
                        <div class="available">
                            <div class="btn" style="background-color: #6C4AB6;color:white;">Available</div>
                            <div class="btn" style="background-color: #FEB139;">Selected</div>
                            <div class="btn" style="background-color: #ed3b27;color:white;">Reserved</div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- FORM DETAIL --}}
            <div class="col-sm-12 col-md-6 p-3 d-flex justify-content-center align-items-center">
                <div class="form_container" id="form_container">
                    {{-- ini merupakan container untuk form detail restoran yang diisi menggunakan AJAX --}}

                </div>
            </div>
        </div>
    </div>
</div>

