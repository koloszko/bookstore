$(function() {
    var blockUiMsg = '<h3>Ładowanie...</h3>';
    function sumbitForm() {
        $.get(Routing.generate('bookstore_demo_book_list') + '?' + $('form').serialize(), function(data) {
            $('#tbl').html(data);
            $.unblockUI();
        });
    }

    $('.categories').on('click', '.cat a', function(event) {
        $.blockUI({message: blockUiMsg});
        event.preventDefault();
        var self = $(this),
                liElem = self.parent('li');

        $('.cat a').removeClass('clicked');
        self.addClass('clicked');
        if (liElem.hasClass('unfold')) {
            liElem.removeClass('unfold');
            liElem.find('ul').remove();
        } else {
            liElem.addClass('unfold');
            $.get(self.attr('href'), function(data) {
                var lnth = data.length;
                if (lnth) {
                    var dom = '<ul>';
                    for (var i = 0; i < lnth; i++) {
                        dom = dom + "<li class='cat'><a href='" + Routing.generate('bookstore_demo_categories', {parentId: data[i].id}) + "' catg-id=" + data[i].id + ">" + data[i].name + "</a></li>"
                    }
                    dom = dom + '</ul>';
                }

                self.after(dom);
            });
        }

        $('form #categoryId').val(self.attr('catg-id'));
        sumbitForm();
    });

    $("#tbl").on("submit", 'form', function(event) {
        event.preventDefault();
        $.blockUI({message: blockUiMsg});
        sumbitForm();
    });

    $("#tbl").on("click", '.pagination a', function(event) {
        event.preventDefault();
        $.blockUI({message: blockUiMsg});
        $.get($(this).attr('href'), function(data) {
            $('#tbl').html(data);
            $.unblockUI();
        });
    });

})