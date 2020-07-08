<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Comment</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
            <h2 class="text-center">Comment Comment</h2>
            <input type="text" name="comment" class="form-control comment" id="input1" placeholder="Enter your comment">
            <button type="button" class="btn btn-primary mb-3 btn-save" data-toggle="modal">Add Comment</button>
            <h5 class="modal-title" id="exampleModalLabel">Comment</h5>
                <table id="mytable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Comment</th>
                        </tr>
                    </thead>
                    <tbody class="show_comment">
 
                    </tbody>
                </table>
            </div>
        </div>
    </div>
 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> 
    <script src="https://js.pusher.com/4.4/pusher.min.js"></script>
    <script src="https://rawgit.com/notifyjs/notifyjs/master/dist/notify.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function(){
            $.notify("Access granted", "success");
            show_comment();
            Pusher.logToConsole = true;
 
            var pusher = new Pusher('5ae581c740dcfc9c4309', {
                cluster: 'ap1',
                forceTLS: true
            });
 
            var channel = pusher.subscribe('my-channel');
            channel.bind('my-event', function(data) {
                if(data.message === 'success'){
                    $.notify("New Comment", "success");
                    show_comment();
                }
            });
 
            function show_comment(){
                $.ajax({
                    url   : '<?php echo site_url("comment/get_comment");?>',
                    type  : 'GET',
                    async : true,
                    dataType : 'json',
                    success : function(data){
                        var html = '';
                        var count = 1;
                        var i;
                        for(i=0; i<data.length; i++){
                            html += '<tr>'+
                                    '<td>'+ count++ +'</td>'+
                                    '<td>'+ data[i].text +'</td>'+
                                    '</tr>';
                        }
                        $('.show_comment').html(html);
                    }
 
                });
            } 

            $('.btn-save').on('click',function(){
                $.ajax({
                    url    : '<?php echo site_url("comment/create");?>',
                    method : 'POST',
                    data   : {comment: $('.comment').val()},
                    success: function(){
                        $('.comment').val("");
                    }
                });
            });
 
 
        });
    </script>
</body>
</html>