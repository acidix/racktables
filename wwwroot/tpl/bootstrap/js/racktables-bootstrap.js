// Setup elements on the site
$(document).ready(function() {
  $('.content .ipv4-net-capacity-addr').knob({
      "readOnly": true,
      "width": 50,
      "height": 50
  });
  setupTagsPicker();
});

// Setup tag picker
function setupTagsPicker(selector) {
  selector = selector || '.content';
  var ctx = $(selector);

  // Load tagpicker
  if(typeof(GLOBAL_TAGLIST) != 'undefined') {
      var tags_list = [];
      for (var key in GLOBAL_TAGLIST) {
          tags_list.push(GLOBAL_TAGLIST[key].tag);
      }

      if(tags_list.length > 0) {
          // console.log(tags_list);
          ctx.find('input.ui-autocomplete-input.tagspicker')
          // Make size fixed
          .css('max-width', ctx.find('input.ui-autocomplete-input.tagspicker').css('width'))
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
   }
}

// Make data table with tag completion
function tagsDataTable(table_selector) {

    // Add tags to autocomplete
    // has to be done before tags are hidden
    var taglist = [];
    var possTags = $(table_selector).find('tbody > tr .tag_small').children();

    //var possTags = $(table_selector + ' > tbody > tr > td > small').children();
    for (var i = 0; i < possTags.length; i++) {
        // No duplicates
        if($.inArray(possTags[i].innerHTML, taglist) === -1) taglist.push(possTags[i].innerHTML);
    };
    console.log('tags', taglist);

    var datatable = $(table_selector).DataTable();

    function split( val ) {
      return val.split( / \s*/ );
    }
    function extractLast( term ) {
      return split(term).pop();
    }

    // Not working for multiple datatables in content
    var css_settings = $('.content').attr('class')
    var select2_input = $('.content').find('input[type="search"]')
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

    select2_input.on('change', function(new_value) {
        if(!$(this).data('select2').opened())
            $(this).data('select2').open();

        var input_field = $(this);
        $(table_selector).DataTable().search(input_field.select2("val")).draw() ;
     //   console.log('table', this.target_datatable);
     //   this.target_datatable.search($(this)[0].value);
   });
   //select2_input.attr('class', css_settings);

   $('.content').find('input[type="search"]').hide();
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

function resetDataTable() {
  // Reset rackcode and submit empty request to clear filters
  $('#rackcodeconsole').val("");
  $('form.rackcode-form').submit();
}

function getOwnPage() {
    console.log('ownurl: ', document.URL.substring(document.URL.indexOf('index'), document.URL.indexOf('&tab')));
    return document.URL.substring(document.URL.indexOf('index'), document.URL.indexOf('&tab'));
}


function loadNewtab(href, doSmooth) {
    doSmooth = doSmooth || false;
    console.log('Loading tab', href);

    $.post(href).done(
        function(data){
            // Save history state
            history.pushState({}, $('tab.active > a.tab-link').innerHTML, href);

            bodytxt = '<div id="body-mock">' + data.replace(/^[\s\S]*<body.*?>|<\/body>[\s\S]*$/g, '') + '</div>';
            var bodyelem = $(bodytxt);
            // Somehow crashes here ?!
            try {


                $('#contentarea').html(bodyelem.find('#contentarea').html());
                if(doSmooth == true) {
                    $('#contentarea').hide();
                    $('#contentarea').fadeIn();
                }

            } catch (err) {
                console.error("Error in loadNewtab:", err.message);
                return;
            }

            prepareContent('#contentarea');
        }
    );
}
