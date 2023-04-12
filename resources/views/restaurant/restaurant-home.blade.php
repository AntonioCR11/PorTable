@extends('layouts.restaurant-sidebar')

@section('custom-css-extended')
    <style>
        /** Rservation Card Classes */
        .reservation-holder {
            width: 100%;
            overflow: scroll;
            margin-bottom: 4em;
        }

        .scrollable {
            width: max-content;
            height: min-content;
            margin-bottom: 8px;
        }

        .reservation {
            display: inline-block;
            width: 20em;
        }

        /** Reservation Table Classes */
        .table-block {
            width: 4em;
            height : 4em;
            border-radius: 6px;
            border: 1px solid rgba(50, 50, 50, 0.25);
            margin: 4px;
            display: inline-block;
            color: white;
        }
        .available {
            background-color: #06c700;
        }
        .occupied {
            background-color: #ed3b27;
        }
        .card-table-desc {
            border-radius: 6px;
        }
    </style>
@endsection

@section('main-content')
    <main class="p-4">
        {{-- Holds all reservation curently being made to the restaurant, don't forget to order it from the most closest based on time in an ascending order --}}
        <h1>Pending Reservations</h1>
        <hr>
        <div class="reservation-holder">
            <div id="pending-reservations" class="scrollable">
                {{-- All reservations will be put in this container --}}
            </div>
        </div>

        {{-- Restaurant Table Availability GUI --}}
        <div class="container mb-4 text-center">
            <h1>Tables</h1>
            <div class="w-100" style="overflow: scroll">
                <div id="table-layout" class="scrollable mx-auto">
                    {{-- Table GUI layout will be contained in this container --}}
                </div>
            </div>
            <div class="d-flex-column align-item-center justify-content-center mx-auto text-center" style="width: fit-content">
                <div class="h5" style="">Description:</div>
                <div class="d-flex" style="width: fit-content">
                    <div class="available card-table-desc text-white p-3 py-2 me-2">Available</div>
                    <div class="occupied  card-table-desc text-white p-3 py-2 ">Reserved</div>
                </div>
            </div>
        </div>

        <h1>Settings</h1>
        <hr>
        <div class="container">
            <div class="row">
                <div class="col-8">
                    @if(Session::has('success'))
                        <div class="card bg-success text-white p-2 mb-4"> {{ Session::get('success'); }} </div>
                    @enderror
                    <form action="/restaurant/updateRestaurant" method="post">
                        @csrf
                        {{-- A save button that will popup when a change has been detected --}}
                        <div id="unsavedPlaceholder" style="display: none">
                            <div class="d-flex mb-4">
                                <div class="rounded-3 me-2 p-2 px-3 bg-danger flex-fill">
                                    <span class="text-white">Unsaved Changes</span>
                                </div>
                                <input id="saveButton" type="submit" value="save" class="btn btn-primary" disabled>
                            </div>
                        </div>

                        {{-- The restaurant name setting --}}
                        <div id="restaurant-name" class="mb-3">
                            <h6 style="margin-bottom: 4px">Restaurant Name:</h6>
                            <input id="restaurantNameInput" type="text" class="form-control" value="{{ $restaurant->full_name }}" placeholder="Restaurant's name" name="restaurantName" aria-label="Restaurant's name" aria-describedby="restaurant's-name" disabled>
                            <small><em>This name is visible to anyone who is looking for this establishment, and cannot be changed!</em></small>

                            @error('restaurantName')
                                @include('partial.validationMessage')
                            @enderror
                        </div>

                        {{-- The restaurant account password setting --}}
                        <div id="new-password" class="mb-3">
                            <h6 style="margin-bottom: 4px">New Password:</h6>
                            <input id="newPasswordInput" type="password" class="form-control" placeholder="New Password" name="newPassword" aria-label="New password" aria-describedby="new-password">
                            <small><em>Keep this input empty to not change it.</em></small>

                            @if(Session::has('err'))
                                <div class="msg" style="color: red;"> {{ Session::get('err'); }} </div>
                            @enderror

                            @error('newPassword')
                                @include('partial.validationMessage')
                            @enderror

                            @error('restaurantPassword')
                                @include('partial.validationMessage')
                            @enderror
                        </div>

                        {{-- The below password box pop up to existence when a new password has been inserted, (change class form visible to invisible?) --}}
                        <div id="changePasswordPrompt" style="display: none">
                            <div class="card p-2 mb-3">
                                <div id="confirm-password" class="mb-3">
                                    <h6 style="margin-bottom: 4px">Confirm Password:</h6>
                                    <input id="confirmPasswordInput" type="password" class="form-control" placeholder="Confirm Password" name="newPassword_confirmation" aria-label="Confirm password" aria-describedby="confirm-password">
                                    <small><em>Re-enter the new password to confirm it.</em></small>
                                </div>
                                <div id="restaurant-password">
                                    <h6 style="margin-bottom: 4px">Restaurant Password:</h6>
                                    <input id="currentPasswordInput" type="password" class="form-control" placeholder="Current Password" name="restaurantPassword" aria-label="Restaurant's password" aria-describedby="restaurant's-password">
                                    <small><em>Enter the current password to change password.</em></small>
                                </div>
                            </div>
                        </div>

                        {{-- The restaurant table setting --}}
                        <div id="table-setting" class="mb-3">
                            <h6 style="margin-bottom: 4px">Table Setting:</h6>
                            <div class="input-group">
                                <span class="input-group-text" id="open-time">Row:</span>
                                <input id="tableRowInput" type="number" min="1" max="20" class="form-control" name="tableRow" placeholder="3" value="{{ $restaurant->row }}" aria-label="tableRow" aria-describedby="Table-Row" required>
                                <span class="input-group-text" id="shifts">Column:</span>
                                <input id="tableColumnInput" type="number" min="1" max="20" class="form-control" name="tableColumn" placeholder="3" value="{{ $restaurant->col }}" aria-label="tableColumn" aria-describedby="Table-Column" required>
                            </div>

                            @error('tableRow')
                                @include('partial.validationMessage')
                            @enderror

                            @error('tableColumn')
                                @include('partial.validationMessage')
                            @enderror
                        </div>

                        {{-- The restaurant address setting --}}
                        <div id="restaurant-address" class="mb-3">
                            <h6 style="margin-bottom: 4px">Restaurant Address:</h6>
                            <input id="addressInput" type="text" class="form-control" value="{{ $restaurant->address }}" placeholder="Restaurant Address" name="restaurantAddress" aria-label="Restaurant address" aria-describedby="restaurant-address" required>

                            @error('restaurantAddress')
                                @include('partial.validationMessage')
                            @enderror
                        </div>

                        {{-- The restaurant phone number setting --}}
                        <div id="restaurant-phone" class="mb-3">
                            <h6 style="margin-bottom: 4px">Restaurant Phone:</h6>
                            <input id="phoneInput" type="text" class="form-control" value="{{ $restaurant->phone }}" placeholder="Restaurant Phone Number" name="restaurantPhone" aria-label="Restaurant phone" aria-describedby="restaurant-phone" required>

                            @error('restaurantPhone')
                                @include('partial.validationMessage')
                            @enderror
                        </div>

                        {{-- The restaurant description setting --}}
                        <div id="restaurant-description" class="mb-3">
                            <h6 style="margin-bottom: 4px">Reservation Description:</h6>
                            <textarea id="descriptionInput" class="form-control" placeholder="Enter your restaurant description..." style="height: 100px" name="restaurantDescription">{{ $restaurant->description }}</textarea>

                            @error('restaurantDescription')
                                @include('partial.validationMessage')
                            @enderror
                        </div>

                        {{-- The restaurant opening time and shifts --}}
                        <div id="active-time" class="mb-3">
                            <h6 style="margin-bottom: 4px">Active Time:</h6>
                            <div class="input-group">
                                <span class="input-group-text" id="open-time">Open:</span>
                                <input id="openTimeInput" type="time" class="form-control" value="{{ (($restaurant->start_time / 10 >= 1) ? $restaurant->start_time : "0".$restaurant->start_time) }}:00" name="openTime" aria-label="openTime" aria-describedby="Open-time" required>
                                <span class="input-group-text" id="shifts">Shifts:</span>
                                <input id="shiftsInput" type="number" min="1" max="23" class="form-control" value="{{ $restaurant->shifts }}" name="shifts" aria-label="shifts" aria-describedby="Shifts" required>
                            </div>

                            @error('openTime')
                                @include('partial.validationMessage')
                            @enderror

                            @error('shifts')
                                @include('partial.validationMessage')
                            @enderror
                        </div>

                        {{-- The restaurant reservation cost setting --}}
                        <div id="reservation-cost" class="mb-3">
                            <h6 style="margin-bottom: 4px">Reservation Cost:</h6>
                            <div class="input-group">
                                <span class="input-group-text" id="cost-currency">Rp.</span>
                                <input id="costInput" type="number" class="form-control" value="{{ $restaurant->price }}" placeholder="Reservation Cost" step="100" name="reservationCost" aria-label="Reservation cost" aria-describedby="reservation-cost" required>
                            </div>

                            @error('reservationCost')
                                @include('partial.validationMessage')
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="col-4">
                    {{-- Todo: Restaurant photos --}}
                </div>
            </div>
        </div>
    </main>

    <script>
        /**
         * Main function to trigger after the html document has finished loading.
         */
        document.addEventListener('DOMContentLoaded', () => {
            // Initialize the element object variables
            const unsavedPlaceholder = $("#unsavedPlaceholder");
            const restaurantNameInput = $("#restaurantNameInput");
            const newPasswordInput = $("#newPasswordInput");
            const changePasswordPrompt = $("#changePasswordPrompt");
            const tableRowInput = $("#tableRowInput");
            const tableColumnInput = $("#tableColumnInput");
            const addressInput = $("#addressInput");
            const phoneInput = $("#phoneInput");
            const descriptionInput = $("#descriptionInput");
            const openTimeInput = $("#openTimeInput");
            const shiftsInput = $("#shiftsInput");
            const costInput = $("#costInput");
            const reservationContainer = $("#pending-reservations");
            const tableContainer = $("#table-layout");

            // Variables
            const settingValues = [
                "{{ $restaurant->full_name }}",     // Restaurant name
                "{{ "" }}",                         // Restaurant new password
                "{{ $restaurant->row }}",           // Restaurant Row
                "{{ $restaurant->column }}",        // Restaurant Column
                "{{ preg_replace('/\s+/', ' ', $restaurant->address) }}",       // Restaurant address
                "{{ $restaurant->phone }}",         // Restaurant phone
                "{{ $restaurant->description }}",   // Restaurant description
                "{{ $restaurant->start_time }}",    // Restaurant opening time
                "{{ $restaurant->shifts }}",        // Restaurant shifts
                "{{ $restaurant->price }}"          // Reservation cost
            ];
            const settingStatus = [true, true, true, true, true, true, true, true, true, true];

            // Register events to the variables
            getReservations(reservationContainer);
            getAvailableTables(tableContainer);

            // Show the confirmation prompt when entering a new password
            newPasswordInput.on("input", showPrompt(newPasswordInput, changePasswordPrompt, ""));

            // Show the save prompt when a new value is detected
            restaurantNameInput.on("input", checkChanges(restaurantNameInput, unsavedPlaceholder, settingValues, settingStatus, 0));
            newPasswordInput.on("input", checkChanges(newPasswordInput, unsavedPlaceholder, settingValues, settingStatus, 1));
            tableRowInput.on("input", checkChanges(tableRowInput, unsavedPlaceholder, settingValues, settingStatus, 2));
            tableColumnInput.on("input", checkChanges(tableColumnInput, unsavedPlaceholder, settingValues, settingStatus, 3));
            addressInput.on("input", checkChanges(addressInput, unsavedPlaceholder, settingValues, settingStatus, 4));
            phoneInput.on("input", checkChanges(phoneInput, unsavedPlaceholder, settingValues, settingStatus, 5));
            descriptionInput.on("input", checkChanges(descriptionInput, unsavedPlaceholder, settingValues, settingStatus, 6));
            openTimeInput.on("input", checkChanges(openTimeInput, unsavedPlaceholder, settingValues, settingStatus, 7));
            shiftsInput.on("input", checkChanges(shiftsInput, unsavedPlaceholder, settingValues, settingStatus, 8));
            costInput.on("input", checkChanges(costInput, unsavedPlaceholder, settingValues, settingStatus, 9));
        });

        /**
         * Toggle the prompt to show up or hidden away when a input element is empty or filled in.
         *
         * @param {JqueryObject} inputElement  The input field of the html element.
         * @param {JqueryObject} promptElement The element which is going to be toggled if the condition is met.
         * @param {string}       compareValue  A string value to compare the input element value with.
         *
         * @return {function} An event handler function for the event.
         */
        function showPrompt(inputElement, promptElement, compareValue) {
            return (event) => {
                if (inputElement.val() !== compareValue) {
                    // Show prompt to existence
                    if (promptElement[0].style.display === "none") {
                        promptElement.slideDown(250);
                    }
                }
                else {
                    // Unshow prompt from existence
                    if (!promptElement[0].classList.contains("d-none")) {
                        promptElement.slideUp(250);
                    }
                }
            }
        }

        /**
         * Check for a different value when entering into the settings.
         * If a difference is detected, show the save button prompt.
         *
         * @param {JqueryObject} inputElement  The input field of the html element.
         * @param {JqueryObject} promptElement The element which is going to be toggled if the condition is met.
         * @param {Array}        settingValues An array of values for checking.
         * @param {Array}        settingStatus An array of booleans to indicate whether the input is the same or not.
         * @param {Integer}      arrayIndex    The index of the value and status that the input field corresponds to.
         *
         * @return {function} An event handler function to handle unsaved changes.
         */
        function checkChanges(inputElement, promptElement, settingValues, settingStatus, arrayIndex) {
            return (event) => {
                // Change status if a different value is detected
                if (inputElement.val() !== settingValues[arrayIndex]) {
                    if (settingStatus[arrayIndex])
                        settingStatus[arrayIndex] = false;
                }
                else {
                    if (!settingStatus[arrayIndex])
                        settingStatus[arrayIndex] = true;
                }

                // Show the prompt when a setting has been changed
                let isDifferent = false;
                let i = 0;
                while (i < settingStatus.length && !isDifferent) {
                    if (settingStatus[i] == false) {
                        isDifferent = true
                    }
                    i++;
                }

                if (isDifferent) {
                    if (promptElement[0].style.display === "none") {
                        promptElement.slideDown(250, function () {
                            $("#saveButton").prop('disabled', false);
                        });
                    }
                }
                else if (!isDifferent) {
                    if (promptElement[0].style.display !== "none") {
                        $("#saveButton") .prop('disabled', true);
                        promptElement.slideUp(250);
                    }
                }
            }
        }

        /**
         * Get the restaurant user's available tables.
         * ### Must be logged in in order to use!!!
         *
         * @param {JqueryObject} listElement The element which the response will be put into.
         */
        function getAvailableTables(listElement) {
            $.ajax({
                type: "GET",
                url: "/restaurant/getTables",
                data: {},
                success: function (response, status) {
                    listElement.html(response);
                }
            });
        }

        /**
         * Get the reservations for the current logged in restaurant.
         *
         * @param {JqueryObject} containerElement The element to which the response it going to be appended to.
         */
        function getReservations(containerElement) {
            $.ajax({
                type: "GET",
                url: "/restaurant/getReservations",
                data: {},
                success: function (response, status) {
                    if (response != "") {
                        containerElement.html(response);
                    }
                    else containerElement.html("<h2>No reservations has been made!</h2>");
                }
            });
        }
    </script>
@endsection
