$(function(){
    $('.checkAllSquare').click(function(){
        $(this).toggleClass('fa-square').toggleClass('fa-check-square');

        if($(this).hasClass('fa-square'))
        {
            $('.checkSquare').addClass('fa-square');
            $('.checkSquare').removeClass('fa-check-square');
        }
        else
        {
            $('.checkSquare').removeClass('fa-square');
            $('.checkSquare').addClass('fa-check-square');
        }

        button(who());
    });

    $('.checkSquare').click(function(){
        $(this).toggleClass('fa-square').toggleClass('fa-check-square');
        button(who());
    });

    $('#deleteAllButton').click(function(e){

        e.preventDefault();

        if(confirm('Confirmer la suppression ?'))
        {
            var elementArray = who();
            var idArray = [];

            elementArray.forEach(element => {
                idArray.push(element.parent().parent().attr('id'));
            });

            $.post($(this).attr("href"), {idArray: idArray},
                function(data) {
            });

            elementArray.forEach(element => {
                element.parentsUntil('tbody').remove();
            });

            button(who());
        }
    });

    $('.deleteButton').click(function(e){

        e.preventDefault();

        if(confirm('Confirmer la suppression ?'))
        {
            var idArray = [$(this).parent().parent().attr('id')];
            
            $.post($(this).attr("href"), {idArray: idArray},
                function(data) {
            });

            $(this).parentsUntil('tbody').remove();

            button(who());
        }
    });

    function who()
    {
        var who = [];

        $('.checkSquare').each(function(){
            if($(this).hasClass('fa-check-square'))
            {
                who.push($(this));
            }
        });

        return who;
    }

    function button(who)
    {
        if(who.length === 0)
        {
            $('#deleteAllButton').addClass('disabled');
        }
        else if(who.length !== 0)
        {
            $('#deleteAllButton').removeClass('disabled');
        }
    }
});