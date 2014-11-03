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

        var maxchildren = 0;
        for (var i = 0; i < tabs.length; i++) {
            var link = tabs.eq(i).children('a')[0].href;
            tabs.eq(i).prepend(getGlyphicon(tabs[i].id));

            tabs.eq(i).children().eq(0).attr('href', link);
            
            if(maxchildren < tabs.eq(i).children().eq(0).children().length)
                maxchildren = tabs.eq(i).children().eq(0).children().length;
        };
        $('.tab-glyph').css('min-width', (maxchildren * 30) + 'px');
        var userboxHeight = 20 + $('.user-panel').outerHeight() + $('body > div > .sidebar-offcanvas > section > form').outerHeight();
        console.log('height is ' + userboxHeight);
        $('.sidebar.tabbar > .sidebar-menu:first-child').css('margin-top', userboxHeight + 'px' );
        // Set timeout for showing tab names
        var tabTimeout;
        $('#tabsidebar').mouseenter(function() {
            if($('#tabsidebar').hasClass('horizontal-tabbar'))
                return;

            tabTimeout = setTimeout(function() {
                 $(".tab-link").fadeIn("slow");
                 $('tabsidebar').css('posititon', 'fixed');
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
            if(i == 0) {
                $('.tabs-list').append( $('<li/>').addClass('operator-spacer'));
            }

            $('.tabs-list').append( $('<li/>').addClass('tab tab-operator').attr('type', operatorstabs[i].type).append(operatorstabs.eq(i).clone()));
            
            // Add links if any 
            var test = ($('.tabs-list').children().last().prepend(getGlyphicon(operatorstabs[i].id)))
            .children().eq(0).attr('href', operatorstabs[i].href);
            
            
            operatorstabs.eq(i).remove();
        }
        
        //$('.tabs-glyph').css('width', maxwidth + 'px');
        //console.log('max width is' + maxwidth);
        //$('#contentarea').css('margin-left', $('#tabsidebar').css('width'));
        // Check for orientation
        enquire.register("screen and (max-width:750px)", {
        match : function () {
            // Add css class to tabbar 
            $('#tabsidebar').addClass('horizontal-tabbar');
            $('.tab-link').css('display', 'inline-block');
            //$('#contentarea').css('margin-left', '0px');
        },
        unmatch : function () {
            $('#tabsidebar').addClass('horizontal-tabbar');
            $('.tab-link').css('display', 'inline-block');
            $('body > div.wrapper.row-offcanvas.row-offcanvas-left.active.relative > aside.left-side.sidebar-offcanvas').css('top', '');
            //$('#contentarea').css('margin-left', $('#tabsidebar').css('width'));
        }
        });

        // Load tagpicker 
        
        if(typeof(GLOBAL_TAGLIST) != 'undefined') {
            var tags_list = [];
            for (var key in GLOBAL_TAGLIST) {
                tags_list.push(GLOBAL_TAGLIST[key].tag);
            }

            if(tags_list.length > 0) {
                console.log(tags_list);

                $('input.ui-autocomplete-input.tagspicker').select2({
                    tags: tags_list,
                    tokenSeparators: [",", " "]
                }).on('change', function (e){
                    // Added the tags to add
                    if(typeof(e.added) != 'undefined') {
                        console.log(e.added);
                        // Check if existing
                        var tag_val = 0;
                        if(!$.inArray(e.text, tags_list)) {
                            console.log("id not known");
                            return 0;
                        }
                        // Get id
                        for( var tag_key in GLOBAL_TAGLIST ) {
                            if( GLOBAL_TAGLIST[tag_key].tag == e.added.id ) {
                                tag_val = GLOBAL_TAGLIST[tag_key].id;
                            }
                        }

                        console.log("value is " +  tag_val);
                        $('form[name="add"]').append('<input type="hidden" style="display:none;" value="' + tag_val + '" name="taglist[]">');
                        
                    }
                    if(typeof(e.removed) != 'undefined') {
                        console.log(e.removed);
                    }

                });
            }
        }   // Adding tagspicker
        console.log('This is the setup function');

        // Check for ajax form 
        for(var i = 0; i < $('button.ajax_form').length; i++) {
            console.log($('button.ajax_form').eq(i).attr('targetform'));
            var form = $('form[name=' + $('button.ajax_form').eq(i).attr('targetform') + ']');
            console.log(form);

            form.submit(function (e) {
                e.preventDefault();
                var fd = new FormData($(this)[0]);
                $.ajax({
                    url: window.location.pathname + form.attr('action'),
                    data: fd,
                    processData: false,
                    contentType: false,
                    type: 'POST',
                    success: function(data){
                        bodytxt = '<div id="body-mock">' + data.replace(/^[\s\S]*<body.*?>|<\/body>[\s\S]*$/g, '') + '</div>';
                        var bodyelem = $(bodytxt);
                        console.log(data);
                        
                        if(bodyelem.find('.alert.alert-success').length > 0) {
                            form.attr('succeeded', 'true');
                            console.log('setting success!');
                            console.log(bodyelem.find('.alert.alert-success'));
                        }
                        form.prepend(bodyelem.find('.alert'));
                    }
                });
            });
            console.log('sended ajax');
        }

        // Set svgs 
        $('svg').svgPan('viewport');
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
        case 'depotdefault':
        case 'ipv4spacedefault':
        case 'ipv6spacedefault':
        case 'filesdefault':
            return "<a class='tab-glyph'><span class='glyphicon glyphicon-search'></span></a>";
        case 'rackspaceeditlocations':
            return "<a class='tab-glyph'><span class='glyphicon glyphicon-bookmark'></span></a>";
        case 'depotaddmore':
        case 'ipv4spacenewrange':
        case 'ipv6spacenewrange':
        case 'rownewrack':
            return "<a class='tab-glyph'><span class='glyphicon glyphicon-plus'></span></a>";
        case 'rackspacehistory':
        case 'rowfiles':
        case 'reportsrackcode':
            return "<a class='tab-glyph'><span class='glyphicon glyphicon-list-alt'></span></a>";
        case 'uidefault':
            return "<a class='tab-glyph'><span class='glyphicon glyphicon-home'></span></a>";
        case 'uireset':
            return "<a class='tab-glyph'><span class='glyphicon glyphicon-flash'></span></a>";
        case 'confirm-btn':
            return "<a class='tab-glyph'><span class='glyphicon glyphicon-ok'></span></a>";
        case 'uiedit':
        case 'rackspaceeditrows':
        case 'ipv4spacemanage':
        case 'ipv6spacemanage':
        case 'filesmanage':
        case 'rowedit':
            return "<a class='tab-glyph'><span class='glyphicon glyphicon-edit'></span></a>";
        case 'abort-btn':
            return "<a class='tab-glyph'><span class='glyphicon glyphicon-remove'></span></a>";       
        case 'reportsrackcode':
            return "<a class='tab-glyph'><span class='glyphicon glyphicon-hdd'></span></a>"; 
        case 'reportsintegrity':
            return "<a class='tab-glyph'><span class='glyphicon glyphicon-hdd'></span></a>";  
        case 'reportswarranty':
            return "<a class='tab-glyph'><span class='glyphicon glyphicon-time'></span></a>";  
        case '8021qdefault':
        case 'virtualdefault':
        case 'objectlogdefault':
        case 'rowdefault':
            return "<a class='tab-glyph'><span class='glyphicon glyphicon-eye-open'></span></a>";  
        case '8021qvdlist':
            return "<a class='tab-glyph'><span class='glyphicon glyphicon-edit'></span><span class='glyphicon glyphicon-home'></span></a>";  
        case 'rowtagroller':
            return "<a class='tab-glyph'><span class='glyphicon glyphicon-tag'></span></a>";   
        case 'roweditracks':
            return "<a class='tab-glyph'><span class='glyphicon glyphicon-edit'></span><span class='glyphicon glyphicon-home'></span></a>";   
        case '8021qvstlist':
            return "<a class='tab-glyph'><span class='glyphicon glyphicon-edit'></span><span class='glyphicon glyphicon-align-justify'></span></a>";  
        default:
            return "<a class='tab-glyph'><span class='glyphicon glyphicon-exclamation-sign'></span></a>";
        
    }
}

function showConsoleBtns(rackconsole) {
    if(this.finished == true)
        return;
    this.finished = true;
  
    $('.rackcode-console-btn-overlay').css('width', $(rackconsole).css('width'));
    $('.rackcode-console-btn-overlay').css('top', (parseInt($(rackconsole).outerHeight()) +21) + "px");
    $('.rackcode-console-btn-overlay').fadeIn();
    $(window).resize(function() {
        $('.rackcode-console-btn-overlay').css('width', $(rackconsole).css('width'));   
    });
}

// Make data table with tag completion
function tagsDataTable(table_id) {
    // Add tags to autocomplete
    // has to be done before tags are hidden    
    var taglist = [];
    var possTags = $('#' + table_id + ' > tbody > tr > td > small > a');
    for (var i = 0; i < possTags.length; i++) {
        // No duplicates
        if($.inArray(possTags[i].innerHTML, taglist) === -1) taglist.push(possTags[i].innerHTML);
    };
    
    var datatab = $('#' + table_id).dataTable();
    
    function split( val ) {
      return val.split( / \s*/ );
    }
    function extractLast( term ) {
      return split( term ).pop();
    }
 
    $( '#' + table_id + '_filter > label > input[type="text"' )
      // don't navigate away from the field on tab when selecting an item
      .bind( "keydown", function( event ) {
        if ( event.keyCode === $.ui.keyCode.TAB &&
            $( this ).autocomplete( "instance" ).menu.active ) {
          event.preventDefault();
        }
      })
      .autocomplete({
        minLength: 0,
        source: function( request, response ) {
          // delegate back to autocomplete, but extract the last term
          response( $.ui.autocomplete.filter(
            taglist, extractLast( request.term ) ) );
        },
        select: function( event, ui ) {
          var terms = split( this.value );
          // remove the current input
          terms.pop();
          // add the selected item
          terms.push( ui.item.value );
          // add placeholder to get the comma-and-space at the end
          terms.push( "" );
          this.value = terms.join( " " );
          return false;
        }
      }).focus(function(){            
        $(this).autocomplete('search');
    });
}

function clearForm( form_name ) {
    console.log(form_name);
    $(':input',form_name.selector)
      .not(':button, :submit, :reset, :hidden')
      .val('')
      .removeAttr('checked')
      .removeAttr('selected');
}

function showAddDialog() {
    var dialog_html = $('.addcontainer').children().clone()

    BootstrapDialog.show({
        title: 'Add new',
        type: BootstrapDialog.TYPE_SUCCESS,
        closeByBackdrop: true,
        draggable: true,
        message: $('.addcontainer').children(),
        onshown : function(dialogRef) {
            var form = $('form[name=' + $('button.ajax_form').eq(0).attr('targetform') + ']');
            form.attr('succeeded','false');
        },
        onhide: function(dialogRef) {
            // On hide reload the view if necessary
            var form = $('form[name=' + $('button.ajax_form').eq(0).attr('targetform') + ']').eq(0);
            console.log(form);
            if(typeof(form.attr('succeeded')) != "undefined" && form.attr('succeeded') == "true")
                //Load the page new 
                $.ajax({
                    url: document.URL,
                    processData: false,
                    contentType: false,
                    type: 'POST',
                    success: function(data){
                        bodytxt = '<div id="body-mock">' + data.replace(/^[\s\S]*<body.*?>|<\/body>[\s\S]*$/g, '') + '</div>';
                        var bodyelem = $(bodytxt);
                        console.log('setting new content');
                        $('.content').html(bodyelem.find('.content').html());
                        //form.prepend(bodyelem.find('.alert'));
                    }
                });

            $('.addcontainer').append(dialog_html);
                      
        },
    });
}

function highlightRacktables( text ) {
    var text_elems = $('g > a > text');
    for(var i = 0; i < text_elems.length; i++) {
        text_elem = text_elems.eq(i);
        console.log(text_elem.text() + " and " + text);

        if(text_elem.text().indexOf(text) > -1 && text != "") {
            text_elem.siblings('rect').css('fill', 'yellow');
            text_elem.css('font-weight', 'bold');
        }
        else {
            text_elem.siblings('rect').css('fill', '');
            text_elem.css('font-weight', '');
        }

    }
}
