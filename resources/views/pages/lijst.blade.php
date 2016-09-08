<div class="table-responsive">
    <table class="table no-margin" id="listtable">

        <thead>
            <tr>
                <th>Kantoor</th>
                <th>Startbudget</th>
                <th>Besteld</th>
                <th>Budget over</th>
            </tr>
        </thead>
        <tbody>

            @foreach($list as $kantoor)
            <tr class="datarow">
                <td>{{ $kantoor->name }}</td>
                <td>{{ $kantoor->startbudget }}</td>
                <td>{{ $kantoor->startbudget - $kantoor->budget }}</td>
                <td>{{ $kantoor->budget }}</td>
            </tr>
            @endforeach
        </tbody>

    </table>
</div><!-- /.table-responsive -->

<style>
    td{
        width:200px;
        text-align:center;
        border-bottom:1px solid #E6E6E6;
        padding:10px;
        font-family: sans-serif;
    }
    th{
        background-color:#3D7596;
        color:white;
        padding:10px;
        margin:0;
        text-transform: uppercase;
        font-family: sans-serif;
    }
</style>

<script>


function exportToExcel(){
var htmls = "";
            var uri = 'data:application/vnd.ms-excel;base64,';
            var template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'; 
            var base64 = function(s) {
                return window.btoa(unescape(encodeURIComponent(s)))
            };

            var format = function(s, c) {
                return s.replace(/{(\w+)}/g, function(m, p) {
                    return c[p];
                })
            };

            htmls = document.getElementById('listtable').outerHTML;

            var ctx = {
                worksheet : 'Worksheet',
                table : htmls
            }


            var link = document.createElement("a");
            link.download = "lijst_budgetten.xls";
            link.href = uri + base64(format(template, ctx));
            link.click();
}
exportToExcel();

</script>