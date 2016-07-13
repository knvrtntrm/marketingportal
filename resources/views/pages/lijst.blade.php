<div class="table-responsive">
    <table class="table no-margin">

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
                <td>€ 720</td>
                <td>€ {{ 720 - $kantoor->budget }}</td>
                <td>€ {{ $kantoor->budget }}</td>
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