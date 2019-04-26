<div class="container">
    <div class="row">







        <div class="col-12 col-md-12 col-lg-9 col-xl-12 pl-lg-12">

            <div class="row">
                <div class="col-12 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Line Chart</h5>
                            <h6 class="card-subtitle text-muted">Line charts are a typical pictorial representation that depicts trends and behaviors over time.</h6>
                        </div>
                        <div class="card-body">
                            <div class="chart">
                                <div id="apexcharts-line"></div>
                            </div>
                        </div>
                    </div>

                    <script>
                        document.addEventListener("DOMContentLoaded", function(event) {
                            // Line chart
                            var options = {
                                chart: {
                                    height: 350,
                                    type: "line",
                                    zoom: {
                                        enabled: false
                                    },
                                },
                                dataLabels: {
                                    enabled: false
                                },
                                stroke: {
                                    width: [5, 7, 5],
                                    curve: "straight",
                                    dashArray: [0, 8, 5]
                                },
                                series: [{
                                    name: "Essence",
                                    data: [45, 52, 38, 24, 33, 26, 21, 20, 6, 8, 15, 10]
                                },
                                    {
                                        name: "Gasoil",
                                        data: [35, 41, 62, 42, 13, 18, 29, 37, 36, 51, 32, 35]
                                    },
                                    {
                                        name: "Petrole",
                                        data: [87, 57, 74, 99, 75, 38, 62, 47, 82, 56, 45, 47]
                                    }
                                ],
                                markers: {
                                    size: 0,
                                    style: "hollow", // full, hollow, inverted
                                },
                                xaxis: {
                                    categories: ["01 Jan", "02 Jan", "03 Jan", "04 Jan", "05 Jan", "06 Jan", "07 Jan", "08 Jan", "09 Jan", "10 Jan", "11 Jan", "12 Jan"],
                                },
                                tooltip: {
                                    y: [{
                                        title: {
                                            formatter: function(val) {
                                                return val + " (mins)"
                                            }
                                        }
                                    }, {
                                        title: {
                                            formatter: function(val) {
                                                return val + " par saison"
                                            }
                                        }
                                    }, {
                                        title: {
                                            formatter: function(val) {
                                                return val;
                                            }
                                        }
                                    }]
                                },
                                grid: {
                                    borderColor: "#f1f1f1",
                                }
                            }
                            var chart = new ApexCharts(
                                document.querySelector("#apexcharts-line"),
                                options
                            );
                            chart.render();
                        });
                    </script>
                </div>

                <div class="col-12 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Service en 24h</h5>
                            <h6 class="card-subtitle text-muted">Changement d`etat par heure.</h6>
                        </div>
                        <div class="card-body">
                            <div class="chart">
                                <div id="apexcharts-area"></div>
                            </div>
                        </div>
                    </div>

                    <script>
                        document.addEventListener("DOMContentLoaded", function(event) {
                            // Area chart
                            var options = {
                                chart: {
                                    height: 350,
                                    type: "area",
                                },
                                dataLabels: {
                                    enabled: false
                                },
                                stroke: {
                                    curve: "smooth"
                                },
                                series: [{
                                    name: "Essence",
                                    data: [31, 40, 28, 51, 42, 109, 100]
                                }, {
                                    name: "Gasoil",
                                    data: [11, 32, 45, 32, 34, 52, 41]
                                },{
                                    name: "Petrole",
                                    data: [14, 19, 26, 31, 26, 67, 87]
                                }],
                                xaxis: {
                                    type: "datetime",
                                    categories: ["2018-09-19T00:00:00", "2018-09-19T01:30:00", "2018-09-19T02:30:00", "2018-09-19T03:30:00", "2018-09-19T04:30:00",
                                        "2018-09-19T05:30:00", "2018-09-19T06:30:00"
                                    ],
                                },
                                tooltip: {
                                    x: {
                                        format: "dd/MM/yy HH:mm"
                                    },
                                }
                            }
                            var chart = new ApexCharts(
                                document.querySelector("#apexcharts-area"),
                                options
                            );
                            chart.render();
                        });
                    </script>
                </div>

                <div class="col-12 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Bar Chart</h5>
                            <h6 class="card-subtitle text-muted">A bar chart is the best tool for displaying comparisons between categories of data.</h6>
                        </div>
                        <div class="card-body">
                            <div class="chart">
                                <div id="apexcharts-bar"></div>
                            </div>
                        </div>
                    </div>

                    <script>
                        document.addEventListener("DOMContentLoaded", function(event) {
                            // Bar chart
                            var options = {
                                chart: {
                                    height: 350,
                                    type: "bar",
                                    stacked: true,
                                },
                                plotOptions: {
                                    bar: {
                                        horizontal: true,
                                    },
                                },
                                stroke: {
                                    width: 1,
                                    colors: ["#fff"]
                                },
                                series: [{
                                    name: "Marine Sprite",
                                    data: [44, 55, 41, 37, 22, 43, 21]
                                }, {
                                    name: "Striking Calf",
                                    data: [53, 32, 33, 52, 13, 43, 32]
                                }, {
                                    name: "Tank Picture",
                                    data: [12, 17, 11, 9, 15, 11, 20]
                                }, {
                                    name: "Bucket Slope",
                                    data: [9, 7, 5, 8, 6, 9, 4]
                                }, {
                                    name: "Reborn Kid",
                                    data: [25, 12, 19, 32, 25, 24, 10]
                                }],
                                xaxis: {
                                    categories: [2008, 2009, 2010, 2011, 2012, 2013, 2014],
                                    labels: {
                                        formatter: function(val) {
                                            return val + "K"
                                        }
                                    }
                                },
                                yaxis: {
                                    title: {
                                        text: undefined
                                    },
                                },
                                tooltip: {
                                    y: {
                                        formatter: function(val) {
                                            return val + "K"
                                        }
                                    }
                                },
                                fill: {
                                    opacity: 1
                                },
                                legend: {
                                    position: "top",
                                    horizontalAlign: "left",
                                    offsetX: 40
                                }
                            }
                            var chart = new ApexCharts(
                                document.querySelector("#apexcharts-bar"),
                                options
                            );
                            chart.render();
                        });
                    </script>
                </div>

                <div class="col-12 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Column Chart</h5>
                            <h6 class="card-subtitle text-muted">A column chart uses vertical bars to display data and is used to compare values across categories.</h6>
                        </div>
                        <div class="card-body">
                            <div class="chart">
                                <div id="apexcharts-column"></div>
                            </div>
                        </div>
                    </div>

                    <script>
                        document.addEventListener("DOMContentLoaded", function(event) {
                            // Column chart
                            var options = {
                                chart: {
                                    height: 350,
                                    type: "bar",
                                },
                                plotOptions: {
                                    bar: {
                                        horizontal: false,
                                        endingShape: "rounded",
                                        columnWidth: "55%",
                                    },
                                },
                                dataLabels: {
                                    enabled: false
                                },
                                stroke: {
                                    show: true,
                                    width: 2,
                                    colors: ["transparent"]
                                },
                                series: [{
                                    name: "Net Profit",
                                    data: [44, 55, 57, 56, 61, 58, 63, 60, 66]
                                }, {
                                    name: "Revenue",
                                    data: [76, 85, 101, 98, 87, 105, 91, 114, 94]
                                }, {
                                    name: "Free Cash Flow",
                                    data: [35, 41, 36, 26, 45, 48, 52, 53, 41]
                                }],
                                xaxis: {
                                    categories: ["Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct"],
                                },
                                yaxis: {
                                    title: {
                                        text: "$ (thousands)"
                                    }
                                },
                                fill: {
                                    opacity: 1
                                },
                                tooltip: {
                                    y: {
                                        formatter: function(val) {
                                            return "$ " + val + " thousands"
                                        }
                                    }
                                }
                            }
                            var chart = new ApexCharts(
                                document.querySelector("#apexcharts-column"),
                                options
                            );
                            chart.render();
                        });
                    </script>
                </div>

                <div class="col-12 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Carburant restant</h5>
                            <h6 class="card-subtitle text-muted">Ici nous avions la liste de produits restants dans nos réserves</h6>
                        </div>
                        <div class="card-body text-center">
                            <div class="chart">
                                <div id="apexcharts-pie" style="max-width: 440px;margin:auto;"></div>
                            </div>
                        </div>
                    </div>

                    <script>
                        document.addEventListener("DOMContentLoaded", function(event) {
                            // Pie chart
                            var options = {
                                chart: {
                                    height: 350,
                                    type: "donut",
                                },
                                dataLabels: {
                                    enabled: true
                                },
                                //series: [44, 55, 13, 33]
                                series: [<?php echo $essence->quantity.','.$gasoil->quantity.','.$kerosene->quantity.','.$petrole->quantity;?>],


                            }
                            var chart = new ApexCharts(
                                document.querySelector("#apexcharts-pie"),
                                options
                            );
                            chart.render();
                        });
                    </script>
                </div>

                <div class="col-12 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Heatmap Chart</h5>
                            <h6 class="card-subtitle text-muted">Heatmap is a visualization tool that employs color the way a bar chart employs height and width in representing data.</h6>
                        </div>
                        <div class="card-body">
                            <div class="chart">
                                <div id="apexcharts-heatmap"></div>
                            </div>
                        </div>
                    </div>

                    <script>
                        document.addEventListener("DOMContentLoaded", function(event) {
                            // Heatmap chart
                            function generateData(count, yrange) {
                                var i = 0;
                                var series = [];
                                while (i < count) {
                                    var x = (i + 1).toString();
                                    var y = Math.floor(Math.random() * (yrange.max - yrange.min + 1)) + yrange.min;
                                    series.push({
                                        x: x,
                                        y: y
                                    });
                                    i++;
                                }
                                return series;
                            }
                            var options = {
                                chart: {
                                    height: 350,
                                    type: "heatmap",
                                },
                                dataLabels: {
                                    enabled: false
                                },
                                colors: ["#008FFB"],
                                series: [{
                                    name: "Metric1",
                                    data: generateData(20, {
                                        min: 0,
                                        max: 90
                                    })
                                },
                                    {
                                        name: "Metric2",
                                        data: generateData(20, {
                                            min: 0,
                                            max: 90
                                        })
                                    },
                                    {
                                        name: "Metric3",
                                        data: generateData(20, {
                                            min: 0,
                                            max: 90
                                        })
                                    },
                                    {
                                        name: "Metric4",
                                        data: generateData(20, {
                                            min: 0,
                                            max: 90
                                        })
                                    },
                                    {
                                        name: "Metric5",
                                        data: generateData(20, {
                                            min: 0,
                                            max: 90
                                        })
                                    },
                                    {
                                        name: "Metric6",
                                        data: generateData(20, {
                                            min: 0,
                                            max: 90
                                        })
                                    },
                                    {
                                        name: "Metric7",
                                        data: generateData(20, {
                                            min: 0,
                                            max: 90
                                        })
                                    },
                                    {
                                        name: "Metric8",
                                        data: generateData(20, {
                                            min: 0,
                                            max: 90
                                        })
                                    },
                                    {
                                        name: "Metric9",
                                        data: generateData(20, {
                                            min: 0,
                                            max: 90
                                        })
                                    }
                                ],
                                xaxis: {
                                    type: "category",
                                }
                            }
                            var chart = new ApexCharts(
                                document.querySelector("#apexcharts-heatmap"),
                                options
                            );
                            chart.render();
                        });
                    </script>
                </div>

                <div class="col-12 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Mixed Chart</h5>
                            <h6 class="card-subtitle text-muted">A Mixed Chart is a visualization that allows the combination of two or more distinct graphs.</h6>
                        </div>
                        <div class="card-body">
                            <div class="chart">
                                <div id="apexcharts-mixed"></div>
                            </div>
                        </div>
                    </div>

                    <script>
                        document.addEventListener("DOMContentLoaded", function(event) {
                            // Mixed chart
                            var options = {
                                chart: {
                                    height: 350,
                                    type: "line",
                                    stacked: false,
                                },
                                stroke: {
                                    width: [0, 2, 5],
                                    curve: "smooth"
                                },
                                plotOptions: {
                                    bar: {
                                        columnWidth: "50%"
                                    }
                                },
                                series: [{
                                    name: "TEAM A",
                                    type: "column",
                                    data: [23, 11, 22, 27, 13, 22, 37, 21, 44, 22, 30]
                                }, {
                                    name: "TEAM B",
                                    type: "area",
                                    data: [44, 55, 41, 67, 22, 43, 21, 41, 56, 27, 43]
                                }, {
                                    name: "TEAM C",
                                    type: "line",
                                    data: [30, 25, 36, 30, 45, 35, 64, 52, 59, 36, 39]
                                }],
                                fill: {
                                    opacity: [0.85, 0.25, 1],
                                    gradient: {
                                        inverseColors: false,
                                        shade: "light",
                                        type: "vertical",
                                        opacityFrom: 0.85,
                                        opacityTo: 0.55,
                                        stops: [0, 100, 100, 100]
                                    }
                                },
                                labels: ["01/01/2003", "02/01/2003", "03/01/2003", "04/01/2003", "05/01/2003", "06/01/2003", "07/01/2003", "08/01/2003", "09/01/2003",
                                    "10/01/2003", "11/01/2003"
                                ],
                                markers: {
                                    size: 0
                                },
                                xaxis: {
                                    type: "datetime"
                                },
                                yaxis: {
                                    title: {
                                        text: "Points",
                                    },
                                    min: 0
                                },
                                tooltip: {
                                    shared: true,
                                    intersect: false,
                                    y: {
                                        formatter: function(y) {
                                            if (typeof y !== "undefined") {
                                                return y.toFixed(0) + " points";
                                            }
                                            return y;
                                        }
                                    }
                                }
                            }
                            var chart = new ApexCharts(
                                document.querySelector("#apexcharts-mixed"),
                                options
                            );
                            chart.render();
                        });
                    </script>
                </div>

                <div class="col-12 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Candlestick Chart</h5>
                            <h6 class="card-subtitle text-muted">A candlestick chart is a style of financial chart used to describe price movements.</h6>
                        </div>
                        <div class="card-body">
                            <div class="chart">
                                <div id="apexcharts-candlestick"></div>
                            </div>
                        </div>
                    </div>

                    <script>
                        document.addEventListener("DOMContentLoaded", function(event) {
                            // Candlestick chart
                            var seriesData = [{
                                x: new Date(2016, 01, 01),
                                y: [51.98, 56.29, 51.59, 53.85]
                            },
                                {
                                    x: new Date(2016, 02, 01),
                                    y: [53.66, 54.99, 51.35, 52.95]
                                },
                                {
                                    x: new Date(2016, 03, 01),
                                    y: [52.96, 53.78, 51.54, 52.48]
                                },
                                {
                                    x: new Date(2016, 04, 01),
                                    y: [52.54, 52.79, 47.88, 49.24]
                                },
                                {
                                    x: new Date(2016, 05, 01),
                                    y: [49.10, 52.86, 47.70, 52.78]
                                },
                                {
                                    x: new Date(2016, 06, 01),
                                    y: [52.83, 53.48, 50.32, 52.29]
                                },
                                {
                                    x: new Date(2016, 07, 01),
                                    y: [52.20, 54.48, 51.64, 52.58]
                                },
                                {
                                    x: new Date(2016, 08, 01),
                            y: [52.76, 57.35, 52.15, 57.03]
                        },
                            {
                                x: new Date(2016, 09, 01),
                                y: [57.04, 58.15, 48.88, 56.19]
                            },
                            {
                                x: new Date(2016, 10, 01),
                                    y: [56.09, 58.85, 55.48, 58.79]
                            },
                            {
                                x: new Date(2016, 11, 01),
                                    y: [58.78, 59.65, 58.23, 59.05]
                            },
                            {
                                x: new Date(2017, 00, 01),
                                    y: [59.37, 61.11, 59.35, 60.34]
                            },
                            {
                                x: new Date(2017, 01, 01),
                                    y: [60.40, 60.52, 56.71, 56.93]
                            },
                            {
                                x: new Date(2017, 02, 01),
                                    y: [57.02, 59.71, 56.04, 56.82]
                            },
                            {
                                x: new Date(2017, 03, 01),
                                    y: [56.97, 59.62, 54.77, 59.30]
                            },
                            {
                                x: new Date(2017, 04, 01),
                                    y: [59.11, 62.29, 59.10, 59.85]
                            },
                            {
                                x: new Date(2017, 05, 01),
                                    y: [59.97, 60.11, 55.66, 58.42]
                            },
                            {
                                x: new Date(2017, 06, 01),
                                    y: [58.34, 60.93, 56.75, 57.42]
                            },
                            {
                                x: new Date(2017, 07, 01),
                                    y: [57.76, 58.08, 51.18, 54.71]
                            },
                            {
                                x: new Date(2017, 08, 01),
                                y: [54.80, 61.42, 53.18, 57.35]
                            },
                            {
                                x: new Date(2017, 09, 01),
                                y: [57.56, 63.09, 57.00, 62.99]
                            },
                            {
                                x: new Date(2017, 10, 01),
                                    y: [62.89, 63.42, 59.72, 61.76]
                            },
                            {
                                x: new Date(2017, 11, 01),
                                    y: [61.71, 64.15, 61.29, 63.04]
                            }
                        ];
                            var options = {
                                chart: {
                                    height: 350,
                                    type: "candlestick",
                                },
                                series: [{
                                    data: seriesData
                                }],
                                stroke: {
                                    width: 1
                                },
                                xaxis: {
                                    type: "datetime"
                                }
                            };
                            var chart = new ApexCharts(
                                document.querySelector("#apexcharts-candlestick"),
                                options
                            );
                            chart.render();
                        });
                    </script>
                </div>
            </div>

        </div>










    </div>
</div>