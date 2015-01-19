/**
 * Created by Rw.
 * @author Rw
 * @year 2014
 */

(function ($) {

    // extend object with other object
    var _extend = function (defaults, options) {
        if (typeof defaults !== "object" || typeof options !== "object") {
            return {};
        }

        for (var i in options) {
            if (options.hasOwnProperty(i)) {
                for (var x in defaults) {
                    if (x !== i) {
                        defaults[i] = options[i];
                    }
                }
            }
        }

        return defaults;
    },
        // Check given variable is array
        isArray = function(__var) {
        if (Object.prototype.toString.call(__var) === '[object Array]') {
            return true;
        }
        return false;
    };

    // Pushify
    var pushify = function (pushed) {
        var self = $(this),
            pushed = pushed || true,
            re = new RegExp(location.origin + '\/');

        $('.navbar-nav li').removeClass('active');
        self.closest('li').addClass('active');
    
         var anchorURL = ($(this).attr('href') || location.href);
         
        if (anchorURL.indexOf(location.origin) < 0) {
            location.href = anchorURL;
        }

        if (pushed != "false") {
            history.pushState(null, null, anchorURL);
        }

        var data = {
            requested: location.href,
            _token: __tmsOBJ._token
        };

        if (self.data('action')) {
            data.action = self.data('action');
        }

        $.ajax({
            type: 'GET',
            url: __tmsOBJ.__tmsBaseURI + '/ajax',
            data: data,
            error: function(jqxhr, status, data) {
               switch (jqxhr.status) {
                    case 401:
                        window.location.replace(__tmsOBJ.__tmsBaseURI + '/login');
                     break;
                    default:
                        break;
                }
            },
            complete: function (data) {
                try {
                    var jsonData = JSON.parse(data.responseText);
                    switch (jsonData.action) {
                        case 'logout':
                            history.pushState(null, null, __tmsOBJ.__tmsBaseURI + '/login');
                            document.write(jsonData.template);
                            break;
                        default:
                            break;
                    }
                } catch (e) {
                    $('#page-wrapper').empty().html(data.responseText);
                }
                tableSorter()
            }
        });
    };

    $(document).on('click', 'a', function (e) {
        e.preventDefault();

        var self = $(this),
            invalidhref = [
                "#",
                "javascript",
                "file",
                "ftp",
                "sftp"
            ],
            determineInvalid = false;

        invalidhref.map(function(value) {
            if (self.prop('href').indexOf(value) > -1) {
                determineInvalid = true;
                return false;
            }
        });

        if (determineInvalid === false) {
            pushify.call(this);
        }
    });

    $(window).bind('popstate', function(e) {
        pushify.call(this, "false");
    });
    
   // Script for table sort plugin//
        function tableSorter() {
            $("table").tablesorter();
        }
        
        tableSorter();

         ///// Script for handling delete ///
         $(document).on("click", "#project-table .btn.btn-danger", function(e) {
            
           e.preventDefault();
             var self = $(this);
           
               $.post(
                __tmsOBJ.__tmsBaseURI + '/delete-record',
                {
                    "_token": $( this ).attr( 'data-session-id' )  ,
                    "id": $( this ).attr( 'data-delete-id' ) ,
                    "page" :  $( this ).attr( 'data-page' )
               }, function() {
                   self.closest('tr').remove();
               });
         
        });
        
        
        
           ///// Script for handling Convo Messages ///
         $(document).on("click", "#convo-message", function(e) {
            
           e.preventDefault();
             var self = $(this);
             
             var ticket_id = $("#ticket-id").val() ; 
             var msg = $("#text-box").val() ; 
             var _token = $("input[name='_token']").val() ; 
             var user_id = $("#user-id").val() ;
             $.post(
                __tmsOBJ.__tmsBaseURI + '/convo-message',
                {
                    "_token":_token ,
                    "msg":msg ,
                    "ticket_id" :  ticket_id, 
                    "user_id" :  user_id
                }, function(data) {
                    
             if(data!=="invalid input")
                 {
                      var obj = $.parseJSON(data) ; 
                     
                        var html = '<blockquote class="convo-message"><p>' +
                         obj.msg +'.</p><small>'+ '  By  ' +  obj.name  +  '  At  ' +  obj.time  +'</small></blockquote>'; 
    
                    $( "#convo-box" ).append(html);
                    $("#not-available").remove();
                 } else { $( "#error-msg" ).show(); }
                });
            
          
        });
    
    var alreadyOpened = false;  
    $("#ticket_bread").click(function(){
        if (!alreadyOpened) {
            alreadyOpened = false;
            $("ul.side-nav").children().eq(1).toggleClass("open");
           
        } else {
            alreadyOpened = true;
            //$("ul.side-nav").children().eq(1).removeClass("open");
        }
    });
    
    


/*var select = document.getElementById("components");
select.onchange = function(){
    var selected_value = select.options[select.selectedIndex].value;
    
if(selected_value=="empty") {
   // $("#privatecourse").val('no');}

     }
  }
 */
}(jQuery));