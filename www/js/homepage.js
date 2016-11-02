function centeringElems(){
    var collection = $('.mygrid-centered > .col');
    var collectionW = 0;
    collection.each(function(){
        collectionW += $(this).outerWidth();
    })

    if(collectionW < $(window).width()){
        $('.mygrid-centered').css('left', (($(window).width() - collectionW) / 2));
    }else{
        $('.mygrid-centered').css('left', 0);
    }
}

$(window).on('resize', function(){
    centeringElems();
})
$(document).ready(function(){
    centeringElems();
});