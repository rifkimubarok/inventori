@php
    $number = 0;
    $total_barang= 0;
    $total_harga = 0;
@endphp
<table class="table table-striped table-bordered" style="max-height:350px;">
    <thead>
        <tr>
            <th>No.</th>
            <th>Nama Barang.</th>
            <th>Jumlah.</th>
            <th>Harga.</th>
            <th>Total Harga.</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($detail_transaksi as $item)
            @php
                $total_barang += $item->jml;
                $total_harga += $item->total_harga;
            @endphp
            <tr>
                <td>{{$number+=1}}</td>
                <td>{{$item->nama_barang}}</td>
                <td>{{$item->jml}}</td>
                <td>{{number_format($item->harga_jual,0)}}</td>
                <td>{{number_format($item->total_harga,0)}}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2" class="text-right">Jumlah :</td>
            <td>{{number_format($total_barang,0)}}</td>
            <td></td>
            <td>{{number_format($total_harga,0)}}</td>
        </tr>
    </tfoot>
</table>