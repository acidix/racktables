/*
*   Javascript for racktables bootstrap theme
*
*   needs:
*   - jquery
*   - enquiere
*/
// Setup page when loaded
// Setup namespace and intial global variables
// Create global messenger for inter modul communication
document.bootstrap_template = {};
document.bootstrap_template.event_messenger = [];
document.bootstrap_template.modal_window = null;
document.view_stack = [];
document.top_view = null;

(function($) {
    $(document).ready(function() { 
        prepareContent();
    });
})(jQuery);

// Add a callback for the error message
$.listen('parsley:field:error', function () {
    alert('Search must not be empty');
});

// Prepare content

function prepareContent(selector) {
    if(selector == null)
        selector = 'body'

    function $$(elem) {
        return $(selector).find(elem);
    }

    // Add glyphicons to all tabs
    var tabs = $$("li.tab");
    var maxchildren = 0;

    $$('.row.sidebar.tabbar').addClass('hidden-tabbar');
    for (var i = 0; i < tabs.length; i++) {
        $$('.row.sidebar.tabbar').removeClass('hidden-tabbar');

        var link = tabs.eq(i).children('a')[0].href;
        tabs.eq(i).prepend(getGlyphicon(tabs[i].id));

        tabs.eq(i).children().eq(0).attr('href', link);
        
        if(maxchildren < tabs.eq(i).children().eq(0).children().length)
            maxchildren = tabs.eq(i).children().eq(0).children().length;
    };
    $$('.tab-glyph').css('min-width', (maxchildren * 30) + 'px');
    var top_offset = 21;
    var userboxHeight = top_offset + $('.user-panel').outerHeight() + $('body > div > .sidebar-offcanvas > section > form').outerHeight();
    console.log('height is ' + userboxHeight);
    $$('.sidebar.tabbar > .sidebar-menu > li:first-of-type').css('height', userboxHeight + 'px' );
    // Set timeout for showing tab names
    var tabTimeout;
    $$('#tabsidebar').mouseenter(function() {
        if($$('#tabsidebar').hasClass('horizontal-tabbar'))
            return;

        tabTimeout = setTimeout(function() {
            $$(".tab-link").fadeIn("slow");
            $$('tabsidebar').css('posititon', 'fixed');
        }, 1000);
    }).mouseleave(function() {
        if($$('#tabsidebar').hasClass('horizontal-tabbar'))
            return;

        $$(".tab-link").hide();     
        clearTimeout(tabTimeout);
    });

    // Add all operators to bar on the left
    var operatorstabs = $$('.tab-operator');
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
            $$('.tabs-list').append( $('<li/>').addClass('operator-spacer'));
        }

        $$('.tabs-list').append( $('<li/>').addClass('tab tab-operator').attr('type', operatorstabs[i].type).append(operatorstabs.eq(i).clone()));
        
        // Add links if any 
        var test = ($$('.tabs-list').children().last().prepend(getGlyphicon(operatorstabs[i].id)))
        .children().eq(0).attr('href', operatorstabs[i].href);      
        operatorstabs.eq(i).remove();
    }
    
    // Check for orientation
    enquire.register("screen and (max-width:750px)", {
    match : function () {
        // Add css class to tabbar 
        $$('#tabsidebar').addClass('horizontal-tabbar');
        $$('.tab-link').css('display', 'inline-block');
        $$('.sidebar.tabbar > .sidebar-menu > li:first-of-type').css('height', '0px');
        if($$("li.tab").length > 1)
            $$('.highlight-ring').addClass('hidden-ring');
        //$('#contentarea').css('margin-left', '0px');
    },
    unmatch : function () {
        $$('#tabsidebar').removeClass('horizontal-tabbar');
        $$('.tab-link').css('display', 'inline-block');
        $$('body > div.wrapper.row-offcanvas.row-offcanvas-left.active.relative > aside.left-side.sidebar-offcanvas').css('top', '');
        var userboxHeight = top_offset + $('.user-panel').outerHeight() + $('body > div.wrapper.row-offcanvas.row-offcanvas-left > aside.left-side.sidebar-offcanvas > section > form').outerHeight();
        $$('.sidebar.tabbar > .sidebar-menu > li:first-of-type').css('height', userboxHeight + 'px' );
        if($$("li.tab").length > 1)
            $$('.highlight-ring').removeClass('hidden-ring');
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
            // console.log(tags_list);
            $$('input.ui-autocomplete-input.tagspicker')
            // Make size fixed
            .css('max-width', $('input.ui-autocomplete-input.tagspicker').css('height'))
            .select2({
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
                    // console.log("value is " +  tag_val);
                    $(this).closest('form').append('<input type="hidden" style="display:none;" value="' + tag_val + '" name="taglist[]">');                       
                }
                /*if(typeof(e.removed) != 'undefined') {
                    console.log(e.removed);
                } */
            }).on('change', function() {
                if(!$(this).data('select2').opened())
                    $(this).data('select2').open();
            });
        }
    }   // Adding tagspicker
    console.log('This is the setup function');

    // Check for ajax form 
    checkAjaxFormBtn();
    
    // Check for ajax href
    checkAjaxHrefBtn();

    // Set site view dragable
    setupSiteViewStack();

    // Set svgs 
    $$('svg').svgPan('viewport');

    $$('.ipv4-net-capacity-addr').knob({
        "readOnly": true,
        "width": 50,
        "height": 50
    });

    console.log('setting datatables');
    datatables = $$('table.table.datatable');
    for(var c = 0; c < datatables.length; c++) {
        tagsDataTable(datatables.eq(c));
    }


    console.log('setting links');
    // Add links
    $.each( $$(".content a"), function (key, element) {
        if(typeof($(element).attr('newview')) != 'undefined' || $(element).attr('href') == '')
            return;

        $(element).attr('newview', $(element).attr('href'));
        $(element).click(function (event) {
            event.preventDefault();
            addView($(element).attr('newview'));
        });
        $(element).attr('href', '');
    });

    $.each( $$(".view-adder"), function (key, element) {
        $(element).click(function () {
            addView($(element).attr('link'));
        });
        console.log($(element).attr('link'));
    });

}


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
        case 'ipv4spacemanage':
            return "<a class='tab-glyph'><span class='glyphicon glyphicon-minus'></span></a>";
        case 'rackspacehistory':
        case 'rowfiles':
        case 'ipv4netfiles':
        case 'reportsrackcode':
        case 'objectfiles':
            return "<a class='tab-glyph'><span class='glyphicon glyphicon-list-alt'></span></a>";
        case 'objectrackspace':
            return "<a class='tab-glyph'><span class='glyphicon glyphicon-align-justify'></span></a>";
        case 'uidefault':
        case 'reportsdefault':
            return "<a class='tab-glyph'><span class='glyphicon glyphicon-home'></span></a>";
        case 'uireset':
            return "<a class='tab-glyph'><span class='glyphicon glyphicon-flash'></span></a>";
        case 'confirm-btn':
            return "<a class='tab-glyph'><span class='glyphicon glyphicon-ok'></span></a>";
        case 'uiedit':
        case 'rackspaceeditrows':
        case 'ipv6spacemanage':
        case 'filesmanage':
        case 'ipv4netproperties':
        case 'rowedit':
        case 'objectedit':
        case 'portifcompatedit':
        case 'attrseditattrs':
        case 'userlistedit':
        case 'permsedit':
        case 'parentmapedit':
        case 'portmapedit':
        case '8021qvstlist':
        case 'cableconfcabletypes':
        case 'roweditracks':
        case 'portoifsedit':
        case 'dictchapters':
        case 'tagtreeedit':
        case 'cactiservers':
        case 'muninservers':
            return "<a class='tab-glyph'><span class='glyphicon glyphicon-edit'></span></a>";
        case 'abort-btn':
            return "<a class='tab-glyph'><span class='glyphicon glyphicon-remove'></span></a>";
        case 'reportsrackcode':
        case 'reportsintegrity':
            return "<a class='tab-glyph'><span class='glyphicon glyphicon-hdd'></span></a>";
        case 'attrseditmap':
        case 'cableconfconnectors':
            return "<a class='tab-glyph'><span class='glyphicon glyphicon-random'></span></a>";
        case 'reportswarranty':
            return "<a class='tab-glyph'><span class='glyphicon glyphicon-time'></span></a>";
        case '8021qdefault':
        case 'virtualdefault':
        case 'objectlogdefault':
        case 'rowdefault':
        case 'objectdefault':
        case 'ipv4netdefault':
        case 'portifcompatdefault':
        case 'attrsdefault':
        case 'myaccountinterface':
        case 'permsdefault':
        case 'parentmapdefault':
        case 'portmapdefault':
        case 'cableconfdefault':
        case 'portoifsdefault':
        case 'dictdefault':
        case 'tagtreedefault':
        case 'cactidefault':
        case 'munindefault':
            return "<a class='tab-glyph'><span class='glyphicon glyphicon-eye-open'></span></a>";
        case 'cableconfoifcompat':
            return "<a class='tab-glyph'><span class='glyphicon glyphicon-resize-full'></span></a>";
        case 'objectlog':
            return "<a class='tab-glyph'><span class='glyphicon glyphicon-list'></span></a>";
        case 'objectports':
        case 'reportsports':
            return "<a class='tab-glyph'><span class='glyphicon glyphicon-record'></span></a>";
        case 'objectnat4':
            return "<a class='tab-glyph'><strong class='glyphicon'>N4</strong></a>";
        case 'objectip':
            return "<a class='tab-glyph'><strong class='glyphicon'>IP</strong></a>";  
        case '8021qvdlist':
        case 'object8021qorder':
        case 'ipv4net8021q':
        case 'reports8021q':
            return "<a class='tab-glyph'><strong class='glyphicon'>Q</strong></a>"; 
        case 'ipv4netliveptr':
            return "<a class='tab-glyph'><strong class='glyphicon'>L</strong></a>";
        case 'reportsipv4':
            return "<a class='tab-glyph'><strong class='glyphicon'>4</strong></a>"; 
        case 'reportsipv6':
            return "<a class='tab-glyph'><strong class='glyphicon'>6</strong></a>";
        case 'myaccountmypassword':
            return "<a class='tab-glyph'><strong class='glyphicon glyphicon glyphicon-lock'></strong></a>";
        case 'myaccountdefault':
        case 'userlistdefault':
            return "<a class='tab-glyph'><strong class='glyphicon glyphicon glyphicon-user'></strong></a>";
        case 'myaccountqlinks':
        case 'cableconfconncompat':
            return "<a class='tab-glyph'><strong class='glyphicon glyphicon glyphicon-link'></strong></a>";
        case 'rowtagroller':
        case 'ipv4nettags':
        case 'objecttags':
            return "<a class='tab-glyph'><span class='glyphicon glyphicon-tag'></span></a>"; 
        default:
            return "<a class='tab-glyph'><span class='glyphicon glyphicon-exclamation-sign'></span></a>"; 
    }
}

function getOwnPage() {
    console.log('ownurl: ', document.URL.substring(document.URL.indexOf('index'), document.URL.indexOf('&tab')));
    return document.URL.substring(document.URL.indexOf('index'), document.URL.indexOf('&tab'));
}


function resizeView(event) {
    event.preventDefault();
}

function setupSiteViewStack() {
    // Setup stacking order of elements
    document.view_stack = $('#contentarea > .site-view');
    // Set z ordering 
    var z_start = 10;
    var z_step = 2;
    $('#contentarea > .site-view').each(function (idx) {
        $('#contentarea > .site-view').eq(idx).css('z-index', z_start + z_step * idx);
    }); 

    document.top_view = document.view_stack[document.view_stack.length - 1];

    if(document.view_stack.length == 1)
        return;

    document.top_view.intialSize = [
        $('#contentarea > .site-view').last().width(),
        $('#contentarea > .site-view').last().height(),
    ];

    $('#contentarea > .site-view').last().mousedown(function (event) {
        document.top_view.draged = true;
        document.top_view.lastPos = [event.pageX, event.pageY];

    })

    $('#contentarea').mousemove(function (event) {
        var act_view = document.top_view;

        if(act_view.draged) {
            
            var newWidth = $(act_view).width() + (act_view.lastPos[0] - event.pageX);
            
            if(newWidth < act_view.intialSize[0] * 0.5)   newWidth = act_view.intialSize[0] * 0.5; 

            var offsetRight = 1 - 0.05 * (document.view_stack.length - 1);
            if(newWidth > $(document.view_stack[document.view_stack.length - 2]).width() - 10 ) newWidth = $(document.view_stack[document.view_stack.length - 2]).width() - 10;
            $(act_view).width(newWidth);

            var newHeight = $(act_view).height() + (event.pageY - act_view.lastPos[1]);
            if(newHeight < act_view.intialSize[1])  newHeight = act_view.intialSize[1]; 
            //if(newHeight > $(this).height())        newHeight = $(this).height();
            $(act_view).height(newHeight);      
        
            act_view.lastPos = [event.pageX, event.pageY];
        }
    });

    $('body').mouseup(function (event) {
        document.top_view.draged = false;
        console.log("mouseup");
    });

    // Add remove button
    $('#contentarea').append('<button class="btn btn-default remove-view-btn" type=button style="margin: 10px;"><span class="glyphicon glyphicon-chevron-right"></span></button>');
    $('#contentarea > .remove-view-btn').css('z-index', z_start + z_step * document.view_stack.length);
    $('#contentarea > .remove-view-btn').click(function (event) {
        // That should never happend
        if(document.view_stack.length == 1) {
            console.info('Calling remove btn without additional views!')
            return;
        }

        $(document.top_view).animate(
                { right: '-' + ($(document.top_view).width() / 2) + 'px' },
                300,
                "linear",
                function () { 
                    $('#contentarea > .site-view').last().remove();
                    $('#contentarea > .remove-view-btn').remove();
                    setupSiteViewStack();
                }
            );
    });
}

function addView( link ) {
    console.log(link, document.URL);
    $.ajax({
        url: link,
        processData: false,
        contentType: false,
        type: 'POST',
        success: function(data){
            bodytxt = '<div id="body-mock">' + data.replace(/^[\s\S]*<body.*?>|<\/body>[\s\S]*$/g, '') + '</div>';
            var bodyelem = $(bodytxt);
            // Somehow crashes here ?!
            try {
                $('#contentarea').append(bodyelem.find('.site-view'));
            } catch (err) {
                console.error("append", err.message);
            }
            var new_elem = $('#contentarea > .site-view').last();

            // Make new view slide in
            new_elem.css('right', '-' + (new_elem.width() / 2) + 'px');
            new_elem.css('z-index', 1000);
            
            new_elem.animate(
                { right: "0px" },
                500,
                "linear",
                function () { 
                    prepareContent('#contentarea');
                }
            );
             
        }
    });
    
   // $('#contentarea').append('<div class="site-view">').css('background-color', 'red');
}


function getAlertContext() {
    if(document.bootstrap_template.modal_window != null)
        return document.bootstrap_template.modal_window;
    else 
        return $('.content');
}

function addAlertMessage(message) {
    console.log('adding alert message',document.bootstrap_template.modal_window);
    getAlertContext().prepend(message);
    
    setTimeout(function() {
        message.fadeOut();
        message.remove();
    }, 3000);
}


// Chech for ajax hrefs
function checkAjaxHrefBtn() {
    for(var i = 0; i < $('button.ajax_href').length; i++) {
        var btn = $('button.ajax_href').eq(i);
        btn.click(function (event){
            $.ajax({
                url: window.location.pathname + $(this).attr('href'),
                dataType: 'html',
                type: 'GET',
                success: function(data){
                    bodytxt = '<div id="body-mock">' + data.replace(/^[\s\S]*<body.*?>|<\/body>[\s\S]*$/g, '') + '</div>';
                    var bodyelem = $(bodytxt);
                    //console.log(data);
                    
                    if(bodyelem.find('.alert.alert-success').length > 0) {
                    //    form.attr('succeeded', 'true');
                        console.log('setting success!');
                        console.log(bodyelem.find('.alert.alert-success'));
                        //$('.content').html(bodyelem.find('.content').html());
                        //check_ajax_href_btn();
                    }
                    
                    // Issue an event to the messenger
                    document.bootstrap_template.event_messenger.push({ name: 'ajax_reguest', success : bodyelem.find('.alert.alert-success').length > 0});
                    
                    // If target to reload is set, set html
                    if(bodyelem.find('.alert.alert-success').length > 0 && btn.attr('reload-target') != "") {
                        $(btn.attr('reload-target')).html(bodyelem.find(btn.attr('reload-target')).html());
                       // $('.content').html(bodyelem.find('.content'));
                        // Load and evaluate javascript
                        //  var scripts = $(bodytxt).find('script');
                        // console.log('scripts are all', scripts);
                        prepareContent(btn.attr('reload-target'));
                        //for(var ind = 0; ind < scripts.length; ind++)
                        //   if(scripts[ind].src == "") {
                        //       console.log('script is', scripts[ind].innerHTML);
                        //       eval(scripts[ind].innerHTML);
                        //   }
                    }
                   
                    if(bodyelem.find('.alert').length > 0)
                        addAlertMessage(bodyelem.find('.alert'));
                    else
                        // Don't show full loaded pages
                        if(bodyelem.find('.content').length == 0)
                            addAlertMessage($('<div class="alert alert-danger"></div>').append(bodyelem));
                        else
                            getAlertContext().html(bodyelem.find('.content').html());
                }
            });    
        });
        console.log('setting ' + btn.attr('href'));
    }
}

// Check for ajax form 
function checkAjaxFormBtn() {
    for(var i = 0; i < $('button.ajax_form').length; i++) {
        var form = $('form[name=' + $('button.ajax_form').eq(i).attr('targetform') + ']');
        var btn = $('button.ajax_form').eq(i);
        form.submit(function (e) {
            e.preventDefault();
            // Check for validation
            if(form.find('input.live-validate').length != 0 && !form.find('input.live-validate').hasClass('validation-success')) {
                form.find('input.live-validate').tooltip('show');
                form.find('input.live-validate').hover(function () {
                    form.find('input.live-validate').tooltip('hide');
                });
                return;
            }
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
                    //console.log(data);
                    
                    if(bodyelem.find('.alert.alert-success').length > 0) {
                    //    form.attr('succeeded', 'true');
                        console.log('setting success!');
                        console.log(bodyelem.find('.alert.alert-success'));
                    }

                    // Issue an event to the messenger
                    document.bootstrap_template.event_messenger.push({ name: 'ajax_reguest', success : bodyelem.find('.alert.alert-success').length > 0});
                    
                    // If target to reload is set, set html
                    if(bodyelem.find('.alert.alert-success').length > 0 && btn.attr('reload-target') != "") {
                        $(btn.attr('reload-target')).html(bodyelem.find(btn.attr('reload-target')).html()); 
                        prepareContent(btn.attr('reload-target'));
                    }

                    if(bodyelem.find('.alert').length > 0)
                        addAlertMessage(bodyelem.find('.alert'));
                    else
                        // Don't show full loaded pages
                        if(bodyelem.find('.content').length == 0)
                            addAlertMessage($('<div class="alert alert-danger"></div>').append(bodyelem));
                        else
                            getAlertContext().html(bodyelem.find('.content').html());
                }
            });
        });
        console.log('set ajax form buttons');
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
function tagsDataTable(table_selector) {
    // Add tags to autocomplete
    // has to be done before tags are hidden    
    var taglist = [];
    var possTags = table_selector.find('tbody > tr .tag_small').children();
    
    //var possTags = $(table_selector + ' > tbody > tr > td > small').children();
    for (var i = 0; i < possTags.length; i++) {
        // No duplicates
        if($.inArray(possTags[i].innerHTML, taglist) === -1) taglist.push(possTags[i].innerHTML);
    };
    console.log('tags', taglist);
    var datatable = table_selector.DataTable();
    
    function split( val ) {
      return val.split( / \s*/ );
    }
    function extractLast( term ) {
      return split(term).pop();
    }

    var select2_input = table_selector.prev().find('input[type="text"]')
        // don't navigate away from the field on tab when selecting an item
        /*.autocomplete({
            minLength: 0,
            source: function( request, response ) {
                // delegate back to autocomplete, but extract the last term
                response( $.ui.autocomplete.filter(
                  taglist, extractLast( request.term ) ) );
            },
            select: function( event, ui ) {
                var terms = split( this.value, " " );
                // remove the current input
                terms.pop();
                // add the selected item
                terms.push( ui.item.value );
                // add placeholder to get the comma-and-space at the end
                terms.push( " " );
                this.value = terms.join( " " );
                
                // show next search
                console.log('select');
                return false;
            },
            change: function () {
                $(this).autocomplete('search',this.value);
            }
        }).css('margin-left', '10px')
        .bind( "keydown", function( event ) {
            if ( event.keyCode === $.ui.keyCode.TAB &&
                $( this ).autocomplete( "instance" ).menu.active ) {
                    event.preventDefault();
                }
        }).focus( function () {
            $(this).autocomplete('search',this.value);
        });*/
    .select2({
        tags: taglist,
        tokenSeparators: [",", " "]
    });
    select2_input.target_datatable = datatable;

    select2_input.on('change', function() {
        if(!$(this).data('select2').opened())
            $(this).data('select2').open();
     //   console.log('table', this.target_datatable);
     //   this.target_datatable.search($(this)[0].value);
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

function showDataEditDialog(title, content_selector, dialog_type) {
    var dialog_html = $(content_selector).children().clone();

    // Leave link to modal window data -
    document.bootstrap_template.modal_window = $(content_selector).children();
    BootstrapDialog.show({
        title: title,
        type: dialog_type,
        closeByBackdrop: false,
        draggable: true,
        message: $(content_selector).children(),
        onshown : function(dialogRef) {
            //var form = $('form[name=' + $('button.ajax_form').eq(0).attr('targetform') + ']');
            //form.attr('succeeded','false');
            // reset messenger
            document.bootstrap_template.event_messenger = [];
        },
        onhide: function(dialogRef) {
            // On hide reload the view if necessary
            //var form = $('form[name=' + $('button.ajax_form').eq(0).attr('targetform') + ']').eq(0);
            //console.log(form);
            var messenger = document.bootstrap_template.event_messenger;
            if(messenger.length > 0 && messenger[messenger.length - 1].success)
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
                        //console.log('javascript', $('.content').find('script').innerHTML());
                        /*dataTables = $('table.table.datatables');
                        for(var c = 0; c < dataTables.length; c++)
                            tagsDataTable(dataTables);*/
                        prepareContent('#contentarea');
                        //form.prepend(bodyelem.find('.alert'));
                    }
                });
            $(content_selector).append(this.message);
            document.bootstrap_template.modal_window = null;         
        },
    });   
}
 
// Show an adding dialog from template
function showAddDialog() {
    showDataEditDialog('Add new', '.addContainer', BootstrapDialog.TYPE_SUCCESS);
}

function showRemoveDialog() {
    showDataEditDialog('Edit rows', '.removeContainer', BootstrapDialog.TYPE_DANGER);
}


function highlightRacktables( text ) {
    var text_elems = $('g > a > text');
    for(var i = 0; i < text_elems.length; i++) {
        text_elem = text_elems.eq(i);
        console.log(text_elem.text() + " and " + text);

        if(text_elem.text().toLowerCase().indexOf(text.toLowerCase()) > -1 && text != "") {
            text_elem.siblings('rect').css('fill', 'yellow');
            text_elem.css('font-weight', 'bold');
        }
        else {
            text_elem.siblings('rect').css('fill', '');
            text_elem.css('font-weight', '');
        }

    }
}
