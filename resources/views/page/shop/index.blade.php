@extends('layouts.shop')
@section('content')
<div class="col-4 mt-2">
    <div class="card">
        <div class="card-header p-3 pt-2">
            <div class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                <i class="material-icons opacity-10">person</i>
            </div>
            <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">สแกนบาร์โค้ด</p>
            </div>
        </div>
        <hr class="dark horizontal my-0">
        <div class="card-footer p-3">

            <!-- <form action="{{ route('cart.store') }}" method="POST" enctype="multipart/form-data"> -->
            <form>
                @csrf
                <div class="input-group input-group-static mb-4">
                    <input type="text" class="form-control" name="name" id="inputkey1" placeholder="BARCODE ID">
                </div>
            </form>
        </div>
    </div>

    <br><br>
    <div class="alert alert-success" style="display: none;" id="add_data">
        <strong>สำเร็จ !</strong> เพิ่มสินค้าลงในรายการขายเรียบร้อย
    </div>
    <div class="alert alert-danger" style="display: none;" id="delet_edata">
        <strong>สำเร็จ !</strong> ลบสินค้าลงในรายการขายเรียบร้อย
    </div>

    <div class="alert alert-danger" style="display: none;" id="empty_data">
        <strong>พบข้อผิดพลาด !</strong> ไม่พบสินค้าในฐานข้อมูล
    </div>

</div>

<div class="col-8 mt-2">

    <div class="card my-4">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
            <div class="bg-gradient-success shadow-primary border-radius-lg pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3">รายการขาย</h6>
            </div>
        </div>
        <div class="card-body px-0 pb-2">
            <div class="table-responsive p-0">
                <table class="table align-items-center mb-0" id="data_table">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ชื่อสินค้า
                            </th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                จำนวน</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                ราคา</th>

                            <th class="text-secondary opacity-7"></th>
                        </tr>
                    </thead>
                    <tbody id="cartItems">
                        @foreach ($cartItems as $item)
                        <tr>
                            <td>
                                <div class="d-flex px-2 py-1">

                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="mb-0 text-sm">{{ $item->name }}</h6>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <p class="text-xs font-weight-bold mb-0"> {{ $item->quantity }}</p>
                            </td>
                            <td class="align-middle text-center text-sm">
                                <span class="badge badge-sm bg-gradient-success">{{ $item->price }}</span>
                            </td>
                            <td class="align-middle">
                                <form action="{{ route('cart.remove') }}" method="POST">
                                    @csrf
                                    <input type="hidden" value="{{ $item->id }}" name="id">
                                    <button class="btn bg-gradient-danger btn-sm"> <i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <span>Total: $<span id="total">{{ Cart::getTotal() }}</span></span>
            </div>
        </div>
    </div>
</div>
<script>
    $('#inputkey1').keypress(function(e) {
        if (e.which !== 13) return;

        $.ajax({
            type: "POST",
            url: "{{ route('cart.store') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                "name": $('#inputkey1').val()
            },
            success: function(response) {
                if (response.status === 'success') {
                    $("#total").html(response.total);
                    var table = $('#data_table');
                    $('#cartItems').children('tr').remove();
                    let data = response.data;
                    $.each(data, function(index, items) {
                        var row = $('<tr>');
                        row.append(`
                                    <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                        <h6 class="mb-0 text-sm">${items.name}</h6>
                                        </div>
                                    </div>
                                    </td>
                                    <td>
                                    <p class="text-xs font-weight-bold mb-0"> ${items.quantity}</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                    <span class="badge badge-sm bg-gradient-success">${ items.price }</span>
                                    </td>
                                    <td class="align-middle">
                                    <form action="{{ route('cart.remove') }}" method="POST">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" value="${ items.id }" name="id">
                                        <button class="btn bg-gradient-danger btn-sm"> <i class="fas fa-trash"></i></button>
                                    </form>
                                    </td>
                                `);
                        table.append(row);
                    });
                    $("#add_data").show();
                    $("#delet_edata").hide();
                    $("#empty_data").hide();
                } else if (response.status === 'empty') {
                    $("#add_data").hide();
                    $("#delet_edata").hide();
                    $("#empty_data").show();
                }
            }
        });

        return false;
    });
</script>
<!-- <script>
    window.onload = function() {
        document.getElementById("inputkey").focus();
    }
</script> -->

@endsection