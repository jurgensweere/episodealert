jQuery(document).ready(function($) {
  $('#hd .leftButton').click(toggleMenu);
  mobileAZ();
  mobilePaginate();
  if( $('.browse-navigation').size() > 0) {$('.browse-navigation').show();}
  $('#transferarchive, #transferseries').remove();
})

function toggleMenu() {
    $('#hd .navigation').toggle();
    $('#hd .leftButton').toggleClass('pressed');
}

function mobileAZ() {
    if( $('.browse-navigation').size() == 0) return;

    $('.browse-navigation').append('<form class="browse"><label>Browse:</label><select></select></form>');
    $('.browse-navigation a').each( function(){
        var opt = $('<option>'+ $(this).html() +'</option>').appendTo('.browse-navigation form.browse select');
        opt.val($(this).attr('href'));
        if($(this).hasClass('active')) {
            opt.attr('selected', 'selected');
        }
        $(this).remove();
    });
    $('.browse-navigation form.browse select').change(function(){
        window.location.href = $("option:selected", this).val();
    });
}
function mobilePaginate(){
    if( $('.browse-navigation').size() == 0) return;
    $('.browse-navigation').append('<form class="paginate"><label>Page:</label><select></select></form>');
    var pages = $('.paginationControl').first().find('span, a');
    pages.first().remove();
    pages.last().remove();
    pages = $('.paginationControl').first().find('span, a'); //?
    pages.each(function(){
        var opt = $('<option>'+ $(this).html() +'</option>').appendTo('.browse-navigation form.paginate select');
        opt.val($(this).attr('href'));
        if($(this).hasClass('active')) {
            opt.attr('selected', 'selected');
        }
    });
    $('.browse-navigation form.paginate select').change(function(){
        window.location.href = $("option:selected", this).val();
    });
    $('.browse-paginator').remove();
}