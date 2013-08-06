var DataTableDisplay = {
    $rootElem: null,
    $tbody: null,
    $emptyTr: null,
    hadFills : false,
    init: function(options, elem){
        this.$rootElem = $(elem);
        this.prepElems();
        this.bindEvents();
    },

    prepElems: function(){
        this.$tbody = this.$rootElem.find('tbody');
        this.$emptyTr = this.$tbody.find('tr').clone();
    },

    addData: function(event){
        var
            data = event.displayData;
        if(data.success == true){ //TODO: this conditional should be handled by HTTP response codes up in the XHR request. Not here.
            var $row = ($(this).data('instance').hadFills == false) ? $(this).data('instance').$tbody.find('tr') :
                $(this).data('instance').$emptyTr.clone();
            $row.find('td.timestamp p').append(data.timestamp);
            $row.find('td.min-temp p').append(data.temp_min);
            $row.find('td.max-temp p').append(data.temp_max);
            $row.find('td.avg-temp p').append(data.temp_avg);

            if($(this).data('instance').hadFills == true){
                $(this).data('instance').$tbody.append($row);
            }

            $(this).data('instance').hadFills = true;
        } else {
            alert(data.errorMessage);
        }
    },

    bindEvents: function(){
        this.$rootElem.bind('addData', this.addData);
    }
};

(function($){
    $.fn.dataTableDisplay = function(options) {
        if ( this.length ) {
            return this.each(function(){
                // Create a new object via the Prototypal Object.create
                var obj = Object.create(DataTableDisplay);

                // Run the initialization function of the speaker
                obj.init(options, this); // `this` refers to the element

                // Save the instance of the speaker object in the element's data store
                $.data(this, 'instance', obj);
            });
        }
    };
})(jQuery);