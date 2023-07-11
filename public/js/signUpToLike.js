                        $('#cmnt').on( 'submit', function(e){
                        e.preventDefault();
                        $.ajax({
                        url:'/comment',
                        type:'GET',
                        data: {'movie_id': '{{ $play_data['id'] }}',comment:comment},
                        success: function(result) {
                        console.log(result);
                        jQuery.each(result.data,function(key, value){
                        $("#cmnt-box").empty();
                        $("#cmnt-box").prepend(
                        '<li class="media">'+
                        '<a href="#" class="pull-left mr-3">'+
                            '<img src="https://bootdey.com/img/Content/user_1.jpg" alt="" class="img-circle">'+
                        '</a>'+
                        '<div class="media-body">'+
                            '<span class="text-muted pull-right">'+
                                '<small class="text-muted">'+value.created_at+'</small>'+
                            '</span>'+
                            '<strong class="text-success">'+value.name+'</strong>'+
                            '<p class="text-dark">'+value.comment+'</p>'+
                        '</div>'+
                        '</li>'
                        );});

                        }});})