<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penjualan</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .table-container {
            margin-top: 20px;
        }

        .total-section {
            margin-top: 20px;
        }

        .btn-group {
            margin-top: 10px;
            text-align: right;
        }

        .customer-item,
        .jenis-item,
        .barang-item {
            cursor: pointer;
            transition: lightblue 0.3s, box-shadow 0.3s;
        }

        .customer-item:hover,
        .jenis-item:hover,
        .barang-item:hover {
            background-color: lightblue;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>

<body style="background: #87CEEB">
    <div class="container">
        <h2 class="mt-4 text-center mb-4">Penjualan</h2>
    </div>
    <div class="container border border-2 border-dark bg-white">
        <form action="">
            <div class="btn-group d-flex justify-content-end" style="gap: 10px;">
                <div>
                    <button type="button" class="btn btn-secondary">Clear</button>
                </div>
                <div>
                    <button type="button" class="btn btn-success" id="simpanData">Simpan Data</button>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-2">
                    <label for="noTrans">Nomor Faktur</label>
                    <input type="text" class="form-control" id="noFaktur" readonly value="{{ $nomorFaktur }}">
                </div>
                <div class="form-group col-md-2">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ $currentDate }}">
                </div>
                <div class="form-group col-md-3">
                    <label for="customer">Customer</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="customer" name="customer" placeholder="" readonly>
                        <div class="input-group-append">
                            <button type="button" class="btn btn-primary input-group-text" id="searchButton"><i
                                    class="fas fa-search"></i></button>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-3">
                    <label for="jenisTransaksi">Jenis Transaksi</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="jenisTransaksi" name="jenisTransaksi" readonly>
                        <div class="input-group-append">
                            <button type="button" class="btn btn-primary input-group-text" id="searchButton2"><i class="fas fa-search"
                                    ></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <button type="button" class="btn btn-info" id="btnTambahBarang">Tambah Barang</button>
            </div>
            <div class="table-container">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center">#</th>
                            <th scope="col" class="text-center"><i class="fa fa-trash" aria-hidden="true"></i></th>

                            <th scope="col" class="text-center">Barang</th>
                            <th scope="col" class="text-center">Nama Barang</th>
                            <th scope="col" class="text-center">Qty</th>
                            <th scope="col" class="text-center">Harga</th>
                            <th scope="col" class="text-center">Bruto</th>
                            <th scope="col" class="text-center">Diskon</th>
                            <th scope="col" class="text-center">Total Rp</th>
                        </tr>
                    </thead>
                    <tbody id="barangTableBody">
                        @if (Session::has('detailBarang'))
                            @php
                                $i = 1;
                                // print_r(Session::get('detailBarang'))
                            @endphp
                            @foreach (Session::get('detailBarang') as $index => $item)
                                {{-- @php
                                    print_r($item)
                                @endphp --}}
                                <tr>
                                    <td class="text-center">{{ $i }}</td>
                                    <td class="text-center"><i class="fa fa-trash remove-item"></i></td>
                                    <td class="text-center">{{ $item['kodeBarang'] }}</td>
                                    <td class="text-center">{{ $item['namaBarang'] }}</td>
                                    <td class="text-right"><input type="numeric" class="quantity" name="quantity"
                                            value="{{ $item['qty'] }}" style="width: 30px;"></td>
                                    <td class="text-right">Rp {{ number_format($item['hargaBarang'], 0, ',', '.') }}
                                    </td>

                                    <td class="text-right">Rp
                                        {{ number_format($item['bruto'] * $item['qty'], 0, ',', '.') }}</td>
                                    <td class="text-right">Rp
                                        {{ number_format($item['diskon'] * $item['qty'], 0, ',', '.') }}</td>
                                    <td class="text-right">Rp
                                        {{ number_format($item['totalRp'] * $item['qty'], 0, ',', '.') }}</td>
                                </tr>
                                @php
                                    $i++;
                                @endphp
                            @endforeach
                        @else
                            <tr>
                                <td colspan="9" class="text-center">Tidak ditemukan data yang cocok</td>
                            </tr>
                        @endif

                    </tbody>
                </table>
            </div>
            <div class="total-section">
                <div class="row">
                    <div class="col-md-8"></div>
                    <div class="col-md-4">
                        <div class="form-group row">
                            <label for="totalBruto" class="col-sm-4 col-form-label">Total Bruto</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="totalBruto"
                                    value="Rp {{ Session::get('sumBruto') ? number_format(Session::get('sumBruto'), 0, ',', '.') : number_format(0, 0, ',', '.') }}"
                                    readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="totalDiskon" class="col-sm-4 col-form-label">Total Diskon</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="totalDiskon"
                                    value="Rp {{ Session::get('sumDiskon') ? number_format(Session::get('sumDiskon'), 0, ',', '.') : number_format(0, 0, ',', '.') }}"
                                    readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="grandTotal" class="col-sm-4 col-form-label">Grand Total</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="grandTotal"
                                    value="Rp {{ Session::get('sumTotalRp') ? number_format(Session::get('sumTotalRp'), 0, ',', '.') : number_format(0, 0, ',', '.') }}"
                                    readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="customerModal" tabindex="-1" role="dialog" aria-labelledby="customerModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="customerModalLabel">Data Customer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Search Input -->
                    <div class="form-group">
                        <input type="text" id="searchInput" class="form-control">
                    </div>
                    <!-- Search Results -->
                    <div id="searchResults">
                        @foreach ($dataCustomers as $item)
                            <div class="customer-item border m-3 p-3 rounded"
                                data-customer-code="{{ $item->kode_customer }}"
                                data-customer-name="{{ $item->nama_customer }}" style="cursor: pointer;">
                                <h6>{{ $item->kode_customer }} - {{ $item->nama_customer }}</h6>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="jenisTransaksiModal" tabindex="-1" role="dialog"
        aria-labelledby="jenisTransaksiModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="jenisTransaksiModalLabel">Jenis Transaksi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Search Results -->
                    @foreach ($dataJenis as $item)
                        <div class="jenis-item border m-3 p-3 rounded" jenis-transaksi-code="{{ $item->kode_tjen }}"
                            jenis-transaksi-name="{{ $item->nama_tjen }}" style="cursor: pointer;">
                            <h6>{{ $item->kode_tjen }} - {{ $item->nama_tjen }}</h6>
                        </div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="tambahBarangModal" tabindex="-1" role="dialog"
        aria-labelledby="tambahBarangModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahBarangModalLabel">Pilih Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Search Input -->
                    <div class="form-group">
                        <input type="text" id="searchBarangInput" class="form-control">
                    </div>
                    <!-- Search Results -->
                    <div id="barangSearchResults">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Harga Barang</th>
                                </tr>
                            </thead>
                            <tbody id="barangTableBody">
                                @foreach ($dataBarang as $item)
                                    <tr class="barang-item" data-barang-code="{{ $item->kode_barang }}"
                                        data-barang-name="{{ $item->nama_barang }}"
                                        data-harga="{{ $item->harga_barang }}">
                                        <td>{{ $item->kode_barang }}</td>
                                        <td>{{ $item->nama_barang }}</td>
                                        <td>Rp {{ number_format($item->harga_barang, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            // Modal search
            $('#searchButton').on('click', function() {
                $('#customerModal').modal('show');
            });

            $('#searchButton2').on('click', function() {
                $('#jenisTransaksiModal').modal('show');
            });

            // Customer item click event
            $('.customer-item').on('click', function() {
                const customerCode = $(this).data('customer-code');
                const customerName = $(this).data('customer-name');
                $('#customer').val(`${customerCode} - ${customerName}`);
                $('#customerModal').modal('hide');
            });

            // Jenis transaksi item click event
            $('.jenis-item').on('click', function() {
                const jenisTransaksiCode = $(this).attr('jenis-transaksi-code');
                const jenisTransaksiName = $(this).attr('jenis-transaksi-name');
                $('#jenisTransaksi').val(`${jenisTransaksiCode} - ${jenisTransaksiName}`);
                $('#jenisTransaksiModal').modal('hide');
            });

            // Add barang
            $('#btnTambahBarang').on('click', function() {
                $('#tambahBarangModal').modal('show');
            });

            // Barang item click event
            $('.barang-item').on('click', function() {
                const barangCode = $(this).data('barang-code');
                const barangName = $(this).data('barang-name');
                const harga = $(this).data('harga');
                const qty = 1;
                const diskon = 0.05 * harga;
                const bruto = qty * harga;
                const totalRp = bruto - diskon;

                $.post("{{ route('add_data') }}", {
                    kodeBarang: barangCode,
                    namaBarang: barangName,
                    hargaBarang: harga,
                    qty: qty,
                    diskon: diskon,
                    bruto: bruto,
                    totalRp: totalRp,
                    _token: "{{ csrf_token() }}"
                }).done(function(data) {
                    if (data === "success") {
                        location.reload(true)
                    } else {
                        alert("Barang Gagal Ditambahkan");
                    }
                })

                $('#tambahBarangModal').modal('hide');

            });


            // Ganti Quantity
            $(".quantity").on("change", function() {

                var kodeBarang = ($(this).closest("tr").find("td").eq(2).text())
                $.post("{{ route('update_quantity') }}", {
                    kodeBarang: kodeBarang,
                    quantity: $(this).val(),
                    _token: "{{ csrf_token() }}"
                }).done(function(data) {
                    if (data === "success") {
                        // $(this).closest('tr').remove();
                        location.reload(true)
                    } else {
                        alert("Barang Gagal Ditambahkan");
                    }
                })
            })

            // Remove item
            $(document).on('click', '.remove-item', function() {
                var kodeBarang = ($(this).closest("tr").find("td").eq(2).text())
                $.post("{{ route('remove_data') }}", {
                    kodeBarang: kodeBarang,
                    _token: "{{ csrf_token() }}"
                }).done(function(data) {
                    if (data === "success") {
                        // $(this).closest('tr').remove();
                        location.reload(true)

                    } else {
                        alert("Barang Gagal Ditambahkan");
                    }
                })

            });

            // Clear data
            $('.btn-secondary').on('click', function() {
                $('#barangTableBody').html(
                    '<tr><td colspan="9" class="text-center">Tidak ditemukan data yang cocok</td></tr>');
                $('#customer').val('');
                $('#jenisTransaksi').val('');
                $('#totalBruto').val(0);
                $('#totalDiskon').val(0);
                $('#grandTotal').val(0);
                $.post("{{ route('clear_data') }}", {
                    _token: "{{ csrf_token() }}"
                }).done(function(data) {
                    if (data === "success") {
                        location.reload(true)
                    } else {
                        alert("Gagal Clear Data");
                    }
                })
            });

            // Save data
            $('#simpanData').on('click', function() {
                if ($('#customer').val()!="" && $('#jenisTransaksi').val()!="") {
                    $.post("{{ route('save_data') }}", {
                        noFaktur: $('#noFaktur').val(),
                        tanggal: $('#tanggal').val(),
                        customer: $('#customer').val(),
                        jenisTransaksi: $('#jenisTransaksi').val(),
                        _token:"{{csrf_token()}}"
                    }).done(function(data) {
                        console.log(data)

                        if (data === "success") {
                            alert("Data Berhasil Disimpan")
                            location.reload(true)
                        } else {
                            alert("Data Gagal Disimpan")
                        }
                    })
                }
                else{
                    alert("Harap Diisi Customer dan Jenis Transaksi")
                }
            });
        });
    </script>
</body>

</html>
