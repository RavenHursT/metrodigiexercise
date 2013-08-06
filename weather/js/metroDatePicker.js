var MetroDatePicker = {
    $rootElem: null,
    options: null,
    init: function(options, elem){
        this.$rootElem = $(elem);
        if(options != 'undefined'){
            this.options = options;
        }
        this.bindEvents();
    },

    bindEvents: function(){
        this.$rootElem.change(this.getData);
    },

    getData: function(){
        var date = new Date($(this).val());
        $.ajax({
            beforeSend: function(){
              $('body').mask('Loading...');
            },
            context: $(this).data('instance'),
            headers: {
                Accept : "application/json; charset=utf-8"
            },
            url: 'http://api.metrodigiweather.com',
            data: {
                timestamp: date.toISOString()
            },
            success: function(responseData, responseStatus, jqXhr){
                var event = jQuery.Event('addData');
                event.displayData = responseData;
                this.options.$dataTableDisplay.trigger(event);
            },
            complete: function(jqXhr, status){
                $('body').unmask();
            }
        });
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