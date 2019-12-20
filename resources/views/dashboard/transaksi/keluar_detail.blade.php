@php
    $number = 0;
    $total_barang= 0;
@endphp
<table class="table table-striped table-bordered" style="max-height:350px;">
    <thead>
        <tr>
            <th>No.</th>
            <th>Nama Barang.</th>
            <th>Jumlah.</th>
            <th width="40px">#</th>                
        </tr>
    </thead>
    <tbody>
        @php
            $detail_transaksi = $output->detail_transaksi;
        @endphp
        @foreach ($detail_transaksi as $item)
            @php
                $total_barang += $item->jml;
            @endphp
            <tr>
                <td>{{$number+=1}}</td>
                <td>{{$item->barang->nama_barang}}</td>
                <td>{{$item->jml}}</td>
                @if (!isset($output->param['mode']))
                    <td><button class="btn btn-danger btn-xs btn-delete-detail" data-value={{$item->id}}><i class="fas fa-trash"></i></button></td>
                @else
                    @if ($item->isReturn == 0)
                        <td><button class="btn btn-success btn-xs btn-return-detail" data-value={{$item->id}}>Kembalikan</button></td>
                    @endif
                @endif
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2" class="text-right">Jumlah :</td>
            <td>{{number_format($total_barang,0)}}</td>
        </tr>
    </tfoot>
</table>