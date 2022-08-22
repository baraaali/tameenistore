const csrf =  $('meta[name="csrf-token"]').attr('content');
const lang =  $('meta[name="lang"]').attr('content');
const user_id =  $('meta[name="user_id"]').attr('content');

var init = function (){
    searchAll()
    $('[data-toggle="tooltip"]').tooltip();
    $('.select2').select2();
    var items = $('.items').attr('items') ? parseInt( $('.items').attr('items')) : 4;
    var autoplayAttr = $('.items').attr('autoplayAttr') != 'false' ;
    var nav = $('.items').attr('nav') != 'false' ;
    var navText =  $('.items').attr('navText') == 'true' ? ['<i class="fas fa-chevron-left"></i>','<i class="fas fa-chevron-right"></i>'] : []
    var loopAttr = $('.items').attr('loopAttr') != 'false' ;
    $(".items").owlCarousel({
        items: items,
        loop:loopAttr,
        margin:10,
        navText:navText,
        autoplay:autoplayAttr,
        autoplayTimeout:2500,
        autoplayHoverPause:true,
        nav:nav,
        dots:false,
        responsiveClass:true,
        responsive:{
            0:{
                items:1,
                nav:true,
                autoplay:autoplayAttr,
                autoplayTimeout:2500,
            },
            600:{
                items:3,
                nav:true,
                autoplay:autoplayAttr,
                autoplayTimeout:2500,
            },
            1000:{
                items:items,
                nav:nav,
                autoplay:autoplayAttr,
                autoplayTimeout:2500,
            }
        }
     });
    $(".banners").owlCarousel({
           items:1,
           loop:true,
           margin:10,
           autoplay:true,
           autoplayTimeout:2500,
           autoplayHoverPause:true,
           nav:true,
           dots:false,
           
    }) 
    var items =  parseInt( $('.items-sub').attr('items')) ;
     $(".items-sub").owlCarousel({
           items:items,
           loop:true,
           margin:10,
           autoplay:true,
           autoplayTimeout:2500,
           autoplayHoverPause:true,
           nav:false,
           dots:false,
           
    })

    // $('#main_country').on('change',function(){
    //     if(parseInt($(this).val()) != parseInt($('#selected_country').val()))
    //     location.href = '/set-country/'+ $(this).val()
    // })

    $("#loading").hide()
}

$(document).ready(function(){
init()
})
// search into website function

function searchAll(){
   
    $('#search-field').on('input',function(){
        const searchValue = $(this).val();
        const output = $("#search-box ul")
        $.ajax({
            headers: {'X-CSRF-TOKEN': csrf},
            url: "/search/keyword",
            type:'post',
            data:{searchValue},
            success : function(res){
                let html = "";
                if(res.length){
                    const data = res.slice(0,10);
                    data.forEach(e=>{
                    const name = e[lang+'_name'] ? e[lang+'_name'] : e[lang+'_name']
                    let target = '';
                    if(e['_target'] === 'items'){
                        target = '/commercial-ad/'+e['id']+'/'+lang;

                    }else if( e['_target'] === 'cars' && e['sell'] == 1){
                        target = '/vehicles/sell/view/'+e['id']+'/'+lang;

                    }else if( e['_target'] === 'cars' && e['sell'] == 0){
                        target = '/vehicles/rent/view/'+e['id']+'/'+lang;

                    }else if( e['_target'] === 'mcenters'){
                        target = '/view/mcenters/profil/'+e['id']+'/'+lang;
                    }
                    else if( e['_target'] === 'services'){
                        target = '/services-single/items/'+e['id']+'/'+lang;
                    }
                    html += `<li class="list-group-item"><a href="${target}">${name}</a></li>`;
                    })
                }
                output.html(html);
            },
            error:function($e){
                console.log($e);
            }
        })
       
    })
}


// -----------------------------------------------------------------------

window.setLike = function($this,model)
{

    var ad_id  = parseInt($this.attr('ad_id'))
    if(user_id)
    {
    var data = {model:model,ad_id:ad_id}
    // console.log(data);
    $.ajax({
        headers: {'X-CSRF-TOKEN': csrf},
        url: "/actions/like",
        type:'post',
        data:data,
        success : function(res){
            if(res.heart == 1){
                $this.find('.heart').html('<i class="fa fa-heart text-danger mx-1" aria-hidden="true"></i>')
            }else{
                $this.find('.heart').html('<i class="far fa-heart text-danger mx-1" aria-hidden="true"></i>')
            }
            $this.find('.count').html(res.count)
        },
        error:function($e){
            console.log($e);
        }
    })
    }
}