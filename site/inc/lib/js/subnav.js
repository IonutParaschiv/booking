$('.subnav_node').click(function(){
    var node = $(this);
    var target = node.attr('data-target');
    var items = $('.submenu_item');

    items.addClass('hidden');
    $('.stackedNav li').removeClass('active');
    node.parent('li').addClass('active');
    $('.'+target).removeClass('hidden').addClass('visible');
    console.log(target);
});