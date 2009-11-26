/**
 * achievementMenu plugin
 */
(function(){

    var $ = jQuery;

    $.fn.achievementMenu = function(options) {

        return this.each(function(){
            var achievement = $(this);
            var menu = $('<div class="achievementMenu"></div>')
                       .css({visibility:'hidden',display:'block',width:'150px',position:'absolute'})
                       .insertAfter(achievement);
            var button = $('<img class="achievementButton" src="/images/silk/cog.png" alt="options"/>')
                         .css({visibility:'visible',position:'relative',left:'-20px'})
                         .insertAfter(achievement);
            var closeTimer;

            $.each(options, function(i,option) {
                var item = $('<span class="achievementMenuOption">'
                            +'<a class="'+option.class+'" href="'+option.url+'" title="'+option.desc+'">'+option.title+'</a>'
                            +'</span>')
                menu.append(item);
            });

            //achievement.mouseover(function(){
            //    button.css('visibility','visible');
            //}).mouseout(function(){
            //    button.css('visibility','hidden');
            //});

            button.click(function () {
                menu.css({
                    visibility: 'visible',
                    position:   'absolute',
                    top:        achievement[0].offsetTop,
                    left:       achievement[0].offsetLeft+achievement[0].offsetWidth-menu[0].offsetWidth
                }).mouseout(startCloseTimer).mouseover(stopCloseTimer);
            });

            function startCloseTimer(){
                closeTimer = setTimeout(function() {
                    menu.css({visibility:'hidden'});
                },500);
            }

            function stopCloseTimer(){
                if (closeTimer!=undefined)
                    clearTimeout(closeTimer);
            }
        });
    }
})();
