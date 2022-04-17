function __adianti_input_fuse_search(input_search, attribute, selector)
{
    setTimeout(function() {
        var stack_search = [];
        var search_attributes = [];
        attribute.split(',').forEach( function(v,k) {
            search_attributes.push( v );
        });
        
        $(selector).each(function() {
            var row = $(this);
            var search_data = {};
            
            search_data['id'] = $(this).attr('id');
            search_attributes.forEach( function(v,k) {
                search_data[v] = $(row).attr(v);
            });
            stack_search.push(search_data);
        });
        
        var fuse = new Fuse(stack_search, {
            keys: search_attributes,
            id: 'id',
            threshold: 0.2
        });
            
        $(input_search).on('keyup', function(){
            if ($(this).val()) {
                var result = fuse.search($(this).val());
                
                search_attributes.forEach( function(v,k) {
                    $(selector + '['+v+']').hide();
                });
                
                if(result.length > 0) {
                    for (var i = 0; i < result.length; i++) {
                        var query = '#'+result[i].item.id;
                        $(query).show();
                    }
                }
            }
            else {
                search_attributes.forEach( function(v,k) {
                    $(selector + '['+v+']').show();
                });
            }
        });
    }, 10);
}

function number_format (number, decimals, dec_point, thousands_sep) {
    // Strip all characters but numerical ones.
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}

Adianti.showDebugPanel = function() {
    $('#adianti_debug_panel').show();
    $('.content-wrapper').css('padding-bottom', '200px');
};

Adianti.hideDebugPanel = function() {
    $('#adianti_debug_panel').hide();
    $('.content-wrapper').css('padding-bottom', '0');
};

var pretty = {};
pretty.json = {
   replacer: function(match, pIndent, pKey, pVal, pEnd) {
      var key = '<span class=json-key>';
      var val = '<span class=json-value>';
      var str = '<span class=json-string>';
      var r = pIndent || '';
      if (pKey)
         r = r + key + pKey.replace(/[": ]/g, '') + '</span>: ';
      if (pVal)
         r = r + (pVal[0] == '"' ? str : val) + pVal + '</span>';
      return r + (pEnd || '');
      },
   print: function(obj) {
      var jsonLine = /^( *)("[\w]+": )?("[^"]*"|[\w.+-]*)?([,[{])?$/mg;
      return JSON.stringify(obj, null, 3)
         .replace(/&/g, '&amp;').replace(/\\"/g, '&quot;')
         .replace(/</g, '&lt;').replace(/>/g, '&gt;')
         .replace(jsonLine, pretty.json.replacer);
      }
   };

Template.updateDebugPanel = function() {
    try {
        var url  = Adianti.requestURL;
        var body = Adianti.requestData;
        url = url.replace('engine.php?', '');
        $('#request_url_panel').html( pretty.json.print(__adianti_query_to_json(urldecode(url)), undefined, 4) );
        $('#request_data_panel').html( pretty.json.print(__adianti_query_to_json(urldecode(body)), undefined, 4) );
    }
    catch (e) {
        console.log(e);
    }
}

Template.onAfterLoad = function(url, data) {
    Template.updateDebugPanel();
    
    let view_width     = $( document ).width() >= 800 ? 780 : ($( document ).width());
    let curtain_offset = $( document ).width() >= 800 ? 20  : 0;
    
    if ((url.indexOf("target_container=adianti_right_panel") !== -1) || (data.indexOf('adianti_target_container="adianti_right_panel"') !== -1) ) {
        var right_panels = Math.max($('#adianti_right_panel').find('[page_name]').length,1);
        
        $('#adianti_right_panel').css('width', (view_width + curtain_offset) + 'px');
        
        if ($('#adianti_right_panel').is(":visible") == false) {
            $('body').css("overflow", "hidden");
            $('#adianti_right_panel').show('slide',{direction:'right'}, 320);
        }
        
        $('#adianti_right_panel').css('width', (view_width + (curtain_offset * right_panels)) + 'px');
        
        if (curtain_offset > 0) {
            $('#adianti_right_panel').find('[page_name]').each(function(k,v) {
                $(v).css('left', (k * 20) + 'px');
            });
        }
        
        if (right_panels > 1) {
            let current_page_name = ($('#adianti_right_panel').find('[page_name]').last().attr('page_name'));
            if (data.indexOf('page_name="'+current_page_name+'"') == -1) // avoid slide again if top curtain = requested one
            {
                $('#adianti_right_panel').find('[page_name]').last().hide();
                $('#adianti_right_panel').find('[page_name]').last().show('slide',{direction:'right'}, 320);
            }
        }
        
        var warnings = $('#adianti_right_panel').clone().find('div[page_name],script').remove().end().html();
        $('#adianti_right_panel').find('[page_name]').last().prepend(warnings);
        
    }
    else if ( (url.indexOf('&static=1') == -1) && (data.indexOf('widget="TWindow"') == -1) ) {
        if ($('#adianti_right_panel').is(":visible")) {
            $('#adianti_right_panel').hide();
            $('#adianti_right_panel').html('');
            $('body').css('overflow', 'unset');
        }
    }
};

Template.onAfterPost = Template.onAfterLoad;

Template.closeRightPanel = function () {
    let view_width     = $( document ).width() >= 800 ? 780 : ($( document ).width());
    let curtain_offset = $( document ).width() >= 800 ? 20  : 0;
    
    if ($('#adianti_right_panel').find('[page_name]').length > 0) {
        if ($('#adianti_right_panel').find('[page_name]').length == 1) {
            $('#adianti_right_panel').hide('slide',{direction:'right', complete: function() {
                $('body').css('overflow', 'unset');
                $('#adianti_right_panel').html('');
            }},320)
        }
        
        $('#adianti_right_panel').find('[page_name]').last().hide('slide',{direction:'right', complete: function() {
            $('#adianti_right_panel').find('[page_name]').last().remove();
            var right_panels = Math.max($('#adianti_right_panel').find('[page_name]').length,1);
            $('#adianti_right_panel').css('width', (view_width + (curtain_offset * right_panels)) + 'px');
        }}, 320);
    }
}
