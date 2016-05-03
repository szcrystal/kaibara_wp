(function($) {

var szcExec = (function() {
    
	return {
    
        opts: {
            crtClass: 'current',
            btnID: '.top_btn',
            all: 'html, body',
        },

        addCurrent: function() {
            var url = window.location;
            $('.main-navigation a[href="'+url+'"]').addClass(this.opts.crtClass);
        },


        scrollFunc: function() {
            var t = this,
                tb = $(t.opts.btnID);
            
            tb.css('display','none').on('click', function() {
                $(t.opts.all).animate({ scrollTop:0 }, 'normal');
            });

            $(document).scroll(function(){

                if($(this).scrollTop() < 200)
                    tb.fadeOut(200);
                else 
                    tb.fadeIn(300);
                    //$(this).stop();
            });
            
        },
        
        setMapHeight: function(e) {
        	var mapWidth = $('.map').width();
            var mapHeight = mapWidth * 0.64; // 0.64: main-map.pngの高さ(640px) mapのwidth:1000の64%が縦サイズになる
                        
            //if(mapWidth <= 1000 || e.data.orientChange) {
            	
                $('.map').css({height:mapHeight +'px'}); //mapに縦サイズをセットする
                
                var ww = mapWidth/1000; //縮小率
                                
                var divLen = $('.map > div').length; 
                var n = 0;
                
                while(n < divLen) {
                	var $div = $('.map > div').eq(n);
                	var $img = $div.find('img');
                	//var imgw = $img.width();
                    //var divTop = $div.position().top;
                    //var divLeft = $div.position().left;
                    
                    var imgw = $img.attr('width');
                    var divTop = $div.data('top');
                    var divLeft = $div.data('left');
                    
                    $div.css({top:divTop*ww, left:divLeft*ww});
                    
                	$img.css({width:imgw * ww});
                	
                    n++;
                }
            //}
            
            //console.log('mapheight ' + $('.map').height() );
        },
        
//        aaa: function(e) {
//        	$("h2").text(e.data.str);
//        },
        
        changeSizeAndPosiMapImg: function() { //w: map width
            
            //$(window).on('load', this.setMapHeight);
            
            //resizeで入れればorientationは不要
            $(window).on('resize', this.setMapHeight);
            //$(window).on('orientationchange', this.setMapHeight);
            $(window).on('orientationchange', {orientChange: true}, this.setMapHeight);
            
            //var text = "abcde";
            //$(document).on('scroll', {str: text}, this.aaa);
            //Objectを引数として渡せば、コールバック関数（ハンドラー）内のe.data.strとして取得できる
        },
        
        slideMenu: function() {
        	$('.tgl').on('click', function(){
            	var $nav = $('.main-navigation');
                
                $nav.slideToggle(300);
                
//            	if($nav.is(':hidden')) {
//                	$nav.slideDown(300);
//                }
//                else {
//                	$nav.slideUp(300);
//                }
            });	
        },
                
        
        isAgent: function(user) {
            if( navigator.userAgent.indexOf(user) > 0 ) return true;
        },
        
        isSpTab: function() {
        	var arr = ['iPhone','iPod','Mobile ','Mobile;','Windows Phone','IEMobile', 'iPad','Kindle','Sony Tablet','Nexus 7','Android Tablet'];
        	
            var th = this;
            var bool = false;
            
            arr.forEach(function(e, i, a) { //e:要素 i:index a:配列オブジェクト
            	if(th.isAgent(e)) {
                	bool = true;
                    return; //ループ脱出
                }
            });
            
            return bool;
        },

    } //return

})();



$(function(e){ //document.ready
    
    szcExec.addCurrent(); 
    szcExec.scrollFunc();
//    szcExec.setMapHeight(e);
//    szcExec.changeSizeAndPosiMapImg(e);
    szcExec.slideMenu();
    
    if(szcExec.isSpTab()) {
    	szcExec.setMapHeight(e);
    	szcExec.changeSizeAndPosiMapImg(e);
    }
    
    
}); //document.ready

})(jQuery);
