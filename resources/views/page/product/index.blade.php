@extends('layouts.shop')
@section('content')


    <div class="col-lg-2">
        <div class="card">
            <div class="card-header pb-0 p-3">
                <div class="row">
                    <div class="col-6 d-flex align-items-center">
                        <h6 class="mb-0">เพิ่มสินค้า</h6>
                    </div>

                </div>
            </div>
            <div class="card-body p-3 pb-0">

                    <form action="{{ route('product_store') }}" method="POST" enctype="multipart/form-data">

                            @csrf
                    <div class="row">

                    <div class="input-group input-group-static my-3">
                        <input type="text" class="form-control" placeholder="BARCODE ID" name="id">
                    </div>
                    <div class="input-group input-group-outline my-3">
                        <input type="text" class="form-control" placeholder="ชื่อสินค้า" name="name">
                    </div>

                        <div class="input-group input-group-outline mb-1">
                            <select class="form-control" id="exampleFormControlSelect1" name="category_id">
                                <option>กรุณาเลือกประเภท</option>
                                @foreach($typeCategory as $item)
                                    <option value="{{$item->id}}">{{$item->id}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <div class="input-group input-group-outline my-3">
                                <input type="text" class="form-control" placeholder="ราคาปลีก" name="priceP">
                            </div>


                        </div>
                        <div class="col-6">
                            <div class="input-group input-group-outline my-3">
                                <input type="text" class="form-control" placeholder="ราคาส่ง" name="priceS">
                            </div>


                        </div>
                        <div class="input-group input-group-outline my-2">
                            <input type="text" class="form-control" placeholder="จำนวน" name="qty">
                        </div>


                            <button type="input" class="btn btn-success">Success</button>


                    </div>

                </form>
            </div>
        </div>

        <br><br>

        @if (session('success'))
            <div class="alert alert-success" role="alert">
                <strong>สำเร็จ !</strong> เพิ่มสินค้าลงในรายการขายเรียบร้อย
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger" role="alert">
                <strong>พบข้อผิดพลาด !</strong> ไม่พบสินค้าในฐานข้อมูล
            </div>
        @endif

    </div>

    <div class="col-lg-10">


    </div>








@endsection
