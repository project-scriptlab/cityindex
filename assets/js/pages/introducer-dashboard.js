! function(e) {
    "use strict";

    function t() {
        this.$body = e("body"), this.charts = []
    }
    t.prototype.initCharts = function() {
        window.Apex = {
            chart: {
                parentHeightOffset: 0,
                toolbar: {
                    show: !1
                }
            },
            grid: {
                padding: {
                    left: 0,
                    right: 0
                }
            },
            colors: ["#727cf5", "#0acf97", "#fa5c7c", "#ffbc00"]
        };
        var t = '',
            o = '',
            a = '';
        t = ["#727cf5", "#e3eaef"], (o = e("#high-performing-product").data("colors")) && (t = o.split(",")), a = {
            chart: {
                height: 257,
                type: "bar",
                stacked: !0
            },
            plotOptions: {
                bar: {
                    horizontal: !1,
                    columnWidth: "20%"
                }
            },
            dataLabels: {
                enabled: !1
            },
            stroke: {
                show: !0,
                width: 2,
                colors: ["transparent"]
            },
            series: [{
                name: "Actual",
                data: [65, 59, 80, 81, 56, 89, 40, 32, 65, 59, 80, 81]
            }, {
                name: "Projection",
                data: [89, 40, 32, 65, 59, 80, 81, 56, 89, 40, 65, 59]
            }],
            zoom: {
                enabled: !1
            },
            legend: {
                show: !1
            },
            colors: t,
            xaxis: {
                categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                axisBorder: {
                    show: !1
                }
            },
            yaxis: {
                labels: {
                    formatter: function(e) {
                        return e + "k"
                    },
                    offsetX: -15
                }
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function(e) {
                        return "$" + e + "k"
                    }
                }
            }
        }, new ApexCharts(document.querySelector("#high-performing-product"), a).render()

    }, t.prototype.init = function() {
        e("#dash-daterange").daterangepicker({
            singleDatePicker: !0
        }), this.initCharts()
    }, e.Dashboard = new t, e.Dashboard.Constructor = t
}(window.jQuery),
function(e) {
    "use strict";
    e(document).ready(function(t) {
        e.Dashboard.init()
    })
}(window.jQuery);