<html>
    <head>
        <meta charset="utf-8">
        <title>Routing Test</title>
        
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="https://code.jquery.com/qunit/qunit-1.23.1.css">
        <script src="https://code.jquery.com/qunit/qunit-1.23.1.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="{{ URL::asset('js/functions.js') }}"></script>
    </head>
    <body>
        <script>
            // Add Task Tests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var task = {
                    'name': 'test',
                    'deadline': '2016-05-12',
                    'status': '10',
                    'priority': 'Low',
                    'project_id': 0,
                    'user_id': {{ Auth::user()->id }}
                };
                
            QUnit.test("Testing task manipulation", function (assert) {
                var done = assert.async();
                
                    addTask(task).then(function(response){
                        assert.notEqual(response['id'], null, 'Added New Task');
                        assert.equal(editTask(response), response, 'Task edited');

                        assert.equal(deleteTask(response), null, 'Exception for bad argument works');
                        assert.equal(deleteTask(response["id"]), "deleted", 'Deleted');
                        setTimeout(function(){
                            done();
                        },1000);
                    });
            });
        </script>
        <div id="qunit"></div>
        <?php //var_dump(Auth::user()); ?>
    </body>
    <footer>
        
    </footer>

</html>