@extends('client.layout.master')

@section('content')
 <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="img/breadcrumb.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Shopping Cart</h2>
                        <div class="breadcrumb__option">
                            <a href="./index.html">Home</a>
                            <span>Shopping Cart</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Shoping Cart Section Begin -->
    <section class="shoping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__table">
                        <table id="table-cart">
                            <thead>
                                <tr>
                                    <th class="shoping__product">Products</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cart as $productId => $item)
                                    <tr id="tr-{{ $productId }}">
                                        <td class="shoping__cart__item">
                                            <img src="img/cart/cart-1.jpg" alt="">
                                            <h5>{{ $item['name'] }}</h5>
                                        </td>
                                        <td class="shoping__cart__price">
                                            ${{ number_format($item['price'], 2) }}
                                        </td>
                                        <td class="shoping__cart__quantity">
                                            <div class="quantity">
                                                <div 
                                                data-product-id="{{ $productId }}"
                                                data-url-add-product="{{ route('cart.add.product.item', ['productId' => $productId]) }}" class="pro-qty">
                                                    <input type="text" value="{{ $item['qty'] }}">
                                                </div>
                                            </div>
                                        </td>
                                        <td class="shoping__cart__total">
                                            ${{ number_format($item['price'] * $item['qty'], 2) }}
                                        </td>
                                        <td
                                        data-url-delete="{{ route('cart.delete.item', ['productId' => $productId]) }}" 
                                        data-product-id="{{ $productId }}" class="shoping__cart__item__close">
                                            <span class="icon_close"></span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__btns">
                        <a href="#" class="primary-btn cart-btn">CONTINUE SHOPPING</a>
                        <a href="#" class="primary-btn cart-btn cart-btn-right btn-delete-cart"><span class="icon_loading"></span>
                            Delete Cart</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="shoping__continue">
                        <div class="shoping__discount">
                            <h5>Discount Codes</h5>
                            <form action="#">
                                <input type="text" placeholder="Enter your coupon code">
                                <button type="submit" class="site-btn">APPLY COUPON</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="shoping__checkout">
                        <h5>Cart Total</h5>
                        <ul>
                            <li>Subtotal <span>$454.98</span></li>
                            <li>Total <span>$454.98</span></li>
                        </ul>
                        <a href="#" class="primary-btn">PROCEED TO CHECKOUT</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shoping Cart Section End -->
@endsection

@section('myscript')
<script type="text/javascript">
    $(document).ready(function(){
       $('.btn-delete-cart').on('click', function(event){
            event.preventDefault();
            $.ajax({
                type: 'GET',
                url: "{{ route('cart.destroy') }}",
                success: function (response){
                    $('#table-cart').empty();
                    alert(response.message);
                }
            })
       });

       $('.shoping__cart__item__close').on('click', function (){
            var productId = $(this).data('product-id');
            var url = $(this).data('url-delete');
            
            $.ajax({
                type: 'GET',
                url: url,
                success: function (response){
                    $('#tr-'+productId).empty();
                    Swal.fire({
                        title: response.message,
                        icon: "success"
                    });
                }
            });
       });

       $('.qtybtn').on('click', function(){
            var btn = $(this);

            var qty = parseInt(btn.siblings('input').val());

            if(btn.hasClass('inc')){
                qty += 1;
            }else if(btn.hasClass('dec')){
                qty -= 1;
            }

            var url = btn.parent().data('url-add-product');
            url += "/"+qty;

            $.ajax({
                type: 'GET',
                url: url,
                success: function (response) {
                    var productId = btn.parent().data('product-id');
                    if(qty === 0){
                         $('#tr-'+productId).empty();
                    }
                    Swal.fire({
                        title: response.message,
                        icon: "success"
                    });
                }
            });
       });
    });
</script>
@endsection