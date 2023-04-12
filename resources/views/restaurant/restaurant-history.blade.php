@php
    use App\Http\Controllers\restaurant\RestaurantController;
@endphp

@extends('layouts.restaurant-sidebar')

@section('dependencies')
    <script src="https://unpkg.com/jspdf@latest/dist/jspdf.umd.min.js"></script>
    <script>
        // Apply the jsPDF class from the library to the window
        window.jsPDF = window.jspdf.jsPDF;
    </script>
@endsection

@section('main-content')
    <main class="p-4">
        <h1>Restaurant History</h1>
        <hr style="margin: 6px 0">

        <div class="card w-100 bg-light my-3 text-end">
            <div class="card-body d-flex justify-content-end align-center">
                <span class="align-self-center me-2">Download All History Data:</span>
                <button id="download" class="btn btn-primary">Download</button>
            </div>
        </div>

        <table class="table table-striped">
            <thead class="table-info">
                <tr>
                    <th>No.</th>
                    <th>Reserver</th>
                    <th>Table</th>
                    <th>Reservation Date</th>
                    <th>Reservation Made</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                {{-- The page history will be contained here --}}
            </tbody>
        </table>

        {{-- Pagination Navigation Buttons --}}
        <div class="d-flex justify-content-center align-item-center">
            {{-- <button id="pagination-previous" class="btn btn-secondary"><</button> --}}
            <div id="pagination-container" class="pagination-buttons mx-1">
                {{-- The pagination buttons will be contained here --}}
            </div>
            {{-- <button id="pagination-next" class="btn btn-secondary">></button> --}}
        </div>
    </main>
    <script src="https://unpkg.com/jspdf-autotable"></script>
    <script>
        // Global Variable
        let viewPage = 1;

        /**
         * The main function to call when the HTML has loaded.
         */
        document.addEventListener("DOMContentLoaded", function () {
            // Intialize element variables
            const tableBody = $("#tableBody");
            const paginationContainer = $("#pagination-container");
            // const previousPage = $("#pagination-previous");
            // const nextPage = $("#pagination-next");
            const downloadButton = $("#download");

            // Register Event
            loadPagination(paginationContainer, tableBody, viewPage);
            getReservations(tableBody, viewPage);

            downloadButton.on("click", downloadHistoryData(downloadButton))

            // previousPage.on("click", switchPage(--viewPage, paginationContainer, tableBody))
            // nextPage.on("click", switchPage(++viewPage, paginationContainer, tableBody))
        });

        /**
         * Fetch a fixed amount of reservation details using pagination using AJAX and put them into an element's body.
         *
         * @param {JQueryObject} containerElement The element that will contain the AJAX responds.
         * @param {Integer}      page             The page that is to fetch.
         */
        function getReservations(containerElement, page) {
            $.ajax({
                type: "GET",
                url: "/restaurant/getReservationHistory",
                data: {
                    page: page
                },
                success: function (response) {
                    viewPage = page; // Set the current page to the
                    if (response != "") {
                        containerElement.html(response);
                    }
                    else containerElement.html("<tr><td colspan='6'><h1>No reservations has been made</h1></td></tr>");
                }
            });
        }

        /**
         * Load the pagination of the history page according to what pagae the current page is in.
         *
         * @param {JqueryObject} containerElement    The element which will contain the page.
         * @param {JqueryObject} paginationContainer The object of which the result of the AJAX is printed to.
         * @param {Integer}      currentPage         The number of the page this view is currently on.
         */
        function loadPagination(paginationContainer, containerElement, currentPage) {
            $.ajax({
                type: "GET",
                url: "/restaurant/getReservationPagination",
                data: {
                    page: currentPage
                },
                success: function (response) {
                    paginationContainer.html(response);
                    paginationContainer.find("button.btn").each(function (index) {
                        $(this).on('click', switchPage(Number($(this).attr("page")), paginationContainer, containerElement));
                    });
                }
            });
        }

        /**
         * Switch page of the reservation history based on what button is being clicked.
         *
         * @param {Integer}      targetPage          The element that fires the event.
         * @param {JqueryObject} paginationContainer The element that contains the pagination buttons.
         * @param {JqueryObject} containerElement    The element that is going to contain the switch result.
         */
        function switchPage(targetPage, paginationContainer, containerElement) {
            return (event) => {
                getReservations(containerElement, targetPage);
                loadPagination(paginationContainer, containerElement, targetPage)
                viewPage = targetPage;
            }
        }

        /**
         * Downloads all restaurant reservation history data and create a pdf which the user can automatically download.
         *
         * Uses the jsPDF library to generate the pdf.
         *
         * @param {JqueryObject} clickedElement The element that fires the event to provide feedback, avoiding spam when generating.
         */
        function downloadHistoryData(clickedElement) {
            return (event) => {
                clickedElement.html("Generating...");
                clickedElement.attr("disabled", true);

                // Default export is a4 paper, portrait, using millimeters for units
                $.ajax({
                    url: "/restaurant/getAllRestaurantHistory",
                    type: "GET",
                    data: {},
                    success: function (response) {
                        // Create the pdf file object
                        const newDocument = new jsPDF();

                        // Constant variables for the document layout
                        const HEADER_HEIGHT = 25;
                        const BODY_PADDING = 13;
                        const LINE_HEIGHT = 4;
                        const CHARACTER_WIDTH = 3;
                        const PAPER_WIDTH = newDocument.internal.pageSize.getWidth();
                        const PAPER_HEIGHT = newDocument.internal.pageSize.getHeight();
                        const ALIGN_RIGHT = PAPER_WIDTH - BODY_PADDING;
                        const CURRENT_DATE = new Date()

                        // Variable to track the content height
                        let contentHeight = BODY_PADDING;
                        let restaurantName = "{{ $restaurant->full_name }}";
                        let currentDateString = `${CURRENT_DATE.getDate()}-${CURRENT_DATE.getMonth() + 1}-${CURRENT_DATE.getFullYear()}`;

                        // Create the heading for the document
                        newDocument.setFontSize(24);
                        newDocument.text(restaurantName, BODY_PADDING, contentHeight);
                        newDocument.text(currentDateString, ALIGN_RIGHT - currentDateString.length * (CHARACTER_WIDTH + 1.5), contentHeight);
                        contentHeight += 15;

                        newDocument.setFontSize(16);
                        newDocument.text("Reservation History:", BODY_PADDING, contentHeight);
                        contentHeight += 5;

                        // Adding the history data to the PDF
                        try {
                            newDocument.autoTable({
                                body: response,
                                startY: contentHeight,
                                head:[["id", "reserver", "seats", "reservation_date", "created", "status"]],
                                columnStyles: {
                                    0: {halign: 'right', cellWidth: 12},
                                    1: {halign: 'left', cellWidth: 60},
                                    2: {halign: 'right', cellWidth: 15},
                                    3: {halign: 'right', cellWidth: 36},
                                    4: {halign: 'right', cellWidth: 36},
                                    5: {halign: 'right'}
                                },
                                styles: { fontSize: 10 }
                            });
                        }
                        catch (err) {
                            console.error(err);
                        }

                        // Increase the content height based on the amount of data shown in the table
                        contentHeight += (LINE_HEIGHT * response.length + LINE_HEIGHT * 2)

                        // Save the document and print/save it
                        newDocument.save();

                        clickedElement.html("Download");
                        clickedElement.attr("disabled", false);
                    },
                    error: function (err) {
                        console.error(err);

                        clickedElement.html("Error...");
                    }
                });
            }
        }
    </script>
@endsection
