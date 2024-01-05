$(document).on('click','.cartIconAction',function(){
    var productId = $(this).data('id');
            
    const that = this;
    if ($(this).hasClass('added')) {
        $.ajax({
            type: 'POST',
            url: removeFromCartUrl,
            data: {
                product_id: productId,
                quantity: 1,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                $(that).find('path').attr('fill','');
                $(that).removeClass('added');
                $('.cartDataContainer').html(response.data.htmlData);
                $('.mainCartCounter').text(response.data.count);

            },
            error: function(error) {
                console.error('Error adding product to cart');
            }
        });
    }else{

        $.ajax({
            type: 'POST',
            url: addToCartUrl,
            data: {
                product_id: productId,
                quantity: 1,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                $(that).find('path').attr('fill','#FF0000');
                $(that).addClass('added');
                $('.cartDataContainer').html(response.data.htmlData);
                $('.mainCartCounter').text(response.data.count);
                console.log(response);
            },
            error: function(error) {
                console.error('Error adding product to cart');
            }
        });
    }
    
});