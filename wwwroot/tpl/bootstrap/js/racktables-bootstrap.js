/*
*   Javascript for racktables bootstrap theme
*
*   needs:
*   - jquery
*   - enquiere
*/
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

        // Set timeout for showing tab names
        var tabTimeout;
        $('#tabsidebar').mouseenter(function() {
            if($('#tabsidebar').hasClass('horizontal-tabbar'))
                return;

            console.log("start timeout");
            tabTimeout = setTimeout(function() {
                $(".tab-link").fadeIn("slow");
            }, 1000);
        }).mouseleave(function() {
            if($('#tabsidebar').hasClass('horizontal-tabbar'))
                return;

            $(".tab-link").hide();     
            clearTimeout(tabTimeout);
        });
    
        // Add all operators to bar on the left
        var operatorstabs = $('.tab-operator');
        for (var i = 0; i < operatorstabs.length; i++) {
            switch(operatorstabs[i].type){
                case 'submit':
                    //Set target 
                    operatorstabs.eq(i).attr('href', 'javascript:$("' + operatorstabs[i].target.replace( /(:|=|\.|\[|\])/g, "\\\\$1" ) + '").submit();')  
                    break;
                case 'abort':
                    operatorstabs.eq(i).attr('href', 'javascript:history.go(0);')
                    break;
            }

            $('.operator-list').append( $('<li/>').append(operatorstabs.eq(i).clone()));

            // Add links if any 
            ($('.operator-list').children().last().prepend(getGlyphicon(operatorstabs[i].id)))
            .children().eq(0).attr('href', operatorstabs[i].href);
            operatorstabs.eq(i).remove();
        }

        // Check for orientation
        enquire.register("screen and (max-width:560px)", {
        match : function () {
            // Add css class to tabbar 
            $('#tabsidebar').addClass('horizontal-tabbar'); 
        },
        unmatch : function () {
            $('#tabsidebar').remove('horizontal-tabbar');
        }
        });

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
            return "<a class='tab-glyph'><span class='glyphicon glyphicon-home'></span></a>";
        case 'uireset':
            return "<a class='tab-glyph'><span class='glyphicon glyphicon-flash'></span></a>";
        case 'confirm-btn':
            return "<a class='tab-glyph'><span class='glyphicon glyphicon-ok'></span></a>";
        case 'uiedit':
        case 'rackspaceeditrows':
            return "<a class='tab-glyph'><span class='glyphicon glyphicon-edit'></span></a>";
        case 'abort-btn':
            return "<a class='tab-glyph'><span class='glyphicon glyphicon-remove'></span></a>";       
        default:
            return "<a class='tab-glyph'><span class='glyphicon glyphicon-exclamation-sign'></span></a>";
    }
}