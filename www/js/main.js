function showMenu(){
    if(!$('.menu').data('isShow')){
        $('.menu').removeClass('center').addClass('left').data('isShow', true);
        $('.logo').show(500);
    }
}

function hideMenu(){
    $('.logo').hide(500);
    $('.menu').removeClass('left').addClass('center').data('isShow', false);
}

function fixHeader(){
    $('.header').addClass('fixed').css('top', -($('.header').height() - 64));
}

function unfixHeader(){
    $('.header').removeClass('fixed');
}

$(window).on('scroll', function(){
    if($(window).scrollTop() > ($('.header').height() - 64)){
        if(!$('.header').hasClass('fixed')){
            showMenu();
            fixHeader();
        }
    }else{
        if($('.menu').data('isShow')){
            hideMenu();
            unfixHeader();
        }
    }

    $('.section .title').each(function(){
        if($(window).scrollTop() > $(this).offset().top - $('.nav').height() && !$(this).hasClass('cloned')){
            $(this).addClass('cloned');
            $(this).clone().attr('id', 'clon-'+$(this).attr('id')).addClass('clon').addClass('truncate').appendTo($('body')).data('cloned-from', $(this).attr('id'));
        }else if($(window).scrollTop() < $(this).offset().top - $('.nav').height() && $(this).hasClass('cloned')){
            $(this).removeClass('cloned');
            $('#clon-'+$(this).attr('id')).remove();
        }

    });
});
$('#to-top').click(function(){
    $('html, body').animate({
        scrollTop: 0
    }, 500);
})
$(document).ready(function(){
    $(".button-collapse").sideNav();
    $('.collapsible').collapsible();
});