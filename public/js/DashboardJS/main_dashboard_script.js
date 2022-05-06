//EPL Renewal Chart OPEN//

function eplRenewalChart(lable, line1, line2) {
    'use strict'

    var ticksStyle = {
        fontColor: '#495057',
        fontStyle: 'bold'
    }

    var mode = 'index';
    var intersect = true;

    var $visitorsChart = $('#epl-renewal-chart')
    var visitorsChart = new Chart($visitorsChart, {
        data: {
            //            labels: ['18th', '20th', '22nd', '24th', '26th', '28th', '30th'],
            labels: lable,
            datasets: [{
                    type: 'line',
                    //                    data: [100, 120, 170, 167, 180, 177, 160],
                    data: line1,
                    backgroundColor: 'transparent',
                    borderColor: '#007bff',
                    pointBorderColor: '#007bff',
                    pointBackgroundColor: '#007bff',
                    fill: false
                        // pointHoverBackgroundColor: '#007bff',
                        // pointHoverBorderColor    : '#007bff'
                },
                {
                    type: 'line',
                    //                    data: [60, 80, 70, 67, 80, 77, 100],
                    data: line2,
                    backgroundColor: 'tansparent',
                    borderColor: '#ced4da',
                    pointBorderColor: '#ced4da',
                    pointBackgroundColor: '#ced4da',
                    fill: false
                        // pointHoverBackgroundColor: '#ced4da',
                        // pointHoverBorderColor    : '#ced4da'
                }
            ]
        },
        options: {
            maintainAspectRatio: false,
            tooltips: {
                mode: mode,
                intersect: intersect
            },
            hover: {
                mode: mode,
                intersect: intersect
            },
            legend: {
                display: false
            },
            scales: {
                yAxes: [{
                    // display: false,
                    gridLines: {
                        display: true,
                        lineWidth: '4px',
                        color: 'rgba(0, 0, 0, .2)',
                        zeroLineColor: 'transparent'
                    },
                    ticks: $.extend({
                        beginAtZero: true,
                        suggestedMax: 200
                    }, ticksStyle)
                }],
                xAxes: [{
                    display: true,
                    gridLines: {
                        display: false
                    },
                    ticks: ticksStyle
                }]
            }
        }
    })
}
//EPL Renewal Chart END//



//NEW FILES Chart OPEN//
function newFilesChart(newfile_lable, all_data, site, epl) {
    var salesGraphChartCanvas = $('#new-files-chart').get(0).getContext('2d');
    //$('#revenue-chart').get(0).getContext('2d');

    var salesGraphChartData = {
        labels: newfile_lable,
        datasets: [{
            label: 'Total Files',
            fill: false,
            borderWidth: 2,
            lineTension: 0,
            spanGaps: true,
            borderColor: '#dc3545',
            pointRadius: 3,
            pointHoverRadius: 7,
            pointColor: '#dc3545',
            pointBackgroundColor: '#dc3545',
            data: all_data
        }, {
            label: 'Site Clearance',
            fill: false,
            borderWidth: 2,
            lineTension: 0,
            spanGaps: true,
            borderColor: '#007bff',
            pointRadius: 3,
            pointHoverRadius: 7,
            pointColor: '#007bff',
            pointBackgroundColor: '#007bff',
            data: site
        }, {
            label: 'EPL',
            fill: false,
            borderWidth: 2,
            lineTension: 0,
            spanGaps: true,
            borderColor: '#6610f2',
            pointRadius: 3,
            pointHoverRadius: 7,
            pointColor: '#6610f2',
            pointBackgroundColor: '#6610f2',
            data: epl
        }]
    }

    var salesGraphChartOptions = {
        maintainAspectRatio: false,
        responsive: true,
        legend: {
            display: false,
        },
        scales: {
            xAxes: [{
                ticks: {
                    fontColor: '#efefef',
                },
                gridLines: {
                    display: false,
                    color: '#efefef',
                    drawBorder: false,
                }
            }],
            yAxes: [{
                ticks: {
                    stepSize: 5000,
                    fontColor: '#efefef',
                },
                gridLines: {
                    display: true,
                    color: '#efefef',
                    drawBorder: false,
                }
            }]
        }
    }

    // This will get the first returned node in the jQuery collection.
    var salesGraphChart = new Chart(salesGraphChartCanvas, {
        type: 'line',
        data: salesGraphChartData,
        options: salesGraphChartOptions
    })
}
//NEW FILES Chart END//


//-------------
//- fileCategory OPEN -
//-------------
// Get context with jQuery - using jQuery's .get() method.

function fileCategoryChart(fileCat) {
    var pieChartCanvas = $('#fileCategorypieChart').get(0).getContext('2d')
    var pieData = {
        labels: fileCat.types,
        datasets: [{
            data: fileCat.count,
            backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
        }]
    }
    var pieOptions = {
            legend: {
                display: false
            }
        }
        //Create pie or douhnut chart
        // You can switch between pie and douhnut using the method below.
    var pieChart = new Chart(pieChartCanvas, {
        type: 'doughnut',
        data: pieData,
        options: pieOptions
    });
}
//-----------------
//- fileCategory END -
//-----------------


//-------------
//- newJobs OPEN -
//-------------
function newJobsChart(newJobs_lable, newJobs_data) {
    var pieChartCanvas = $('#newJobspieChart').get(0).getContext('2d')
    var pieData = {
        labels: newJobs_lable,
        datasets: [{
            data: newJobs_data,
            backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
        }]
    }
    var pieOptions = {
            legend: {
                display: false
            }
        }
        //Create pie or douhnut chart
        // You can switch between pie and douhnut using the method below.
    var pieChart = new Chart(pieChartCanvas, {
        type: 'doughnut',
        data: pieData,
        options: pieOptions
    })
}
//-----------------
//- newJobs END -
//-----------------


///
function pradeshiyasabaFileCount(data, callBack) {
    var tbl = "";
    if (data.length == 0) {
        tbl = "<tr><td colspan='4'>No Data Found</td></tr>";
    } else {
        $.each(data, function(index, row) {
            tbl += '<tr>';
            //            tbl += '<td>' + ++index + '</td>';
            tbl += '<td>' + row.name + '</td>';
            tbl += '<td>' + row.total + '</td>';
            tbl += '</tr>';
        });
    }
    $('#pradeshiyasabaFileCount_table tbody').html(tbl);
    $('#pradeshiyasabaFileCount_table').DataTable();
    if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
        callBack();
    }

}

function environmentOfficersFileCount(data, callBack) {
    var tbl = "";
    if (data.length == 0) {
        tbl = "<tr><td colspan='4'>No Data Found</td></tr>";
    } else {
        $.each(data, function(index, row) {
            tbl += '<tr>';
            //            tbl += '<td>' + ++index + '</td>';
            tbl += '<td>' + row.first_name + ' ' + row.last_name + '</td>';
            tbl += '<td>' + row.total + '</td>';
            tbl += '</tr>';
        });
    }
    $('#envOfficeFileCount_table tbody').html(tbl);
    $('#envOfficeFileCount_table').DataTable();
    if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
        callBack();
    }

}

function industryCategoryCount(data, callBack) {
    var tbl = "";
    if (data.length == 0) {
        tbl = "<tr><td colspan='4'>No Data Found</td></tr>";
    } else {
        $.each(data, function(index, row) {
            tbl += '<tr>';
            //            tbl += '<td>' + ++index + '</td>';
            tbl += '<td>' + row.name + '</td>';
            tbl += '<td>' + row.total + '</td>';
            tbl += '</tr>';
        });
    }
    $('#industryCatCount_table tbody').html(tbl);
    $('#industryCatCount_table').DataTable();
    if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
        callBack();
    }

}

function getDashboardData(rep_list, from_to, callBack) {
    console.log(rep_list);
    let data = {};
    $.each(rep_list, function(index, r) {
        data[r] = { 'from': from_to.from, 'to': from_to.to };
    });
    //    console.log(data);
    //    return false;   
    ajaxRequest("GET", "api/dashboard", data, function(parameters) {
        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
            callBack(parameters);
        }
    });
}