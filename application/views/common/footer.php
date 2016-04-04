    </div>
    <footer>
        <div class="container text-center">
            <img src="<?php echo base_url('assets/img/footer-logo.png'); ?>" />
            <p>
                서울특별시 강남구 학동로33길 17(논현동) 수산빌딩 2층&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;대표: 송지우
            </p>
            <p class="phone">
                02-543-3779&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fax 02-543-3795&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;010-5830-3779
            </p>
            <p class="copyright">
                Copyright &copy; LAB543. All Rights Reserved.
            </p>
        </div>
    </footer>
    </div>
    <!-- jQuery (necessary for Flat UI's JavaScript plugins) -->
    <script src="<?php echo base_url('assets/js/vendor/jquery.min.js'); ?>"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo base_url('assets/js/flat-ui.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/common.min.js'); ?>"></script>
    <script>
    var pos;
    $( document ).ready(function() {
        //scroll smoothly
        $('a[href*=#]:not([href=#])').click(function() {
            $('#navbar').collapse('hide');
            if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
                if (target.length) {
                    $('html,body').animate({
                        scrollTop: target.offset().top-10
                    }, 600);
                    return false;
                }
            }
        });
        
        //img move
        // get top positions and references to all images
        pos = $("img").map(function(){
          var $this = $(this);
          return {
            el: $this,
            top: $this.offset().top,
            bottom: $this.offset().top+$this.height()
          };
        }).get();

        // provide document scrolling
        $(window).on("scroll", imgMove).scroll();
        
        setInterval(function() {
            pos = $("img").map(function(){
              var $this = $(this);
              return {
                el: $this,
                top: $this.offset().top,
                bottom: $this.offset().top+$this.height()
              };
            }).get();
        }, 1000);
        
        function imgMove() {
            var h = Math.max(document.documentElement.clientHeight, window.innerHeight || 0)
            var scrollTop = $(document).scrollTop();
            var scrollBottom = $(document).scrollTop() + h;
          
            for(i=0; i< pos.length; i++) {
                if(scrollTop+88 <= pos[i].top  && pos[i].bottom <= scrollBottom ) {
                    //pos[i].el.animate({opacity:1}, 200);
                    pos[i].el.addClass('current-view');
                } else {
                    //pos[i].el.animate({opacity:0}, 200);
                    pos[i].el.removeClass('current-view');
                }
            }
        }
        
        //mail send
        $('#send-mail').on('click', function(e) {
            e.preventDefault(); e.stopPropagation();
            
            var error = false;
            
            $("#form_mail input[type=submit]").attr('disabled',true);
            
            $("#form_mail input[required=true], #form_mail textarea[required=true]").each(function(e) {
                if($(this).val() == '') {
                    alert($(this).attr('placeholder')+'는 필수항목 입니다.');
                    $(this).focus();
                    $("#form_mail input[type=submit]").attr('disabled',false);
                    
                    error = true;
                    
                    return false;
                }
            });
            
            if(error) return false;
            
            post_data = {
                'name'     	: $('input[name=name]').val(), 
                'phone'    	: $('input[name=phone]').val(), 
                'email'  	: $('input[name=email]').val(), 
                'title'  	: $('input[name=title]').val(), 
                'content'	: $('textarea[name=content]').val()
            };
            
            $.post('http://lab543.com/new/sendmail.php', post_data, function(response){  
                if(response.type == 'error'){ //load json data from server and output message     
                    alert('전송이 실패되었습니다.');
                }else{
                    alert('메일 전송 완료. 빠른 시일 내에 연락드리겠습니다. 감사합니다.');
                }
                $("#form_mail input[type=submit]").attr('disabled',false);
            }, 'json');
        });
    });
    </script>
  </body>
</html>
