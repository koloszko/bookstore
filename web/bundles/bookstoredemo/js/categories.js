(function($) {
    $.fn.categories = function(options) {
        var settings = $.extend({
            buildBreadcrumb: false,
            showChooseButton: false,
            onCategoryChosen: function() {
            }
        }, options);

        var selectedCategory;

        function buildCategoryUrl(categoryId, text) {
            return "<a href='" + Routing.generate(settings.path, {parentId: categoryId}) + "' catg-id=" + categoryId + ">" + text + "</a>";
        }
        
        function buildCategoryTree(jsonData) {
            var lnth = jsonData.length;
            var treeDom = '<ul>';
            for (var i = 0; i < lnth; i++) {
                treeDom = treeDom + "<li class='cat'>" + buildCategoryUrl(jsonData[i].id, jsonData[i].name);
            }
            treeDom = treeDom + '</ul>';
            return treeDom;
        }
        
        function setSelectedCategory(anchor) {
            selectedCategory = {id: anchor.attr('catg-id'), name: anchor.text()};
        }
        
        function runCategoryChosenCallback() {
            settings.onCategoryChosen.call(this, selectedCategory);
        }

        if (settings.buildBreadcrumb) {
            this.prepend('<div class="catg-breadcrumbs"><a class="main-ctg" href=' + Routing.generate(settings.path) + ' catg-id=0>Kategorie główne</a></div>');
        }

        if (settings.showChooseButton) {
            this.append("<button type='button' class='btn-choose-catg'>Dodaj wybraną kategorię</button>");
            $('.btn-choose-catg').bind("click", runCategoryChosenCallback);
        }

        this.on('click', '.cat a', function(event) {
            event.preventDefault();
            var self = $(this);
            setSelectedCategory(self);
            $('.cat a').removeClass('clicked');
            self.addClass('clicked');

            $.get(self.attr('href'), function(data) {
                var catgTree = '';
                if (data.length) {
                    catgTree = buildCategoryTree(data);                    
                }
                $('.catg-breadcrumbs a').last().after("<span class='brd-separator'>></span>" + buildCategoryUrl(self.attr('catg-id'), self.text()));
                $('.catg-tree').html(catgTree);
            });
        });

        this.on('click', '.catg-breadcrumbs a', function(event) {
            event.preventDefault();
            var self = $(this);
            setSelectedCategory(self);
            $.get(self.attr('href'), function(data) {
                var catgTree;
                if (data.length) {
                    catgTree = buildCategoryTree(data);
                    self.nextAll().remove();
                }
                $('.catg-tree').html(catgTree);
            });
        });
        return this;
    }

})(jQuery);