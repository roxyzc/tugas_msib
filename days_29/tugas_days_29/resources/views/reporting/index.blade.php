@extends('layouts.app')

@section('title', 'Reporting')

@section('content')
    <div class="container mt-5">
        <h2 class="text-center">Reporting</h2>
        <div class="form-group">
            <label for="dates">Select Date Range:</label>
            <input name="dates" class="form-control" />
        </div>
        <div class="form-group">
            <label for="products">Select Products:</label>
            <select class="js-example-basic-single form-control" name="states" multiple="multiple">
                @foreach ($categories as $category)
                    <option value="{{ $category->category }}">{{ $category->category }}</option>
                @endforeach
            </select>
        </div>

        <div class="container my-4 d-flex flex-column align-items-center">
            <div id="output" class="mb-4"></div>
        
            <div id="product_price_range" class="mb-4 w-100">
                <div class="text-center">
                    <h5>Price Range Distribution</h5>
                </div>
                <div class="d-flex justify-content-center">
                    <canvas class="canvasChartProduct" style="max-width: 100%;"></canvas>
                </div>
            </div>
        </div>

        <div class="summary card">
            <div class="card-header">
                <h3>Executive Summary</h3>
            </div>
            <div class="card-body">
                <p>Total Products: <span id="total-products"></span></p>
                <p>Price Range Distribution:</p>
                <ul class="list-group">
                    <li class="list-group-item"> < 50,000: <span id="less-50000"></span></li>
                    <li class="list-group-item">50,000 - 99,999: <span id="50000-99999"></span></li>
                    <li class="list-group-item">100,000 - 999,999: <span id="100000-999999"></span></li>
                    <li class="list-group-item">>= 1,000,000: <span id="more-1000000"></span></li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="text/javascript" src="https://pivottable.js.org/dist/pivot.js"></script>
    <script>
       let productChart = null;
       $(document).ready(function() {
            $('input[name="dates"]').daterangepicker({
                locale: {
                    format: 'YYYY-MM-DD'
                }
            });

            $('.js-example-basic-single').select2();

            $('input[name="dates"], .js-example-basic-single').on('change', function() {
                let dateRange = $('input[name="dates"]').val();
                let selectedCategories = $('.js-example-basic-single').val();

                console.log(selectedCategories);
                $.ajax({
                    url: 'reporting/all-data-product',
                    data: {
                        dates: dateRange,
                        categories: selectedCategories
                    },
                    success: function(response) {
                        $("#output").pivot(
                        response,
                            {
                                rows: ["created_range"],
                                cols: ["price_range"],
                            }
                        );

                        let totalProducts = response.length;
                        $('#total-products').text(totalProducts);

                        let priceRanges = { less_50000: 0, _50000_99999: 0, _100000_999999: 0, more_1000000: 0 };
                        response.forEach(product => {
                            priceRanges[product.price_range]++;
                        });

                        $('#less-50000').text(priceRanges.less_50000);
                        $('#50000-99999').text(priceRanges._50000_99999);
                        $('#100000-999999').text(priceRanges._100000_999999);
                        $('#more-1000000').text(priceRanges.more_1000000);

                        console.log(productChart)
                        if (productChart) {
                            const data = [
                                priceRanges.less_50000, 
                                priceRanges._50000_99999, 
                                priceRanges._100000_999999, 
                                priceRanges.more_1000000
                            ];
                            
                            productChart.data.datasets[0].data = data;
                            productChart.update();
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                    }
                });
            });

            $.ajax({
                url: 'reporting/all-data-product',
                success: function(response){
                    $("#output").pivot(
                    response,
                        {
                            rows: ["created_range"],
                            cols: ["price_range"],
                        }
                    );

                    let totalProducts = response.length;
                    $('#total-products').text(totalProducts);

                    let priceRanges = { less_50000: 0, _50000_99999: 0, _100000_999999: 0, more_1000000: 0 };
                    response.forEach(product => {
                        priceRanges[product.price_range]++;
                    });

                    $('#less-50000').text(priceRanges.less_50000);
                    $('#50000-99999').text(priceRanges._50000_99999);
                    $('#100000-999999').text(priceRanges._100000_999999);
                    $('#more-1000000').text(priceRanges.more_1000000);
                }
            });

            let productPriceRange = {
                _defaults: {
                    type: 'doughnut',
                    tooltipFillColor: "rgba(51, 51, 51, 0.55)",
                    data: {
                        labels: [
                            '< 50000',
                            '50000 - 99999',
                            '100000 - 999999',
                            '>= 1000000'
                        ],
                        datasets: [{
                            data: [],
                            backgroundColor: [
                                "#3498DB",
                                "#3498DB",
                                "#9B59B6",
                                "#E74C3C",
                            ],
                            hoverBackgroundColor: [
                                "#36CAAB",
                                "#49A9EA",
                                "#B370CF",
                                "#E95E4F",
                            ]
                        }]
                    },
                    options: {
                        legend: false,
                        responsive: false
                    }
                },
                init: function ($el) {
                    var self = this;
                    $el = $($el);

                    $.ajax({
                        url: 'reporting/chart-product',
                        success: function (response) {
                            let dataAvailable = response.less_50000 || response._50000_99999 || response._100000_999999 || response.more_1000000;
                
                            if (dataAvailable) {
                                self._defaults.data.datasets[0].data = [
                                    response.less_50000, 
                                    response._50000_99999, 
                                    response._100000_999999, 
                                    response.more_1000000
                                ];
                                productChart = new Chart($el.find('.canvasChartProduct'), self._defaults);
                            } else {
                                $el.html("<p class='alert alert-danger'>Data tidak ada</p>");
                            }
                        }
                    });
                }
            };

            productPriceRange.init($('#product_price_range'));
        });
    </script>
@endsection

@section('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://pivottable.js.org/dist/pivot.css">
@endsection
