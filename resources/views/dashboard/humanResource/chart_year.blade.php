

<div id="chart-profile-visit"></div>


<script>
    const listMonth = ['Jan' , 'Feb' , 'Mar' , 'Apr' , 'May' ,'Jun' , 'Jul' , 'Aug' , 'Sep' , 'Oct' ,'Nov' , 'Dec'];
    let arrayContracts = {!! json_encode($listHrmMonthArray) !!};
    let arraySexy = {!! json_encode($countStatusHrm) !!};
    let dataChart = [];
    listMonth.map((month)=> arrayContracts[month] ? dataChart.push( arrayContracts[month]) : dataChart.push(0))
    let optionsProfileVisit = {
        annotations: {
            position: 'back'
        },
        dataLabels: {
            enabled: false
        },
        chart: {
            type: 'bar',
            height: 300
        },
        fill: {
            opacity: 1
        },
        plotOptions: {},
        series: [{
            name: 'nhân sự',
            data: dataChart
            // data: [12, 20, 35, 20, 10, 20, 30, 20, 10, 20, 30, 20]
        }],
        colors: '#435ebe',
        xaxis: {
            categories: ["Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6", "Tháng 7", "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"],
        },
    }
    let optionsVisitorsProfile = {
        series: [arraySexy['different'], arraySexy['female'] , arraySexy['male']],
        labels: ['Khác', 'Nữ' , 'Nam'],
        colors: ['#6c757d', '#dc3545' ,'#198754'],
        chart: {
            type: 'donut',
            width: '100%',
            height: '350px'
        },
        legend: {
            position: 'bottom'
        },
        plotOptions: {
            pie: {
                donut: {
                    size: '30%'
                }
            }
        }
    }

    let optionsEurope = {
        series: [{
            name: 'series1',
            data: [310, 800, 600, 430, 540, 340, 605, 805, 430, 540, 340, 605]
        }],
        chart: {
            height: 80,
            type: 'area',
            toolbar: {
                show: false,
            },
        },
        colors: ['#5350e9'],
        stroke: {
            width: 2,
        },
        grid: {
            show: false,
        },
        dataLabels: {
            enabled: false
        },
        xaxis: {
            type: 'datetime',
            categories: ["2018-09-19T00:00:00.000Z", "2018-09-19T01:30:00.000Z", "2018-09-19T02:30:00.000Z",
                "2018-09-19T03:30:00.000Z", "2018-09-19T04:30:00.000Z", "2018-09-19T05:30:00.000Z",
                "2018-09-19T06:30:00.000Z", "2018-09-19T07:30:00.000Z", "2018-09-19T08:30:00.000Z",
                "2018-09-19T09:30:00.000Z", "2018-09-19T10:30:00.000Z", "2018-09-19T11:30:00.000Z"
            ],
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false
            },
            labels: {
                show: false,
            }
        },
        show: false,
        yaxis: {
            labels: {
                show: false,
            },
        },
        tooltip: {
            x: {
                format: 'dd/MM/yy HH:mm'
            },
        },
    };

    let optionsAmerica = {
        ...optionsEurope,
        colors: ['#008b75'],
    }
    let optionsIndonesia = {
        ...optionsEurope,
        colors: ['#dc3545'],
    }


    let chartProfileVisit = new ApexCharts(document.querySelector("#chart-profile-visit"), optionsProfileVisit);
    let chartVisitorsProfile = new ApexCharts(document.getElementById('chart-visitors-profile'), optionsVisitorsProfile)
    let chartEurope = new ApexCharts(document.querySelector("#chart-europe"), optionsEurope);
    let chartAmerica = new ApexCharts(document.querySelector("#chart-america"), optionsAmerica);
    let chartIndonesia = new ApexCharts(document.querySelector("#chart-indonesia"), optionsIndonesia);

    chartIndonesia.render();
    chartAmerica.render();
    chartEurope.render();
    chartProfileVisit.render();
    chartVisitorsProfile.render()
</script>
