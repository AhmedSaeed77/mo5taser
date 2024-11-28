

<script>


 function updateProgress(id) {

    var content = id;
    $.ajax({
        url: "{{route('course-progress')}}",
        type: "POST",
        data: {
            content: content,
            _token: '{!! csrf_token() !!}',
        },
        success: function(data) {
            $('.progress-bar-content').css('width', data + '%');
            $('.percent').text(parseInt(data) + '%');

        },
        error: function(ex) {
            console.log(ex);
        }
    });
}

function zoomCounter(zoom_time) {
    var countDownDate = new Date(zoom_time).getTime();
    // Update the count down every 1 second
    zoomInterval = setInterval(function() {
        var now = new Date().getTime();
        var distance = countDownDate - now;
        if (distance > 0) {
            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 *
                60 * 24));
            var hours = Math.floor((distance % (1000 * 60 *
                    60 * 24)) /
                (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 *
                60 * 60)) / (
                1000 * 60));
            var seconds = Math.floor((distance % (1000 *
                60)) / 1000);
            document.getElementById("zoom_counter")
                .innerHTML = days +
                "d " +
                hours + "h " +
                minutes + "m " + seconds + "s ";
        }
        // If the count down is finished, write some text
        if (distance <= 0) {
            clearInterval(zoomInterval);
            $('#zoom_meeting').removeClass('d-none');
            var zoom = $('#zoom_meeting');
            var id = $("#progress_id").val();
            zoom.on('click', function() {
                $.ajax({
                    url:"{{ route('get-content') }}",
                    type: "POST",
                    data: {
                        id: id,
                        _token: '{!! csrf_token() !!}',
                    },
                    success: function(data) {
                        updateProgress($("#progress_id").val());
                        $(`#check-${id}`).html(
                            `<i class="fal fa-check"></i>`
                        );
                    },
                    error: function(ex) {
                        console.log(ex);
                    }
                });
            });
        }
    }, 1000);
}

function executePlyr() {
    const players = Array.from(document.querySelectorAll('.playerH'));

    players.forEach(function(player) {
        player = new Plyr(player, {
            //debug:true,
            autoplay: false,
            ratio: '16:9',
            defaultQuality: '720',
            //   poster: "http://www.clair-obscur.ch/2004/images/PLEIX_Itsu.jpg"
        })
        var test = jQuery(player).attr('class');
        var container = jQuery(player.media).parents('.video_container');
        var image = container.attr('data-plyr-poster');

        window.addEventListener("load", function() {
            setTimeout(() => {
                container.find('.plyr__poster').css({
                    'background-image':'url('+image+')'
                });
                container.css({opacity:1});
            }, 1000);
        })

        jQuery('.button').on('click',function(){
            player.pause();
        });
    });
}

$('.content_link').on('click', function(event) {
    event.preventDefault();
    let link = $(this);
    //clearInterval(zoomInterval);
    var id = $(this).data('id');
    $.ajax({
        url:"{{ route('get-content') }}",
        type: "POST",
        data: {
            id: id,
            _token: '{!! csrf_token() !!}',
        },
        success: function(data) {
            $(".content_link").each(function() {
                $(this).removeClass('active');
            });
            link.addClass('active');
            if (data != '') {
                $(".main_content_wrapper").empty();
                $(".main_content_wrapper").append(data[0]);

                $("#content_comments").empty();
                $("#content_comments").append(data[1]);
                $('#active_content').val(id);
            }
            executePlyr();
        },
        error: function(ex) {
            console.log(ex);
        },
        complete:function(data)
        {

            var type = $("#content_id").val();
            if(type == 'video')
            {
                var iframe = $('#course_video_url');
                var player = new Vimeo.Player(iframe);
                player.on('play', function() {
                    updateProgress($("#progress_id").val());
                    link.find('.info i').removeClass('fal fa-lock')
                    link.find('.info i').addClass('fal fa-check')
                });
            }
            if(type == 'note')
            {
                updateProgress($("#progress_id").val());
                link.find('.info i').removeClass('fal fa-lock')
                link.find('.info i').addClass('fal fa-check')
            }

            if(type == 'zoom')
            {

                var zoom_time = $("#zoom_counter").data('counter');
                if (zoom_time) {
                    zoomCounter(zoom_time)
                }
            }

            $('.replaies-btn').on('click', function() {
                $(this).parents('.single-comment').find('.replaies-comments').slideToggle();
            })

            $('.btn_comment_reply').on('click', function(event) {

                var comment = $(this).prev().val();
                var parent_id = $(this).data('content');
                var content_id = $('#active_content').val();

                var btn = $(this);

                if(comment)
                {
                    $.ajax({
                        url: "{{route('content-comment-reply')}}",
                        type: "POST",
                        data: {
                            comment: comment,
                            parent_id: parent_id,
                            content_id: content_id,
                            _token: '{!! csrf_token() !!}',
                        },
                        success: function(data) {
                            if(data[0] == 'added')
                            {
                                toastr.success({!! json_encode(Lang::get('lang.added')) !!});
                                btn.prev().val('');
                                btn.parent().prev().empty();
                                btn.parent().prev().append(data[1]);
                            }
                            else
                            {
                                toastr.error({!! json_encode(Lang::get('lang.not_found')) !!});
                            }
                        }
                    });
                }
                else
                {
                    toastr.error({!! json_encode(Lang::get('lang.add_comment_first')) !!});
                }

            });
        }
    });
});

$(() => {

    var iframe = $('#course_video_url');
    var player = new Vimeo.Player(iframe);

    player.on('play', function() {
        var id = $("#progress_id").val();
        console.log('THE VIDEO HAS PLAYING');
        updateProgress($("#progress_id").val());
        $(`#check-${id}`).html(
            `<i class="fal fa-check"></i>`
        );
    });
});
</script>
