<script>
    $(document).ready(function() {

        $(document).on("click", '.add_to_cart' , function(e){
            e.preventDefault();
            var id = $(this).data('id');
            $.ajax({
                url:"{{ route('addToCart') }}",
                type:"POST",
                data: {
                    id: id,
                    _token: '{!! csrf_token() !!}',
                },
                success:function (data) {
                    console.log(data);
                    var msg = data[0];
                    if(msg == 'exist')
                    {
                        toastr.error(@json(__('lang.course_cart_exist')));
                        window.location.href =  "{{ url('checkout')}}";
                    }
                    if(msg == 'added')
                    {
                        toastr.success(@json(__('lang.added_to_cart')));
                        $('.cart_content').empty();
                        $('.cart_content').append(data[1]);
                        window.location.href =  "{{ url('checkout')}}";
                    }
                    if(msg == 'err')
                    {
                        toastr.error(@json(__('lang.not_found')));
                    }
                    if(msg == 'subscribtion_exist')
                    {
                        toastr.error(@json(__('lang.course_wait_activation')));
                    }
                },
                complete(data)
                {
                    // $('.icon_cart').on('click', function() {
                    //     $('.minicartBox').toggleClass('show')
                    // })
                    $('.icon_cart').on('click', function() {
                        $('.minicartBox').toggleClass('show')
                        $('.login_box .dropdown_menu').removeClass('open')
                    })

                    $('.btn_close').on('click', function() {
                        $('.minicartBox').removeClass('show')
                    })

                }
            })
        });
{{--
        /* $('body').on('click', '.remove_from_cart', (e) => {
           var id= $(this).attr('data-id');
           var row = $(this);
           $.ajax({
                url:"{{ route('removeFromCart') }}",
                type:"POST",
                data: {
                    id: id,
                    _token: '{!! csrf_token() !!}',
                },
                success:function (data) {
                    var msg = data[0];
                    if(msg == 'removed')
                    {
                        toastr.success(@json(__('lang.removed_from_cart')));
                        $('.cart_content').empty();
                        $('.cart_content').append(data[1]);
                        $('.icon_cart').on('click', function() {
                            $('.minicartBox').toggleClass('show')
                        })

                    }
                    if(msg == 'err')
                    {
                        toastr.error(@json(__('lang.not_found')));
                    }
                },
                complete(data)
                {
                    $('.icon_cart').on('click', function() {
                        $('.minicartBox').toggleClass('show')
                    })
                }
            });
        });  */  --}}
    })
</script>
