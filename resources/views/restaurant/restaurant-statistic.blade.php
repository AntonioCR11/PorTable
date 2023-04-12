@extends('layouts.restaurant-sidebar')

@section("dependencies")
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <script src="https://unpkg.com/jspdf@latest/dist/jspdf.umd.min.js"></script>
    <script>
        window.jsPDF = window.jspdf.jsPDF
    </script>
@endsection

@section("custom-css-extended")
    <style>
        .toggle-container {
            border-radius: 6px;
            border: 1px solid black;
        }
        .toggle-card {
            background-color: inherit;
            border: 0 solid black;

        }
        .toggle-card.active {
            background-color: rgb(240, 240, 240);
        }

        .year-input {
            width: 7em;
            max-width: 7em;
        }
    </style>
@endsection

@section('main-content')
    <main class="p-4">
        <div class="container">
            <div class="card">
                <div class="card-body d-flex justify-content-end">
                    <span class="align-self-center me-2">Download statistic data:</span>
                    <button class="btn btn-primary" id="download">Download</button>
                </div>
            </div>
            <div class="d-flex mb-5">
                {{-- Card to represent total revenue --}}
                <div class="col">
                    <div class="card p-4 m-3 mb-lg-0">
                        <div class="d-flex align-items-center">
                            <img class="bg-light rounded-3 p-2 me-3" src="{{asset("/storage/images/admin/sale.png")}}" alt="" width="60px">
                            <div class="">
                                <p class="m-0"><b>Total Sales</b></p>
                                <p class="m-0 overview_sub">{{date("F")}} {{date("jS")}}</p>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end w-100">
                            <h1 id="revenue-placeholder" class="font-weight-bold">Fetching...</h1>
                        </div>
                    </div>
                </div>
                {{-- Card to represent total orders --}}
                <div class="col">
                    <div class="card p-4 m-3 mb-lg-0">
                        <div class="d-flex align-items-center">
                            <img class="bg-light rounded-3 p-2 me-3" src="{{asset("/storage/images/admin/order.png")}}" alt="" width="60px">
                            <div class="">
                                <p class="m-0"><b>Total Orders</b></p>
                                <p class="m-0 overview_sub">{{date("F")}} {{date("jS")}}</p>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end w-100">
                            <h1 id="order-placeholder" class="font-weight-bold">Fetching...</h1>
                        </div>
                    </div>
                </div>
                {{-- Card to represent total growth --}}
                <div class="col">
                    <div class="card p-4 m-3 mb-lg-0">
                        <div class="d-flex align-items-center">
                            <img class="bg-light rounded-3 p-2 me-3" src="{{asset("/storage/images/admin/growth.png")}}" alt="" width="60px">
                            <div class="">
                                <p class="m-0"><b>Audience Growth</b></p>
                                <p class="m-0 overview_sub">{{date("F")}} {{date("jS")}}</p>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end w-100">
                            <h1 id="growth-placeholder" class="font-weight-bold">Fetching...</h1>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card p-3">
                <div class="d-flex">
                    <h2 class="flex-fill">Total revenue graph</h2>
                    <div class="input-group" style="width: fit-content">
                        <span class="input-group-text">Year:</span>
                        <input type="number" class="form-control year-input" min="2000" max="9999" name="yearInput" id="year-input" placeholder="2020">
                    </div>
                </div>
                <hr class="my-2">
                <canvas id="revenue-graph" class="w-100"></canvas>
            </div>
        </div>
    </main>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.js" integrity="sha512-NmIoYvVsh1mGumphmTK9rc11ia21MZKRPsQV8RUn0x+sN6rxcBtST1Y5fw4WSiAzlryxCtPy00QoPfadNaq6gQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        // Global Variable
        const MONTHLY_FILTER = 1;
        const YEARLY_FILTER = 2;

        /**
         * Start the script as soon as the HTML DOM loads. Acts as the main function.
         */
        document.addEventListener("DOMContentLoaded", function () {
            // Initialize Document Element
            const revenuePlaceholder = $("#revenue-placeholder");
            const orderPlaceholder = $("#order-placeholder");
            const growthPlaceholder = $("#growth-placeholder");
            const yearInput = $("#year-input");
            const downloadButton = $("#download");

            // Initialize Variables
            let xValues = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            let yValues = [];

            yearInput.val(new Date().getFullYear());

            // Register Events
            // Assign event handler
            yearInput.on("change", changeGraphYear(yearInput, xValues));
            downloadButton.on("click", downloadStatisticData(downloadButton, yearInput));

            // Fire events
            loadGraph(xValues, yValues); // Load the graph as soon as the page loads
            getYearRevenueData(new Date().getFullYear(), xValues);
            getTotalRevenue(revenuePlaceholder);
            getTotalOrder(orderPlaceholder);
            getAudienceGrowth(growthPlaceholder);
        });

        /**
         * Load the graph with the X-axis values and Y-axis values.
         *
         * @param {Array} xValues An array containing the labels of the columns.
         * @param {Array} yValues An array containing the labels of the rows.
         */
        function loadGraph(xValues, yValues) {
            let myChart = new Chart("revenue-graph", {
                type: "bar",
                data: {
                    labels: xValues,
                    datasets: [{
                        label: 'Revenue per Month',
                        borderWidth: 1,
                        tension: 0.2,
                        backgroundColor: "rgb(6, 199, 0, 1.0)",
                        borderColor: "rgb(6, 199, 0, 1.0)",
                        data: yValues
                    }],
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                },
            });
        }

        /**
         * Retrieve the data of revenue from the targeted year, and show it into the graph.
         *
         * @param {Integer} year    The year which the data is going to be retrieved.
         * @param {Arrayy}  xValues The label for each column that represents the months.
         */
        function getYearRevenueData(year, xValues) {
            $.ajax({
                type: "get",
                url: "/restaurant/revenue",
                data: {
                    year: year
                },
                success: function (response) {
                    loadGraph(xValues, response);
                }
            });
        }

        /**
         * Fetch the total revenue of the current authenticated restaurat.
         *
         * @param (JqueryObject) placeholder The element to put the response into.
         */
        function getTotalRevenue(placeholder) {
            $.ajax({
                type: "get",
                url: "/restaurant/totalRevenue",
                data: {},
                success: function (response) {
                    placeholder.html(`Rp. ${new Intl.NumberFormat('id-ID').format(response)}`)
                }
            });
        }

        /**
         * Fetch the total order that has been made to the restaurant.
         *
         * @param (JqueryObject) placeholder The element to put the response into.
         */
        function getTotalOrder(placeholder) {
            $.ajax({
                type: "get",
                url: "/restaurant/totalOrder",
                data: {},
                success: function (response) {
                    placeholder.html(response)
                }
            });
        }

        /**
         * Fetch the total order that has been made to the restaurant.
         *
         * @param (JqueryObject) placeholder The element to put the response into.
         */
        function getAudienceGrowth(placeholder) {
            $.ajax({
                type: "get",
                url: "/restaurant/audienceGrowth",
                data: {},
                success: function (response) {
                    placeholder.html(response)
                }
            });
        }

        /**
         * Change the graph's data based on the element's year value.
         *
         * @param {JqueryObject} changedElement The element which fires the event.
         * @param {Array}        xValues        The array which has the labels for the graphs.
         */
        function changeGraphYear(changedElement, xValues) {
            return (event) => {
                const year = Number(changedElement.val());
                if (year > 1999 && year < 10000) {
                    getYearRevenueData(year, xValues);
                }
            }
        }

        /**
         * Downloads all restaurant reservation history data and create a pdf which the user can automatically download.
         *
         * Uses the jsPDF library to generate the pdf.
         *
         * @param {JqueryObject} clickedElement The element that fires the event to provide feedback, avoiding spam when generating.
         * @param {JqueryObject} yearInput      The element which contains the target year value.
         */
         function downloadStatisticData(clickedElement, yearInput) {
            return (event) => {
                clickedElement.html("Generating...");
                clickedElement.attr("disabled", true);

                // Varibles of the required values
                let sales = null;
                let growth = null;
                let orders = null;
                let revenuePerMonth = null;
                let failedMessage = null;

                // Fetch the total revenue of the restaurant
                $.ajax({
                    type: "get",
                    url: "/restaurant/totalRevenue",
                    data: {},
                    success: function (response) {
                        sales = response;
                    },
                    error: function (err) {
                        failedMessage ??= err;
                    }
                });
                // Fetch the total order of the restaurant
                $.ajax({
                    type: "get",
                    url: "/restaurant/totalOrder",
                    data: {},
                    success: function (response) {
                        orders = response;
                    },
                    error: function (err) {
                        failedMessage ??= err;
                    }
                });
                // Fetch the total growth of the restaurant
                $.ajax({
                    type: "get",
                    url: "/restaurant/audienceGrowth",
                    data: {},
                    success: function (response) {
                        growth = response;
                    },
                    error: function (err) {
                        failedMessage ??= err;
                    }
                });
                // Fetch the revenue per month of the restaurant
                $.ajax({
                    type: "get",
                    url: "/restaurant/revenue",
                    data: {
                        year: Number(yearInput.val())
                    },
                    success: function (response) {
                        revenuePerMonth = response;
                    },
                    error: function (err) {
                        failedMessage ??= err;
                    }
                });

                // Validate all the data before printing the document
                let passedTime = 0;
                const timer = setInterval(() => {
                    // Check whether the timer has timeout'd.
                    if (passedTime < 5) {
                        passedTime++;
                    }
                    else if (failedMessage != null) {
                        clearInterval(timer)
                        alert(failedMessage);
                    }
                    else {
                        clearInterval(timer)
                        alert("Timeout while generating PDF! (Unknown Error)");

                        // Make the download button clickable again after the timeout
                        clickedElement.html("Download");
                        clickedElement.attr("disabled", false);

                        return;
                    }

                    // Validate the data, if all data is validated, print the pdf
                    if (validateStatisticData(sales, orders, growth, revenuePerMonth)) {
                        clearInterval(timer); // Stop the timer

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
                        newDocument.text("Reservation Statistics:", BODY_PADDING, contentHeight);
                        contentHeight += 5;

                        newDocument.autoTable({
                            body: [[
                                `Rp. ${new Intl.NumberFormat('id-ID').format(sales)}`,
                                orders,
                                growth,
                            ]],
                            startY: contentHeight,
                            head: [["sales", "orders", "growth"]],
                            styles: {
                                fontSize: 12
                            }
                        });
                        contentHeight += 25;

                        newDocument.setFontSize(16);
                        newDocument.text(`Revenue Per Month as of ${yearInput.val()}: `, BODY_PADDING, contentHeight);
                        contentHeight += 4;

                        // Combine data
                        const months = ["January", "February", "March", "April", "Mei", "June", "July", "August", "September", "October", "November", "December"];
                        const data = []
                        for (let i = 0; i < months.length; i++) {
                            data.push([months[i], `Rp. ${Intl.NumberFormat('id-ID').format(revenuePerMonth[i])}`]);
                        }

                        newDocument.autoTable({
                            body: data,
                            startY: contentHeight,
                            head: [["month", "revenue"]],
                            styles: {
                                fontSize: 12
                            }
                        });
                        contentHeight += 15;

                        // Increase the content height based on the amount of data shown in the table
                        // contentHeight += (LINE_HEIGHT * response.length + LINE_HEIGHT * 2)

                        // Save the document and print/save it
                        newDocument.save();

                        clickedElement.html("Download");
                        clickedElement.attr("disabled", false);
                    }
                }, 1000)
            }
        }

        /**
         * Checks the values given in the arguments whether they have been filled or not.
         * If any one of the data is empty, then the validation returns false.
         */
        function validateStatisticData(sales, orders, growth, revenuePerMonth) {
            if (sales !== null && growth !== null && orders !== null && revenuePerMonth !== null) {
                return true;
            }
            else return false;
        }
    </script>
@endsection
