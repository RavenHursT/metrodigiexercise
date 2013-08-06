var MetroDatePicker = {
    $rootElem: null,
    init: function(options, elem){
        this.$rootElem = $(elem);
    }
};

(function($){
    $.fn.metroDatePicker = function(options) {
        if ( this.length ) {
            return this.each(function(){
                // Create a new object via the Prototypal Object.create
                var obj = Object.create(MetroDatePicker);

                // Run the initialization function of the speaker
                obj.init(options, this); // `this` refers to the element

                // Save the instance of the speaker object in the element's data store
                $.data(this, 'instance', obj);
            });
        }
    };
})(jQuery);