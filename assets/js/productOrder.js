$(function(){

    $('.addProductOrder').click(function(e){
        e.preventDefault();

        $.ajax({
            type: 'GET',
            url: $(this).attr("href"),

            statusCode: {
                201: function(data){
                    $('#orderSideproduct').append(createProduct(data));
                },
                200: function(data){
                    $('.quantity-id').each(function(){
                        var id = 'quantity' + data.id;
                        if($(this).attr('name') === id){
                            $(this).val(data.quantity);
                        }
                    });
                }
            },

            success: function(data){
                var num = Number(data.totalPrice);
                var roundedString = num.toFixed(2);
                $('#orderSidePrice').text(roundedString);
            }
        });
    });

    $('.quantity-id').click(function(e){
        var sel = $(this);
        quantityProductInOrder(e, sel);
    });

    $('.delete-id').click(function(e){
        var sel = $(this);
        deleteProductInOrder(e, sel);
    });

    function quantityProductInOrder(e, sel)
    {
        if(sel.val() >= 1){
            sel.val(Math.ceil(sel.val()));
        
            var id = sel.attr('name').substring(8, sel.attr('name').length);
            var url = '/products/' + id; 

            $.ajax({
                type: 'POST',
                url: url,
                data: {quantity: sel.val()},

                success: function(data){
                    var num = Number(data.totalPrice);
                    var roundedString = num.toFixed(2);
                    $('#orderSidePrice').text(roundedString);
                }
            });
        }
    }

    function deleteProductInOrder(e, sel)
    {
        e.preventDefault();

        var id = sel.attr('id').substring(6, sel.attr('id').length);
        var url = '/products/' + id; 

        $.ajax({
            method: 'DELETE',
            url: url,

            success: function(data){
                var num = Number(data.totalPrice);
                var roundedString = num.toFixed(2);
                $('#orderSidePrice').text(roundedString);
            }
        });

        sel.parentsUntil('#orderSideproduct').remove();
    }

    function createProduct(data)
    {
        var productElt = $('<div>', {class: 'card'});
        var rowElt = $('<div>', {class: 'row no-gutters'});
        var cardImgElt = $('<div>', {class: 'col-4'});
        var imgElt = $('<img>', {class: 'card-img', src: data.path});
        var cardBodyElt = $('<div>', {class: 'card-body col-7'});
        var nameElt = $('<h5>', {class: 'card-title', text: data.name});
        var paragarpheElt = $('<p>', {text: 'X'});
        var quantityElt = $('<input>', {type: 'number', min: '1',class: 'quantity-id', name: 'quantity' + data.id, value: data.quantity});
        var cardFooterElt = $('<div>', {class: 'col-1'});
        var linkElt = $('<a>', {href: '', class: 'delete-id', id: 'delete' + data.id});
        var iElt = $('<i>', {class: 'fas fa-trash-alt text-danger'});

        quantityElt.click(function(e){ 
            var sel = $(this);
            quantityProductInOrder(e, sel);
        });
        linkElt.click(function(e){ 
            var sel = $(this);
            deleteProductInOrder(e, sel); 
        });

        cardImgElt.append(imgElt);
        paragarpheElt.append(quantityElt);
        cardBodyElt.append(nameElt);
        cardBodyElt.append(paragarpheElt);
        linkElt.append(iElt);
        cardFooterElt.append(linkElt);
        rowElt.append(cardImgElt);
        rowElt.append(cardBodyElt);
        rowElt.append(cardFooterElt);
        productElt.append(rowElt);

        return productElt;
    }
});