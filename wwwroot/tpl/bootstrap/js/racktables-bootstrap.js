// Setup page when loaded
(function($) {
    $(document).ready(function() { 
        // Add glyphicons to all tabs
        var tabs = $("li.tab");

        for (var i = 0; i < tabs.length; i++) {
            var link = tabs.eq(i).children('a')[0].href;
            tabs.eq(i).prepend(getGlyphicon(tabs[i].id));
            tabs.eq(i).children().eq(0).attr('href', link);
        };
        $(".tab-link").hide();

        // Set timeout for showing tab names
        var tabTimeout;
        $('#tabsidebar').mouseenter(function() {
            console.log("start timeout");
            tabTimeout = setTimeout(function() {
                $(".tab-link").show();    
            }, 1000);
        }).mouseleave(function() {
            $(".tab-link").hide();     
            clearTimeout(tabTimeout);
        });
    
        // Add all operators to bar on the left
        var operatorstabs = $('.tab-operator');
        for (var i = 0; i < operatorstabs.length; i++) {
            $('.operator-list').append( $('<li/>').append(operatorstabs.eq(i).clone()));
            $('.operator-list').children().last().prepend(getGlyphicon(operatorstabs[i].id));
            operatorstabs.eq(i).remove();
        }
    });
})(jQuery);

// Add a callback for the error message
$.listen('parsley:field:error', function () {
    alert('Search must not be empty');
});

// Returns an corresponding glyphicon for the id
function getGlyphicon(glyphiconID) {
    console.log(glyphiconID);
    switch (glyphiconID){
        case 'rackspacedefault':
            return "<a class='tab-glyph'><span class='glyphicon glyphicon-search'></span></a>";
        case 'rackspaceeditlocations':
            return "<a class='tab-glyph'><span class='glyphicon glyphicon-bookmark'></span></a>";
        case 'rackspacehistory':
            return "<a class='tab-glyph'><span class='glyphicon glyphicon-list-alt'></span></a>";
        case 'uidefault':
            return "<a class='tab-glyph'><span class='glyphicon glyphicon-list-home'></span></a>";
        case 'uireset':
            return "<a class='tab-glyph'><span class='glyphicon glyphicon-list-flash'></span></a>";
        case 'confirm-btn':
            return "<a class='tab-glyph'><span class='glyphicon glyphicon-list-ok'></span></a>";
        case 'uiedit':
        case 'rackspaceeditrows':
            return "<a class='tab-glyph'><span class='glyphicon glyphicon-edit'></span></a>";
        case 'abort-btn':
            return "<a class='tab-glyph'><span class='glyphicon glyphicon-remove'></span></a>";       

    }
}