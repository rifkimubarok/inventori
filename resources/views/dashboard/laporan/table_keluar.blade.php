<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>No.</th>
            <th>Nama Barang</th>
            <th>Jumlah</th>
            <th>Harga Jual</th>
            <th>Total Harga</th>
        </tr>
    </thead>
    <tbody>
        @php
            $grant_total = 0;
            $grant_total_barang = 0;
        @endphp
        @foreach ($data_transaksi as $item)
            @php
                $grant_total += $item->total_harga;
                $grant_total_barang += $item->total_barang;
            @endphp
            <tr>
            <td colspan="4"><strong>{{$item->tgl_transaksi}}</strong></td>
            <td class="text-center">Rp. {{number_format($item->total_harga,0)}}</td>
            </tr>
            @php
                $nomor = 0;
            @endphp
            @foreach ($item->detail as $row)
                <tr>
                    <td class="text-right">{{$nomor+=1}}</td>
                <td>{{$row->nama_barang}}</td>
                <td>{{$row->jml}}</td>
                <td class="text-center">{{number_format($row->harga_jual,0)}}</td>
                <td class="text-center">Rp. {{number_format($row->total_harga,0)}}</td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
    <tfoot>
        <th colspan="2" class="text-right">
            <strong>Jumlah :</strong>
        </th>
        <td>{{number_format($grant_total_barang,0)}}</td>
        <td></td>
        <td class="text-center">Rp. {{number_format($grant_total,0)}}</td>
    </tfoot>
</table>