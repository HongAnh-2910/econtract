
    <div id="chart-profile-visit{{ $id }}"></div>
<script>
    const listMonth{{ $id }} = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    let arrayContracts{{ $id }} = {!! json_encode($listHrmMonthArray ?? []) !!};
    let dataChart{{ $id }} = [];
    listMonth{{ $id }}.map((month) => arrayContracts{{ $id }}[month] ? dataChart{{ $id }}.push(arrayContracts{{ $id }}[month]) : dataChart{{ $id }}.push(0))
    let optionsProfileVisit{{ $id }} = {
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
            data: dataChart{{ $id }}
        }],
        colors: '#435ebe',
        xaxis: {
            categories: ["Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6", "Tháng 7", "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"],
        },
    }

    let chartProfileVisit{{ $id }} = new ApexCharts(document.querySelector("#chart-profile-visit{{ $id }}"), optionsProfileVisit{{ $id }});

    chartProfileVisit{{ $id }}.render();

</script>

